<?php

namespace App\Exports\Sheets;

use App\Models\FasilitasKesehatan;
use App\Models\RekapGiziBalita;
use App\Models\RekapImunisasi;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SigaGiziSheet implements FromArray, WithHeadings, WithTitle, WithStyles
{
    public function __construct(protected int $tahun, protected int $bulan) {}

    public function title(): string { return 'SIGA - Gizi & Imunisasi'; }

    public function headings(): array
    {
        return [
            'Kode Faskes', 'Nama Faskes', 'Kecamatan', 'Bulan', 'Tahun',
            'Balita Ditimbang', 'Gizi Baik', 'Gizi Kurang', 'Gizi Buruk',
            'Stunting', 'Wasting', 'Overweight',
            'Imunisasi BCG', 'Imunisasi Polio 1', 'Imunisasi DPT-HB-Hib 1', 'Imunisasi Campak-Rubela',
        ];
    }

    public function array(): array
    {
        $rows = [];
        foreach (FasilitasKesehatan::all() as $f) {
            $gizi = RekapGiziBalita::where('faskes_id', $f->id)->where('tahun', $this->tahun)->where('bulan', $this->bulan)->first();
            $imun = fn($j) => \App\Models\RekapImunisasi::where('faskes_id', $f->id)->where('tahun', $this->tahun)->where('bulan', $this->bulan)->where('jenis_imunisasi', $j)->value('jumlah_diberikan') ?? 0;

            $rows[] = [
                $f->id, $f->nama_faskes, $f->kecamatan, $this->bulan, $this->tahun,
                $gizi->total_balita_ditimbang ?? 0,
                $gizi->gizi_baik   ?? 0,
                $gizi->gizi_kurang ?? 0,
                $gizi->gizi_buruk  ?? 0,
                $gizi->stunting    ?? 0,
                $gizi->wasting     ?? 0,
                $gizi->overweight  ?? 0,
                $imun('BCG'), $imun('Polio 1'), $imun('DPT-HB-Hib 1'), $imun('Campak-Rubela'),
            ];
        }
        return $rows;
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'e67e22']]],
        ];
    }
}
