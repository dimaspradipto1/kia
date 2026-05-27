<?php

namespace App\DataTables;

use App\Models\About;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AboutDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('gambar', function ($row) {
                $img = $row->defaultImage;
                if ($img) {
                    return '<img src="' . $img->url . '" alt="' . e($img->keterangan ?? 'Gambar') . '"
                                style="width:60px;height:60px;object-fit:cover;border-radius:8px;border:1px solid #dee2e6;">';
                }
                return '<span class="badge bg-secondary">Tidak Ada</span>';
            })
            ->addColumn('jumlah_gambar', function ($row) {
                $count = $row->images->count();
                return '<span class="badge bg-info text-white">' . $count . ' foto</span>';
            })
            ->editColumn('is_active', function ($row) {
                return $row->is_active
                    ? '<span class="badge bg-success">Aktif</span>'
                    : '<span class="badge bg-danger">Non-Aktif</span>';
            })
            ->addColumn('action', function ($row) {
                return '<div class="d-flex justify-content-center gap-1">
                            <a href="' . route('abouts.show', $row->id) . '" class="btn btn-info btn-sm text-white" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="' . route('abouts.edit', $row->id) . '" class="btn btn-warning btn-sm" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="' . route('abouts.destroy', $row->id) . '" method="POST" class="d-inline delete-form">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="button" class="btn btn-danger btn-sm btn-delete" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>';
            })
            ->rawColumns(['gambar', 'jumlah_gambar', 'is_active', 'action']);
    }

    public function query(About $model): QueryBuilder
    {
        return $model->newQuery()->with(['defaultImage', 'images']);
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('about-table')
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
            Column::computed('gambar')->title('Gambar')->addClass('text-center')->width(80),
            Column::make('judul')->title('Judul'),
            Column::computed('jumlah_gambar')->title('Foto')->addClass('text-center')->width(80),
            Column::make('is_active')->title('Status')->addClass('text-center')->width(90),
            Column::computed('action')->exportable(false)->printable(false)->width(140)->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'About_' . date('YmdHis');
    }
}
