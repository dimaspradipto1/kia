<?php

namespace App\Exports\Sheets;

use App\Models\KbPascaSalin;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;

class KbPascaSalinSheet implements FromCollection, WithHeadings, WithTitle, WithMapping
{
    public function __construct(protected int $tahun, protected int $bulan) {}

    public function collection()
    {
        return KbPascaSalin::with(['bukuKia.profilIbu', 'fasilitasKesehatan'])
            ->whereYear('tanggal_mulai', $this->tahun)
            ->whereMonth('tanggal_mulai', $this->bulan)
            ->get();
    }

    public function title(): string
    {
        return 'KB Pasca Salin';
    }

    public function headings(): array
    {
        return [
            'No', 'Nama Ibu', 'Fasilitas Kesehatan', 'Metode KB', 'Tanggal Mulai', 'Catatan',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;
        return [
            $no,
            $row->bukuKia->profilIbu->nama_lengkap ?? '-',
            $row->fasilitasKesehatan->nama_faskes ?? '-',
            $row->metode_kb,
            $row->tanggal_mulai,
            $row->catatan ?? '-',
        ];
    }
}
