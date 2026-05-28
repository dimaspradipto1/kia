<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\BukuKia;
use App\Models\KunjunganAnc;
use App\Models\TumbuhKembang;
use App\Models\ImunisasiAnak;
use App\Notifications\KiaNotification;
use Carbon\Carbon;

class CheckNotifikasiCommand extends Command
{
    protected $signature   = 'notif:cek-harian';
    protected $description = 'Cek dan kirim notifikasi harian KIA (ANC, TTD, imunisasi, stunting, dll)';

    public function handle(): void
    {
        $today    = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        $this->info('Mengirim notifikasi harian KIA...');

        $this->ttdHarian($today);
        $this->ancReminder($today, $tomorrow);
        $this->imunisasiMendatang($today, $tomorrow);
        $this->stuntingAlert();
        $this->pasienBelumAnc($today);
        $this->posyanduBulanan($today);

        $this->info('Selesai.');
    }

    // ── 1. Pengingat TTD harian → semua ibu hamil ──────────────────────────
    private function ttdHarian(Carbon $today): void
    {
        $ibuHamils = User::whereHas('role', fn($q) => $q->where('nama_role', 'ibu hamil'))
            ->whereHas('profilIbu.bukuKias', fn($q) => $q->where('status', 'aktif'))
            ->get();

        foreach ($ibuHamils as $user) {
            // Skip if already sent today
            if ($user->notifications()
                ->where('type', KiaNotification::class)
                ->whereDate('created_at', $today)
                ->whereJsonContains('data->tipe', 'ttd_harian')
                ->exists()) {
                continue;
            }

            $user->notify(new KiaNotification(
                tipe : 'ttd_harian',
                judul: 'Pengingat Tablet Tambah Darah (TTD)',
                pesan: 'Jangan lupa minum Tablet Tambah Darah (TTD/MMS) hari ini! Konsumsi rutin setiap hari penting untuk kesehatan ibu dan bayi.',
                link : route('pencatatan-ttd.index'),
                icon : 'bi-capsule'
            ));
        }

        $this->line("  TTD harian: {$ibuHamils->count()} ibu hamil.");
    }

    // ── 2. ANC reminder H-1 & H-hari ───────────────────────────────────────
    private function ancReminder(Carbon $today, Carbon $tomorrow): void
    {
        // Estimate next ANC: K1=minggu 8-12, K2=mg 24-28, K4=mg 36, K6=mg 38-40
        // Simplified: if last ANC was >4 weeks ago and no ANC today → alert nakes
        $overdue = KunjunganAnc::with(['bukuKia.profilIbu.user', 'bukuKia'])
            ->whereHas('bukuKia', fn($q) => $q->where('status', 'aktif'))
            ->where('tanggal_kunjungan', '<=', $today->copy()->subWeeks(4))
            ->whereDoesntHave('bukuKia.kunjunganAncs', fn($q) => $q->where('tanggal_kunjungan', '>=', $today->copy()->subWeeks(4)))
            ->get()
            ->unique('buku_kia_id');

        $count = 0;
        foreach ($overdue as $anc) {
            $ibu = optional($anc->bukuKia)->profilIbu;
            $user = optional($ibu)->user;
            if (!$user) continue;

            if ($user->notifications()
                ->whereDate('created_at', $today)
                ->whereJsonContains('data->tipe', 'anc_reminder')
                ->exists()) {
                continue;
            }

            $user->notify(new KiaNotification(
                tipe : 'anc_reminder',
                judul: 'Pengingat Kunjungan ANC',
                pesan: 'Sudah lebih dari 4 minggu sejak kunjungan ANC terakhir Anda. Segera jadwalkan kunjungan ke fasilitas kesehatan.',
                link : route('kunjungan-anc.index'),
                icon : 'bi-hospital'
            ));
            $count++;

            // Also alert nakes
            $nakes = User::whereHas('role', fn($q) => $q->where('nama_role', 'nakes'))->get();
            foreach ($nakes as $n) {
                $n->notify(new KiaNotification(
                    tipe : 'pasien_belum_anc',
                    judul: 'Pasien Belum ANC Sesuai Jadwal',
                    pesan: "Ibu {$ibu->nama_lengkap} belum melakukan kunjungan ANC lebih dari 4 minggu.",
                    link : route('kunjungan-anc.index'),
                    icon : 'bi-exclamation-triangle'
                ));
            }
        }

        $this->line("  ANC reminder: {$count} ibu hamil terdeteksi overdue.");
    }

