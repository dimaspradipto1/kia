<?php

namespace App\DataTables;

use App\Models\Layanan;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Str;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class LayananDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('judul', function ($row) {
                $colors = Layanan::$temaColors[$row->tema] ?? Layanan::$temaColors['pink'];
                return '<span class="fw-bold">'
                    . '<i class="fa ' . e($row->ikon) . ' me-2" style="color:' . $colors['ikon'] . '"></i>'
                    . e($row->judul)
                    . '</span>';
            })
            ->editColumn('deskripsi', function ($row) {
                return '<span title="' . e($row->deskripsi) . '">' . e(Str::limit($row->deskripsi, 80)) . '</span>';
            })
            ->editColumn('tema', function ($row) {
                $colors = Layanan::$temaColors[$row->tema] ?? Layanan::$temaColors['pink'];
                return '<span class="badge" style="background:' . $colors['ikon'] . '">' . ucfirst($row->tema) . '</span>';
            })
            ->editColumn('urutan', function ($row) {
                return '<span class="badge bg-secondary">' . $row->urutan . '</span>';
            })
            ->editColumn('is_active', function ($row) {
                return $row->is_active
                    ? '<span class="badge bg-success">Aktif</span>'
                    : '<span class="badge bg-danger">Non-Aktif</span>';
            })
            ->addColumn('action', function ($row) {
                return '<div class="d-flex justify-content-center gap-1">
                            <a href="' . route('layanans.show', $row->id) . '" class="btn btn-info btn-sm text-white" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="' . route('layanans.edit', $row->id) . '" class="btn btn-warning btn-sm" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="' . route('layanans.destroy', $row->id) . '" method="POST" class="d-inline delete-form">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="button" class="btn btn-danger btn-sm btn-delete" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>';
            })
            ->rawColumns(['judul', 'deskripsi', 'tema', 'urutan', 'is_active', 'action']);
    }

    public function query(Layanan $model): QueryBuilder
    {
        return $model->newQuery()->orderBy('urutan')->orderBy('id');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('layanan-table')
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
                        Button::make('reload')
                    ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('No')->width(50)->addClass('text-center'),
            Column::make('judul')->title('Layanan'),
            Column::make('deskripsi')->title('Deskripsi'),
            Column::computed('tema')->title('Tema')->addClass('text-center')->width(90),
            Column::make('urutan')->title('Urutan')->addClass('text-center')->width(70),
            Column::make('is_active')->title('Status')->addClass('text-center')->width(90),
            Column::computed('action')->exportable(false)->printable(false)->width(140)->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Layanan_' . date('YmdHis');
    }
}
