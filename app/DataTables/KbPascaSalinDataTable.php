<?php

namespace App\DataTables;

use App\Models\KbPascaSalin;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class KbPascaSalinDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<KbPascaSalin> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('action', function ($row) {
                $btn = '<div class="d-flex justify-content-center gap-1">
                            <a href="' . route('kb-pasca-salin.edit', $row->id) . '" class="btn btn-warning btn-sm" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="' . route('kb-pasca-salin.destroy', $row->id) . '" method="POST" class="d-inline delete-form">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="button" class="btn btn-danger btn-sm btn-delete" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>';
                return $btn;
            })
            ->editColumn('buku_kia', function ($row) {
                $ibuName = $row->bukuKia->profilIbu->nama_lengkap ?? '-';
                $noReg = $row->bukuKia->no_reg_kohort_ibu ?? '-';
                return '<div><strong>' . $ibuName . '</strong><br><small class="text-muted">Reg Kohort: ' . $noReg . '</small></div>';
            })
            ->editColumn('nakes', function ($row) {
                return $row->nakes->name ?? '-';
            })
            ->editColumn('fasilitas_kesehatan', function ($row) {
                return $row->fasilitasKesehatan->nama_faskes ?? '-';
            })
            ->editColumn('tanggal_mulai', function ($row) {
                return $row->tanggal_mulai ? \Carbon\Carbon::parse($row->tanggal_mulai)->translatedFormat('d F Y') : '-';
            })
            ->rawColumns(['buku_kia', 'action']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<KbPascaSalin>
     */
    public function query(KbPascaSalin $model): QueryBuilder
    {
        $query = $model->newQuery()->with(['bukuKia.profilIbu', 'nakes', 'fasilitasKesehatan']);

        if (auth()->user()->role->nama_role === 'ibu hamil') {
            $query->whereHas('bukuKia.profilIbu', function ($q) {
                $q->where('user_id', auth()->id());
            });
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('kbpascasalin-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(5)
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
        return [
            Column::make('DT_RowIndex')->title('No')->width(50),
            Column::make('buku_kia')->title('Pasien / Buku KIA')->orderable(false),
            Column::make('nakes')->title('Petugas Kesehatan')->orderable(false),
            Column::make('fasilitas_kesehatan')->title('Fasilitas Kesehatan')->orderable(false),
            Column::make('metode_kb')->title('Metode KB'),
            Column::make('tanggal_mulai')->title('Tanggal Mulai'),
            Column::make('catatan')->title('Catatan'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(100)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'KbPascaSalin_' . date('YmdHis');
    }
}
