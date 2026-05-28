<?php

namespace App\DataTables;

use App\Models\Persalinan;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PersalinanDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Persalinan> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                if (auth()->user()->role->nama_role === 'ibu hamil') {
                    return '-';
                }
                $btn = '<div class="d-flex gap-2 justify-content-center">';
                $btn .= '<a href="' . route('persalinan.edit', $row->id) . '" class="btn btn-warning btn-sm text-white shadow-sm" style="border-radius:6px;" title="Edit"><i class="bi bi-pencil-fill"></i></a>';
                $btn .= '<button type="button" class="btn btn-danger btn-sm shadow-sm btn-delete" style="border-radius:6px;" data-id="' . $row->id . '" title="Hapus"><i class="bi bi-trash-fill"></i></button>';
                $btn .= '</div>';
                return $btn;
            })
            ->addColumn('buku_kia', function ($row) {
                $ibuName = $row->bukuKia->profilIbu->nama_lengkap ?? '-';
                $noReg = $row->bukuKia->no_reg_kohort_ibu ?? '-';
                return '<div><strong>' . $ibuName . '</strong><br><small class="text-muted">Reg Kohort: ' . $noReg . '</small></div>';
            })
            ->editColumn('fasilitas_kesehatan', function ($row) {
                return $row->fasilitasKesehatan->nama_faskes ?? '-';
            })
            ->addColumn('waktu_lahir', function ($row) {
                $tanggal = $row->tanggal_lahir ? \Carbon\Carbon::parse($row->tanggal_lahir)->translatedFormat('d M Y') : '-';
                $jam = $row->jam_lahir ?? '-';
                return '<div>' . $tanggal . '<br><small class="text-muted">' . $jam . ' WIB</small></div>';
            })
            ->addColumn('metrik_bayi', function ($row) {
                return '<div>BB: ' . $row->berat_bayi_kg . ' kg<br><small class="text-muted">PB: ' . $row->panjang_bayi_cm . ' cm</small></div>';
            })
            ->addColumn('apgar', function ($row) {
                return '1\': ' . $row->apgar_score_1 . ' | 5\': ' . $row->apgar_score_5;
            })
            ->editColumn('kondisi_ibu', function ($row) {
                $color = strtolower($row->kondisi_ibu) === 'sehat' ? 'success' : 'danger';
                return '<span class="badge bg-' . $color . '">' . $row->kondisi_ibu . '</span>';
            })
            ->editColumn('kondisi_bayi', function ($row) {
                $color = strtolower($row->kondisi_bayi) === 'sehat' ? 'success' : 'danger';
                return '<span class="badge bg-' . $color . '">' . $row->kondisi_bayi . '</span>';
            })
            ->rawColumns(['buku_kia', 'waktu_lahir', 'metrik_bayi', 'kondisi_ibu', 'kondisi_bayi', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @param Persalinan $model
     * @return QueryBuilder<Persalinan>
     */
    public function query(Persalinan $model): QueryBuilder
    {
        $query = $model->newQuery()->with(['bukuKia.profilIbu', 'fasilitasKesehatan', 'nakes']);

        if (auth()->user()->role->nama_role === 'ibu hamil') {
            $query->whereHas('bukuKia.profilIbu', function ($q) {
                $q->where('user_id', auth()->id());
            });
        }

        return $query->orderBy('tanggal_lahir', 'desc');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('persalinan-table')
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
            Column::computed('buku_kia')->title('Ibu Hamil / Buku KIA')->addClass('text-start'),
            Column::make('fasilitas_kesehatan')->title('Fasilitas Kesehatan')->addClass('text-start'),
            Column::computed('waktu_lahir')->title('Waktu Lahir')->addClass('text-start'),
            Column::make('jenis_persalinan')->title('Jenis Persalinan')->addClass('text-start'),
            Column::make('penolong')->title('Penolong')->addClass('text-start'),
            Column::computed('metrik_bayi')->title('Metrik Bayi')->addClass('text-start'),
            Column::computed('apgar')->title('Apgar Score')->addClass('text-center'),
            Column::make('kondisi_ibu')->title('Kondisi Ibu')->addClass('text-center'),
            Column::make('kondisi_bayi')->title('Kondisi Bayi')->addClass('text-center'),
        ];

        if (auth()->user()->role->nama_role !== 'ibu hamil') {
            $cols[] = Column::computed('action')
                        ->exportable(false)
                        ->printable(false)
                        ->width(100)
                        ->addClass('text-center');
        }

        return $cols;
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Persalinan_' . date('YmdHis');
    }
}
