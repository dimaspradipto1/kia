<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\SigaCakupanSheet;
use App\Exports\Sheets\SigaGiziSheet;
use App\Exports\Sheets\SigaKematianSheet;

class SigaExport implements WithMultipleSheets
{
    public function __construct(protected int $tahun, protected int $bulan) {}

    public function sheets(): array
    {
        return [
            new SigaCakupanSheet($this->tahun, $this->bulan),
            new SigaGiziSheet($this->tahun, $this->bulan),
            new SigaKematianSheet($this->tahun, $this->bulan),
        ];
    }
}
