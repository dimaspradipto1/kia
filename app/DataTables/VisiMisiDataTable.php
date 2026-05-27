<?php

namespace App\DataTables;

use App\Models\VisiMisi;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Str;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class VisiMisiDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('visi', function ($row) {
                return '<span title="' . e($row->visi) . '">' . e(Str::limit($row->visi, 80)) . '</span>';
            })
            ->addColumn('jumlah_misi', function ($row) {
                $count = is_array($row->misi) ? count($row->misi) : 0;
                return '<span class="badge bg-primary">' . $count . ' poin</span>';
            })
            ->addColumn('jumlah_nilai', function ($row) {
                $count = is_array($row->nilai_items) ? count($row->nilai_items) : 0;
                return '<span class="badge bg-info text-dark">' . $count . ' item</span>';
            })
            ->editColumn('is_active', function ($row) {
                return $row->is_active
                    ? '<span class="badge bg-success">Aktif</span>'
                    : '<span class="badge bg-danger">Non-Aktif</span>';
            })
            ->addColumn('action', function ($row) {
                return '<div class="d-flex justify-content-center gap-1">
                            <a href="' . route('visi-misi.show', $row->id) . '" class="btn btn-info btn-sm text-white" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="' . route('visi-misi.edit', $row->id) . '" class="btn btn-warning btn-sm" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="' . route('visi-misi.destroy', $row->id) . '" method="POST" class="d-inline delete-form">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="button" class="btn btn-danger btn-sm btn-delete" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>';
            })
            ->rawColumns(['visi', 'jumlah_misi', 'jumlah_nilai', 'is_active', 'action']);
    }

    public function query(VisiMisi $model): QueryBuilder
    {
        return $model->newQuery()->latest();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('visimisi-table')
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
            Column::make('visi')->title('Visi'),
            Column::computed('jumlah_misi')->title('Jumlah Misi')->addClass('text-center')->width(100),
            Column::computed('jumlah_nilai')->title('Nilai Item')->addClass('text-center')->width(100),
            Column::make('is_active')->title('Status')->addClass('text-center')->width(90),
            Column::computed('action')->exportable(false)->printable(false)->width(140)->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'VisiMisi_' . date('YmdHis');
    }
}
