<?php

namespace App\Exports\Sheets;

use App\Models\FasilitasKesehatan;
use App\Models\IndikatorKematian;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SigaKematianSheet implements FromArray, WithHeadings, WithTitle, WithStyles
{
    public function __construct(protected int $tahun, protected int $bulan) {}

    public function title(): string { return 'SIGA - AKI AKB'; }

    public function headings(): array
    {
        return [
            'Kode Faskes', 'Nama Faskes', 'Kecamatan', 'Kab/Kota', 'Bulan', 'Tahun',
            'Kematian Ibu (AKI)', 'Kematian Bayi (AKB)', 'Kematian Balita', 'Penyebab Utama',
        ];
    }

    public function array(): array
    {
        $rows = [];
        foreach (FasilitasKesehatan::all() as $f) {
            $k = IndikatorKematian::where('faskes_id', $f->id)->where('tahun', $this->tahun)->where('bulan', $this->bulan)->first();
            $rows[] = [
                $f->id, $f->nama_faskes, $f->kecamatan, $f->kab_kota, $this->bulan, $this->tahun,
                $k->kematian_ibu    ?? 0,
                $k->kematian_bayi   ?? 0,
                $k->kematian_balita ?? 0,
                $k->penyebab_utama  ?? '-',
            ];
        }
        return $rows;
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'c0392b']]],
        ];
    }
}
