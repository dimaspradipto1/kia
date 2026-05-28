<?php

namespace App\DataTables;

use App\Models\ArtikelEdukasi;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ArtikelEdukasiDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('kategori', function ($row) {
                return $row->kategoriArtikel
                    ? '<span class="badge rounded-pill" style="background:#EC1E88;font-size:.75rem;">'
                      . e($row->kategoriArtikel->nama) . '</span>'
                    : '<span class="text-muted">-</span>';
            })
            ->editColumn('status', function ($row) {
                if ($row->status === 'published') {
                    return '<span class="badge bg-success">Published</span>';
                }
                return '<span class="badge bg-secondary">Draft</span>';
            })
            ->editColumn('diterbitkan_pada', function ($row) {
                return $row->diterbitkan_pada
                    ? $row->diterbitkan_pada->format('d M Y')
                    : '<span class="text-muted">-</span>';
            })
            ->editColumn('judul', function ($row) {
                return '<strong>' . e(Str_limit($row->judul, 60)) . '</strong>';
            })
            ->addColumn('action', function ($row) {
                return '<div class="d-flex justify-content-center gap-1">
                            <a href="' . route('artikel-edukasi.edit', $row->id) . '"
                               class="btn btn-warning btn-sm" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="' . route('artikel-edukasi.destroy', $row->id) . '"
                                  method="POST" class="d-inline delete-form">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="button" class="btn btn-danger btn-sm btn-delete" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>';
            })
            ->rawColumns(['action', 'status', 'kategori', 'diterbitkan_pada', 'judul']);
    }

    public function query(ArtikelEdukasi $model): QueryBuilder
    {
        return $model->newQuery()
            ->with('kategoriArtikel')
            ->latest('diterbitkan_pada');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('artikel-edukasi-table')
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

    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('No')->width(50)->addClass('text-center'),
            Column::make('judul')->title('Judul Artikel'),
            Column::make('kategori')->title('Kategori')->orderable(false)->searchable(false),
            Column::make('penulis')->title('Penulis'),
            Column::make('status')->title('Status')->addClass('text-center'),
            Column::make('diterbitkan_pada')->title('Tgl Terbit')->addClass('text-center'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(100)
                  ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'ArtikelEdukasi_' . date('YmdHis');
    }
}

function Str_limit(string $value, int $limit): string
{
    return \Illuminate\Support\Str::limit($value, $limit);
}
