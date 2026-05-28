<?php

namespace App\DataTables;

use App\Models\HasilLabIbu;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class HasilLabIbuDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<HasilLabIbu> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('action', function ($row) {
                if (auth()->user()->role->nama_role === 'ibu hamil') {
                    return '-';
                }
                return '<div class="d-flex justify-content-center gap-1">
                    <a href="' . route('hasil-lab-ibu.edit', $row->id) . '" class="btn btn-warning btn-sm text-white" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '" title="Hapus">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>';
            })
            ->addColumn('ibu_hamil', function ($row) {
                $namaIbu = $row->kunjunganAnc->bukuKia->profilIbu->nama_lengkap ?? 'Tidak Diketahui';
                $kohort = $row->kunjunganAnc->bukuKia->no_reg_kohort_ibu ?? '-';
                return '<div class="fw-bold text-dark">' . $namaIbu . '</div>
                        <small class="text-muted text-xs">Kohort: ' . $kohort . '</small>';
            })
            ->addColumn('anc_kunjungan', function ($row) {
                $trimester = $row->kunjunganAnc->trimester ?? '-';
                $kunjungan = $row->kunjunganAnc->kunjungan_ke ?? '-';
                $tanggal = $row->kunjunganAnc->tanggal_kunjungan ? \Carbon\Carbon::parse($row->kunjunganAnc->tanggal_kunjungan)->translatedFormat('d M Y') : '-';
                
                return '<div class="fw-semibold text-pink">Trimester ' . $trimester . ' (K' . $kunjungan . ')</div>
                        <small class="text-muted text-xs">' . $tanggal . '</small>';
            })
            ->editColumn('jenis_pemeriksaan', function ($row) {
                return '<span class="fw-semibold text-teal">' . $row->jenis_pemeriksaan . '</span>';
            })
            ->addColumn('hasil_lengkap', function ($row) {
                return '<strong>' . $row->hasil . '</strong> <small class="text-muted">' . $row->satuan . '</small>';
            })
            ->addColumn('nilai_normal_lengkap', function ($row) {
                return '<span class="text-dark fw-medium">' . $row->nilai_normal . '</span> <small class="text-muted">' . $row->satuan . '</small>';
            })
            ->editColumn('tanggal_periksa', function ($row) {
                return \Carbon\Carbon::parse($row->tanggal_periksa)->translatedFormat('d F Y');
            })
            ->addColumn('status_klinis', function ($row) {
                $jenis = strtolower($row->jenis_pemeriksaan);
                $hasil = trim(strtolower($row->hasil));
                
                if (str_contains($jenis, 'hemoglobin') || str_contains($jenis, 'hb')) {
                    $val = floatval($row->hasil);
                    if ($val > 0 && $val < 11.0) {
                        return '<span class="badge bg-danger">Anemia / Rendah</span>';
                    }
                    return '<span class="badge bg-success">Normal</span>';
                }
                
                if (str_contains($jenis, 'protein')) {
                    if (str_contains($hasil, '+') || str_contains($hasil, 'positif')) {
                        return '<span class="badge bg-danger">Positif (Rujukan!)</span>';
                    }
                    return '<span class="badge bg-success">Negatif (Normal)</span>';
                }

                if (str_contains($jenis, 'hiv') || str_contains($jenis, 'sifilis') || str_contains($jenis, 'hepatitis')) {
                    if (str_contains($hasil, 'reaktif') || str_contains($hasil, 'positif') || str_contains($hasil, '+')) {
                        return '<span class="badge bg-danger">Reaktif (Bahaya!)</span>';
                    }
                    return '<span class="badge bg-success">Non Reaktif</span>';
                }

                return '<span class="badge bg-light text-dark border">Terbaca</span>';
            })
            ->addColumn('nakes', function ($row) {
                return $row->nakes->name ?? '-';
            })
            ->rawColumns(['action', 'ibu_hamil', 'anc_kunjungan', 'jenis_pemeriksaan', 'hasil_lengkap', 'nilai_normal_lengkap', 'status_klinis'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @param HasilLabIbu $model
     * @return QueryBuilder<HasilLabIbu>
     */
    public function query(HasilLabIbu $model): QueryBuilder
    {
        $query = $model->newQuery()->with(['kunjunganAnc.bukuKia.profilIbu', 'nakes']);

        if (auth()->user()->role->nama_role === 'ibu hamil') {
            $query->whereHas('kunjunganAnc.bukuKia.profilIbu', function ($q) {
                $q->where('user_id', auth()->id());
            });
        }

        return $query->orderBy('tanggal_periksa', 'desc');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('hasillabibu-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(3)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        $cols = [
            Column::make('DT_RowIndex')->title('No')->width(50)->addClass('text-center'),
            Column::computed('ibu_hamil')->title('Ibu Hamil')->addClass('text-start'),
            Column::computed('anc_kunjungan')->title('Kunjungan ANC')->addClass('text-start'),
            Column::make('jenis_pemeriksaan')->title('Jenis Pemeriksaan')->addClass('text-start'),
            Column::computed('hasil_lengkap')->title('Hasil Lab')->addClass('text-center'),
            Column::computed('nilai_normal_lengkap')->title('Nilai Rujukan')->addClass('text-center'),
            Column::make('tanggal_periksa')->title('Tanggal Periksa')->addClass('text-start'),
            Column::computed('status_klinis')->title('Status')->addClass('text-center'),
            Column::computed('nakes')->title('Pemeriksa')->addClass('text-start'),
        ];

        if (auth()->user()->role->nama_role !== 'ibu hamil') {
            $cols[] = Column::computed('action')
                      ->exportable(false)
                      ->printable(false)
                      ->width(120)
                      ->addClass('text-center');
        }

        return $cols;
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'HasilLabIbu_' . date('YmdHis');
    }
}
