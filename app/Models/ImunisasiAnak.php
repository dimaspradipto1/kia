<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImunisasiAnak extends Model
{
    use HasFactory;

    protected $table = 'imunisasi_anaks';

    protected static function booted(): void
    {
        $sync = function ($model) {
            $faskesId = $model->fasilitas_kesehatan_id;
            if (!$faskesId) return;

            $jenisImunisasi = $model->jenis_imunisasi;
            if (!$jenisImunisasi) return;

            $date = \Carbon\Carbon::parse($model->tanggal_pemberian);
            $year = $date->year;
            $month = $date->month;

            $faskes = FasilitasKesehatan::find($faskesId);
            $wilayahId = $faskes ? $faskes->wilayah_id : null;
            if (!$wilayahId) {
                $wilayah = WilayaDinkes::first();
                $wilayahId = $wilayah ? $wilayah->id : 1;
            }

            $jumlahDiberikan = self::where('fasilitas_kesehatan_id', $faskesId)
                ->where('jenis_imunisasi', $jenisImunisasi)
                ->whereYear('tanggal_pemberian', $year)
                ->whereMonth('tanggal_pemberian', $month)
                ->count();

            $target = 50;
            $persentase = $target > 0 ? ($jumlahDiberikan / $target) * 100 : 0;

            RekapImunisasi::updateOrCreate(
                [
                    'faskes_id' => $faskesId,
                    'wilayah_id' => $wilayahId,
                    'tahun' => $year,
                    'bulan' => $month,
                    'jenis_imunisasi' => $jenisImunisasi
                ],
                [
                    'jumlah_diberikan' => $jumlahDiberikan,
                    'target_sasaran' => $target,
                    'persentase_cakupan' => $persentase
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
        'jenis_imunisasi',
        'dosis_ke',
        'tanggal_pemberian',
        'batch_vaksin',
        'efek_samping',
    ];

    protected $casts = [
        'tanggal_pemberian' => 'date',
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
