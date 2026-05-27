<?php

namespace App\DataTables;

use App\Models\Team;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TeamDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('foto_preview', function ($row) {
                return '<img src="' . e($row->foto_url) . '" alt="' . e($row->nama) . '"
                            style="width:52px;height:52px;object-fit:cover;border-radius:50%;border:2px solid #EC1E88;">';
            })
            ->addColumn('sosial', function ($row) {
                $links = '';
                if ($row->linkedin)
                    $links .= '<a href="' . e($row->linkedin) . '" target="_blank" class="btn btn-outline-primary btn-sm py-0 px-2 me-1" title="LinkedIn"><i class="bi bi-linkedin"></i></a>';
                if ($row->tiktok)
                    $links .= '<a href="' . e($row->tiktok) . '" target="_blank" class="btn btn-sm py-0 px-2 me-1 text-dark" style="border:1px solid #333;" title="TikTok"><i class="bi bi-tiktok"></i></a>';
                if ($row->instagram)
                    $links .= '<a href="' . e($row->instagram) . '" target="_blank" class="btn btn-sm py-0 px-2 me-1" style="border:1px solid #E1306C;color:#E1306C;" title="Instagram"><i class="bi bi-instagram"></i></a>';
                if ($row->facebook)
                    $links .= '<a href="' . e($row->facebook) . '" target="_blank" class="btn btn-sm py-0 px-2 me-1" style="border:1px solid #1877F2;color:#1877F2;" title="Facebook"><i class="bi bi-facebook"></i></a>';
                return $links ?: '<span class="text-muted">—</span>';
            })
            ->editColumn('is_active', function ($row) {
                return $row->is_active
                    ? '<span class="badge bg-success">Aktif</span>'
                    : '<span class="badge bg-danger">Non-Aktif</span>';
            })
            ->addColumn('action', function ($row) {
                return '<div class="d-flex justify-content-center gap-1">
                            <a href="' . route('teams.show', $row->id) . '" class="btn btn-info btn-sm text-white" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="' . route('teams.edit', $row->id) . '" class="btn btn-warning btn-sm" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="' . route('teams.destroy', $row->id) . '" method="POST" class="d-inline delete-form">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="button" class="btn btn-danger btn-sm btn-delete" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>';
            })
            ->rawColumns(['foto_preview', 'sosial', 'is_active', 'action']);
    }

    public function query(Team $model): QueryBuilder
    {
        return $model->newQuery()->orderBy('urutan');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('team-table')
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
            Column::computed('foto_preview')->title('Foto')->addClass('text-center')->width(70),
            Column::make('nama')->title('Nama'),
            Column::make('jabatan')->title('Jabatan'),
            Column::make('urutan')->title('Urutan')->addClass('text-center')->width(70),
            Column::computed('sosial')->title('Sosial Media')->addClass('text-center')->width(160),
            Column::make('is_active')->title('Status')->addClass('text-center')->width(90),
            Column::computed('action')->exportable(false)->printable(false)->width(140)->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Team_' . date('YmdHis');
    }
}
