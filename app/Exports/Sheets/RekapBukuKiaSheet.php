<?php

namespace App\Exports\Sheets;

use App\Models\BukuKia;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;

class RekapBukuKiaSheet implements FromCollection, WithHeadings, WithTitle, WithMapping
{
    protected $tahun;
    protected $bulan;
    protected static $rowNum = 0;

    public function __construct(int $tahun, int $bulan)
    {
        $this->tahun = $tahun;
        $this->bulan = $bulan;
        self::$rowNum = 0;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return BukuKia::with(['profilIbu', 'fasilitasKesehatan', 'kunjunganAncs', 'pemantauanNifas'])
            ->whereYear('diterbitkan_pada', $this->tahun)
            ->whereMonth('diterbitkan_pada', $this->bulan)
            ->get();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Rekap Buku KIA';
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'No. Registrasi Kohort Ibu',
            'No. Registrasi Kohort Bayi',
            'No. Registrasi Kohort Balita',
            'Nama Lengkap Ibu',
            'NIK Ibu',
            'Fasilitas Kesehatan',
            'Diterbitkan Pada',
            'Diterbitkan Oleh',
            'Status',
            'Jumlah Kunjungan ANC',
            'Jumlah Kunjungan Nifas'
        ];
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        self::$rowNum++;
        return [
            self::$rowNum,
            $row->no_reg_kohort_ibu ?? '-',
            $row->no_reg_kohort_bayi ?? '-',
            $row->no_reg_kohort_balita ?? '-',
            $row->profilIbu->nama_lengkap ?? '-',
            $row->profilIbu->nik ?? '-',
            $row->fasilitasKesehatan->nama_faskes ?? '-',
            $row->diterbitkan_pada ? \Carbon\Carbon::parse($row->diterbitkan_pada)->format('Y-m-d') : '-',
            $row->diterbitkan_oleh ?? '-',
            $row->status ?? '-',
            $row->kunjunganAncs->count(),
            $row->pemantauanNifas->count(),
        ];
    }
}
