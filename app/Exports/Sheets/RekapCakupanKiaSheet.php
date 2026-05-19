<?php

namespace App\Exports\Sheets;

use App\Models\RekapCakupanKia;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;

class RekapCakupanKiaSheet implements FromCollection, WithHeadings, WithTitle, WithMapping
{
    protected $tahun;
    protected $bulan;

    public function __construct(int $tahun, int $bulan)
    {
        $this->tahun = $tahun;
        $this->bulan = $bulan;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return RekapCakupanKia::with(['faskes', 'wilayah'])
            ->where('tahun', $this->tahun)
            ->where('bulan', $this->bulan)
            ->get();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Cakupan KIA';
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Fasilitas Kesehatan',
            'Wilayah Kerja',
            'Tahun',
            'Bulan',
            'Kunjungan K1',
            'Kunjungan K4',
            'Kunjungan K6',
            'Persalinan Faskes',
            'Persalinan Non Faskes',
            'Nifas KF1',
            'Nifas KF2',
            'Nifas KF3',
            'KB Pasca Salin'
        ];
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->id,
            $row->faskes->nama_faskes ?? '-',
            $row->wilayah->nama_dinkes ?? '-',
            $row->tahun,
            $row->bulan,
            $row->k1_total,
            $row->k4_total,
            $row->k6_total,
            $row->persalinan_faskes,
            $row->persalinan_non_faskes,
            $row->nifas_kf1,
            $row->nifas_kf2,
            $row->nifas_kf3,
            $row->kb_pasca_salin,
        ];
    }
}
