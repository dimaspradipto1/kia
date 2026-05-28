<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LaporanKiaExport implements WithMultipleSheets
{
    protected $tahun;
    protected $bulan;

    public function __construct(int $tahun, int $bulan)
    {
        $this->tahun = $tahun;
        $this->bulan = $bulan;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        return [
            new Sheets\RekapCakupanKiaSheet($this->tahun, $this->bulan),
            new Sheets\RekapImunisasiSheet($this->tahun, $this->bulan),
            new Sheets\RekapGiziBalitaSheet($this->tahun, $this->bulan),
            new Sheets\RekapTtdSheet($this->tahun, $this->bulan),
            new Sheets\IndikatorKematianSheet($this->tahun, $this->bulan),
            new Sheets\KbPascaSalinSheet($this->tahun, $this->bulan),
            new Sheets\RekapBukuKiaSheet($this->tahun, $this->bulan),
        ];
    }
}
