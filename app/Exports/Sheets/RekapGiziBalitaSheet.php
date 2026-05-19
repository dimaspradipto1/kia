<?php

namespace App\Exports\Sheets;

use App\Models\RekapGiziBalita;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;

class RekapGiziBalitaSheet implements FromCollection, WithHeadings, WithTitle, WithMapping
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
        return RekapGiziBalita::with(['faskes', 'wilayah'])
            ->where('tahun', $this->tahun)
            ->where('bulan', $this->bulan)
            ->get();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Gizi Balita';
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
            'Total Balita Ditimbang',
            'Gizi Baik',
            'Gizi Kurang',
            'Gizi Buruk',
            'Stunting',
            'Wasting',
            'Overweight'
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
            $row->total_balita_ditimbang,
            $row->gizi_baik,
            $row->gizi_kurang,
            $row->gizi_buruk,
            $row->stunting,
            $row->wasting,
            $row->overweight,
        ];
    }
}
