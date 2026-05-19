<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TumbuhKembang extends Model
{
    use HasFactory;

    protected $table = 'tumbuh_kembangs';

    protected static function booted(): void
    {
        $sync = function ($model) {
            $faskesId = $model->fasilitas_kesehatan_id;
            if (!$faskesId) return;

            $date = \Carbon\Carbon::parse($model->tanggal_ukur);
            $year = $date->year;
            $month = $date->month;

            $faskes = FasilitasKesehatan::find($faskesId);
            $wilayahId = $faskes ? $faskes->wilayah_id : null;
            if (!$wilayahId) {
                $wilayah = WilayaDinkes::first();
                $wilayahId = $wilayah ? $wilayah->id : 1;
            }

            $totalDitimbang = self::where('fasilitas_kesehatan_id', $faskesId)
                ->whereYear('tanggal_ukur', $year)
                ->whereMonth('tanggal_ukur', $month)
                ->count();

            $giziBaik = self::where('fasilitas_kesehatan_id', $faskesId)
                ->whereYear('tanggal_ukur', $year)
                ->whereMonth('tanggal_ukur', $month)
                ->where('status_gizi_bb_u', 'gizi baik')
                ->count();

            $giziKurang = self::where('fasilitas_kesehatan_id', $faskesId)
                ->whereYear('tanggal_ukur', $year)
                ->whereMonth('tanggal_ukur', $month)
                ->where('status_gizi_bb_u', 'gizi kurang')
                ->count();

            $giziBuruk = self::where('fasilitas_kesehatan_id', $faskesId)
                ->whereYear('tanggal_ukur', $year)
                ->whereMonth('tanggal_ukur', $month)
                ->where('status_gizi_bb_u', 'gizi buruk')
                ->count();

            $stunting = self::where('fasilitas_kesehatan_id', $faskesId)
                ->whereYear('tanggal_ukur', $year)
                ->whereMonth('tanggal_ukur', $month)
                ->where('status_stunting', 'stunting')
                ->count();

            RekapGiziBalita::updateOrCreate(
                [
                    'faskes_id' => $faskesId,
                    'wilayah_id' => $wilayahId,
                    'tahun' => $year,
                    'bulan' => $month
                ],
                [
                    'total_balita_ditimbang' => $totalDitimbang,
                    'gizi_baik' => $giziBaik,
                    'gizi_kurang' => $giziKurang,
                    'gizi_buruk' => $giziBuruk,
                    'stunting' => $stunting,
                ]
            );
        };

        static::saved($sync);
        static::deleted($sync);
    }

    protected $fillable = [
        'profil_anak_id',
        'fasilitas_kesehatan_id',
        'nakes_id',
        'tanggal_ukur',
        'usia_bulan',
        'berat_badan',
        'tinggi_badan',
        'lingkar_kepala',
        'lila_cm',
        'status_gizi_bb_u',
        'status_gizi_tb_u',
        'status_gizi_bb_tb',
        'status_stunting',
        'catatan',
    ];

    protected $casts = [
        'tanggal_ukur'   => 'date',
        'berat_badan'    => 'decimal:2',
        'tinggi_badan'   => 'decimal:2',
        'lingkar_kepala' => 'decimal:2',
        'lila_cm'        => 'decimal:2',
    ];

    public function profilAnak()
    {
        return $this->belongsTo(ProfilAnak::class, 'profil_anak_id');
    }

    public function fasilitasKesehatan()
    {
        return $this->belongsTo(FasilitasKesehatan::class, 'fasilitas_kesehatan_id');
    }

    public function nakes()
    {
        return $this->belongsTo(User::class, 'nakes_id');
    }
}
