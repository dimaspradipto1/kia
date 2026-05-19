<?php

namespace App\Exports\Sheets;

use App\Models\IndikatorKematian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;

class IndikatorKematianSheet implements FromCollection, WithHeadings, WithTitle, WithMapping
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
        return IndikatorKematian::with(['faskes', 'wilayah'])
            ->where('tahun', $this->tahun)
            ->where('bulan', $this->bulan)
            ->get();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Indikator Kematian';
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
            'Kematian Ibu',
            'Kematian Bayi',
            'Kematian Balita',
            'Penyebab Utama'
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
            $row->kematian_ibu,
            $row->kematian_bayi,
            $row->kematian_balita,
            $row->penyebab_utama ?? '-',
        ];
    }
}
