<?php

namespace App\Exports\Sheets;

use App\Models\FasilitasKesehatan;
use App\Models\RekapCakupanKia;
use App\Models\RekapTtd;
use App\Models\KbPascaSalin;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SigaCakupanSheet implements FromArray, WithHeadings, WithTitle, WithStyles
{
    public function __construct(protected int $tahun, protected int $bulan) {}

    public function title(): string { return 'SIGA - Cakupan KIA & KB'; }

    public function headings(): array
    {
        return [
            'Kode Faskes', 'Nama Puskesmas/Faskes', 'Kecamatan', 'Kab/Kota', 'Provinsi',
            'Bulan', 'Tahun',
            'K1 Murni', 'K4', 'K6',
            'Persalinan di Faskes', 'Persalinan Non Faskes',
            'KF1', 'KF2', 'KF3',
            'KB Pasca Salin', 'Mendapat TTD', 'Patuh Konsumsi TTD',
        ];
    }

    public function array(): array
    {
        $rows = [];
        $faskesList = FasilitasKesehatan::all();

        foreach ($faskesList as $f) {
            $cakupan = RekapCakupanKia::where('faskes_id', $f->id)->where('tahun', $this->tahun)->where('bulan', $this->bulan)->first();
            $ttd     = RekapTtd::where('faskes_id', $f->id)->where('tahun', $this->tahun)->where('bulan', $this->bulan)->first();
            $kb      = KbPascaSalin::where('fasilitas_kesehatan_id', $f->id)->whereYear('tanggal_mulai', $this->tahun)->whereMonth('tanggal_mulai', $this->bulan)->count();

            $rows[] = [
                $f->id,
                $f->nama_faskes,
                $f->kecamatan,
                $f->kab_kota,
                $f->provinsi,
                $this->bulan,
                $this->tahun,
                $cakupan->k1_total ?? 0,
                $cakupan->k4_total ?? 0,
                $cakupan->k6_total ?? 0,
                $cakupan->persalinan_faskes ?? 0,
                $cakupan->persalinan_non_faskes ?? 0,
                $cakupan->nifas_kf1 ?? 0,
                $cakupan->nifas_kf2 ?? 0,
                $cakupan->nifas_kf3 ?? 0,
                $kb,
                $ttd->mendapat_ttd ?? 0,
                $ttd->patuh_konsumsi ?? 0,
            ];
        }

        return $rows;
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '1e7e34']], 'font' => ['color' => ['rgb' => 'FFFFFF'], 'bold' => true]],
        ];
    }
}
