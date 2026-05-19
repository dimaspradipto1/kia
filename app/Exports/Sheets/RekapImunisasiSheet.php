<?php

namespace App\Exports\Sheets;

use App\Models\RekapImunisasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;

class RekapImunisasiSheet implements FromCollection, WithHeadings, WithTitle, WithMapping
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
        return RekapImunisasi::with(['faskes', 'wilayah'])
            ->where('tahun', $this->tahun)
            ->where('bulan', $this->bulan)
            ->get();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Cakupan Imunisasi';
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
            'Jenis Imunisasi',
            'Jumlah Diberikan',
            'Target Sasaran',
            'Persentase Cakupan (%)'
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
            $row->jenis_imunisasi,
            $row->jumlah_diberikan,
            $row->target_sasaran,
            $row->persentase_cakupan . '%',
        ];
    }
}
