<?php

namespace App\DataTables;

use App\Models\KategoriArtikel;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class KategoriArtikelDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('jumlah_artikel', function ($row) {
                $count = $row->artikels_count ?? 0;
                return '<span class="badge rounded-pill" style="background:#EC1E88;font-size:.8rem;">' . $count . ' artikel</span>';
            })
            ->addColumn('action', function ($row) {
                return '<div class="d-flex justify-content-center gap-1">
                            <a href="' . route('kategori-artikel.edit', $row->id) . '" class="btn btn-warning btn-sm" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="' . route('kategori-artikel.destroy', $row->id) . '" method="POST" class="d-inline delete-form">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="button" class="btn btn-danger btn-sm btn-delete" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>';
            })
            ->rawColumns(['action', 'jumlah_artikel']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(KategoriArtikel $model): QueryBuilder
    {
        return $model->newQuery()->withCount('artikels');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('kategori-artikel-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload'),
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('No')->width(50)->addClass('text-center'),
            Column::make('nama')->title('Nama Kategori'),
            Column::make('slug')->title('Slug'),
            Column::make('jumlah_artikel')->title('Jumlah Artikel')->addClass('text-center')->orderable(false)->searchable(false),
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
        return 'KategoriArtikel_' . date('YmdHis');
    }
}
