<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PencatatanTtd extends Model
{
    protected $guarded = [];

    public function bukuKia()
    {
        return $this->belongsTo(BukuKia::class, 'buku_kia_id');
    }

    protected static function booted(): void
    {
        $sync = function ($model) {
            $bukuKia = BukuKia::find($model->buku_kia_id);
            if (!$bukuKia) return;

            $faskesId = $bukuKia->fasilitas_kesehatan_id;
            if (!$faskesId) return;

            $date = \Carbon\Carbon::parse($model->tanggal);
            $year = $date->year;
            $month = $date->month;

            $faskes = FasilitasKesehatan::find($faskesId);
            $wilayahId = $faskes ? $faskes->wilayah_id : null;
            if (!$wilayahId) {
                $wilayah = WilayaDinkes::first();
                $wilayahId = $wilayah ? $wilayah->id : 1;
            }

            $totalTTD = self::whereHas('bukuKia', function ($q) use ($faskesId) {
                    $q->where('fasilitas_kesehatan_id', $faskesId);
                })
                ->whereYear('tanggal', $year)
                ->whereMonth('tanggal', $month)
                ->count();

            $patuh = self::whereHas('bukuKia', function ($q) use ($faskesId) {
                    $q->where('fasilitas_kesehatan_id', $faskesId);
                })
                ->whereYear('tanggal', $year)
                ->whereMonth('tanggal', $month)
                ->whereIn('diminum', ['Ya', '1', 'yes', 'Ya (Diminum)'])
                ->count();

            $target = max(50, $totalTTD);

            RekapTtd::updateOrCreate(
                [
                    'faskes_id' => $faskesId,
                    'wilayah_id' => $wilayahId,
                    'tahun' => $year,
                    'bulan' => $month
                ],
                [
                    'target_ibu_hamil' => $target,
                    'mendapat_ttd' => $totalTTD,
                    'patuh_konsumsi' => $patuh
                ]
            );
        };

        static::saved($sync);
        static::deleted($sync);
    }
}