    // ── 3. Notifikasi imunisasi anak mendatang ──────────────────────────────
    private function imunisasiMendatang(Carbon $today, Carbon $tomorrow): void
    {
        // Check children who haven't received BCG (first immunization, should be at birth/1 month)
        // and children who are 2 months old and haven't had DPT-HB-Hib1
        $jadwalImunisasi = [
            ['jenis' => 'BCG',         'usia_bulan_maks' => 1],
            ['jenis' => 'Hepatitis B', 'usia_bulan_maks' => 1],
            ['jenis' => 'Polio 1',     'usia_bulan_maks' => 2],
            ['jenis' => 'DPT-HB-Hib 1','usia_bulan_maks'=> 3],
        ];

        $count = 0;
        foreach ($jadwalImunisasi as $jadwal) {
            $anakBelumImunisasi = \App\Models\ProfilAnak::with(['bukuKia.profilIbu.user'])
                ->whereDoesntHave('imunisasiAnaks', fn($q) => $q->where('jenis_imunisasi', 'LIKE', "%{$jadwal['jenis']}%"))
                ->whereRaw("TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) >= ?", [$jadwal['usia_bulan_maks']])
                ->whereRaw("TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) <= ?", [$jadwal['usia_bulan_maks'] + 1])
                ->get();

            foreach ($anakBelumImunisasi as $anak) {
                $user = optional(optional($anak->bukuKia)->profilIbu)->user;
                if (!$user) continue;

                if ($user->notifications()
                    ->whereDate('created_at', $today)
                    ->whereJsonContains('data->tipe', 'imunisasi_reminder')
                    ->whereJsonContains('data->pesan', $jadwal['jenis'])
                    ->exists()) {
                    continue;
                }

                $user->notify(new KiaNotification(
                    tipe : 'imunisasi_reminder',
                    judul: 'Jadwal Imunisasi Anak',
                    pesan: "Anak {$anak->nama_lengkap} perlu mendapatkan imunisasi {$jadwal['jenis']}. Segera kunjungi fasilitas kesehatan.",
                    link : route('imunisasi-anak.index'),
                    icon : 'bi-shield-plus'
                ));
                $count++;
            }
        }

        $this->line("  Imunisasi reminder: {$count} notifikasi dikirim.");
    }

    // ── 4. Alert stunting → nakes ───────────────────────────────────────────
    private function stuntingAlert(): void
    {
        $stuntingBaru = TumbuhKembang::with(['profilAnak', 'nakes'])
            ->where('status_stunting', 'stunting')
            ->whereDate('created_at', Carbon::today())
            ->get();

        $nakes = User::whereHas('role', fn($q) => $q->where('nama_role', 'nakes'))->get();

        foreach ($stuntingBaru as $tk) {
            $namaAnak = optional($tk->profilAnak)->nama_lengkap ?? 'Tidak diketahui';
            foreach ($nakes as $n) {
                if ($n->notifications()
                    ->whereDate('created_at', Carbon::today())
                    ->whereJsonContains('data->tipe', 'stunting_alert')
                    ->whereJsonContains('data->pesan', $namaAnak)
                    ->exists()) {
                    continue;
                }

                $n->notify(new KiaNotification(
                    tipe : 'stunting_alert',
                    judul: 'Alert Stunting Balita',
                    pesan: "Balita {$namaAnak} terindikasi stunting (BB/TB tidak sesuai standar WHO). Perlu tindak lanjut segera.",
                    link : route('tumbuh-kembang.index'),
                    icon : 'bi-graph-down-arrow'
                ));
            }
        }

        $this->line("  Stunting alert: {$stuntingBaru->count()} kasus hari ini.");
    }

    // ── 5. Pasien belum ANC → nakes (sudah di ancReminder, ini untuk admin) ─
    private function pasienBelumAnc(Carbon $today): void
    {
        // Alert admin tentang pasien aktif yang belum ANC sama sekali bulan ini
        $bulanIni = BukuKia::where('status', 'aktif')
            ->whereDoesntHave('kunjunganAncs', fn($q) => $q->whereMonth('tanggal_kunjungan', $today->month)->whereYear('tanggal_kunjungan', $today->year))
            ->count();

        if ($bulanIni > 0 && $today->day === 15) {
            $admins = User::whereHas('role', fn($q) => $q->where('nama_role', 'administrator'))->get();
            foreach ($admins as $admin) {
                $admin->notify(new KiaNotification(
                    tipe : 'rekap_anc',
                    judul: 'Rekap: Ibu Hamil Belum ANC Bulan Ini',
                    pesan: "Ada {$bulanIni} ibu hamil aktif yang belum melakukan kunjungan ANC bulan " . $today->translatedFormat('F Y') . '.',
                    link : route('laporan.statistik'),
                    icon : 'bi-clipboard-data'
                ));
            }
        }

        $this->line("  Pasien belum ANC bulan ini: {$bulanIni} orang.");
    }

    // ── 6. Pengingat posyandu bulanan (setiap tanggal 1) ───────────────────
    private function posyanduBulanan(Carbon $today): void
    {
        if ($today->day !== 1) return;

        $allUsers = User::whereHas('role', fn($q) => $q->whereIn('nama_role', ['ibu hamil', 'nakes']))->get();
        $bulan    = $today->translatedFormat('F Y');

        foreach ($allUsers as $user) {
            $user->notify(new KiaNotification(
                tipe : 'posyandu_bulanan',
                judul: 'Pengingat Posyandu Bulanan',
                pesan: "Posyandu bulan {$bulan} akan segera dilaksanakan. Pastikan membawa buku KIA dan hadir tepat waktu.",
                link : route('dashboard'),
                icon : 'bi-calendar-heart'
            ));
        }

        $this->line("  Posyandu bulanan: {$allUsers->count()} notifikasi dikirim.");
    }
}
