<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KunjunganAnc extends Model
{
    protected $table = 'kunjungan_ancs';

    protected static function booted(): void
    {
        $sync = function ($model) {
            $faskesId = $model->fasilitas_kesehatan_id;
            if (!$faskesId) return;

            $date = \Carbon\Carbon::parse($model->tanggal_kunjungan);
            $year = $date->year;
            $month = $date->month;

            $faskes = FasilitasKesehatan::find($faskesId);
            $wilayahId = $faskes ? $faskes->wilayah_id : null;
            if (!$wilayahId) {
                $wilayah = WilayaDinkes::first();
                $wilayahId = $wilayah ? $wilayah->id : 1;
            }

            $k1 = self::where('fasilitas_kesehatan_id', $faskesId)
                ->whereYear('tanggal_kunjungan', $year)
                ->whereMonth('tanggal_kunjungan', $month)
                ->where('kunjungan_ke', 1)
                ->count();

            $k4 = self::where('fasilitas_kesehatan_id', $faskesId)
                ->whereYear('tanggal_kunjungan', $year)
                ->whereMonth('tanggal_kunjungan', $month)
                ->where('kunjungan_ke', 4)
                ->count();

            $k6 = self::where('fasilitas_kesehatan_id', $faskesId)
                ->whereYear('tanggal_kunjungan', $year)
                ->whereMonth('tanggal_kunjungan', $month)
                ->where('kunjungan_ke', 6)
                ->count();

            RekapCakupanKia::updateOrCreate(
                [
                    'faskes_id' => $faskesId,
                    'wilayah_id' => $wilayahId,
                    'tahun' => $year,
                    'bulan' => $month
                ],
                [
                    'k1_total' => $k1,
                    'k4_total' => $k4,
                    'k6_total' => $k6,
                ]
            );
        };

        static::saved($sync);
        static::deleted($sync);
    }

    protected $fillable = [
        'buku_kia_id',
        'fasilitas_kesehatan_id',
        'trimester',
        'kunjungan_ke',
        'tanggal_kunjungan',
        'berat_badan',
        'tekanan_darah_sistolik',
        'tekanan_darah_diastolik',
        'tinggi_fundus_cm',
        'lila_cm',
        'denyut_jantung_janin',
        'letak_janin',
        'status_tt',
        'usg_dilakukan',
        'hasil_usg',
        'skrining_jiwa',
        'catatan',
        'nakes_id',
    ];

    public function bukuKia(): BelongsTo
    {
        return $this->belongsTo(BukuKia::class, 'buku_kia_id');
    }

    public function fasilitasKesehatan(): BelongsTo
    {
        return $this->belongsTo(FasilitasKesehatan::class, 'fasilitas_kesehatan_id');
    }

    public function nakes(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nakes_id');
    }

    public function hasilLabIbus(): HasMany
    {
        return $this->hasMany(HasilLabIbu::class, 'kunjungan_anc_id');
    }
}
