<?php

namespace App\DataTables;

use App\Models\BukuKia;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BukuKiaDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('action', function ($row) {
                return '<div class="d-flex justify-content-center gap-1">
                    <a href="' . route('buku-kia.show', $row->id) . '" class="btn btn-info btn-sm text-white shadow-xs" style="border-radius:20px; padding: 4px 10px;" title="Detail">
                        <i class="bi bi-eye"></i> Detail
                    </a>
                    <a href="' . route('pemantauan-nifas.create', ['buku_kia_id' => $row->id]) . '" class="btn btn-sm text-white shadow-xs" style="background-color: #16B3AC; border-radius:20px; padding: 4px 10px;" title="Input Nifas">
                        <i class="bi bi-activity"></i> +Nifas
                    </a>
                    <a href="' . route('kb-pasca-salin.create', ['buku_kia_id' => $row->id]) . '" class="btn btn-sm text-white shadow-xs" style="background-color: #EC1E88; border-radius:20px; padding: 4px 10px;" title="Input KB">
                        <i class="bi bi-heart-pulse-fill"></i> +KB
                    </a>
                    <a href="' . route('buku-kia.edit', $row->id) . '" class="btn btn-warning btn-sm text-white shadow-xs" style="border-radius:20px; padding: 4px 8px;" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <form action="' . route('buku-kia.destroy', $row->id) . '" method="POST" class="d-inline delete-form">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="button" class="btn btn-danger btn-sm btn-delete shadow-xs" style="border-radius:20px; padding: 4px 8px;" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>';
            })
            ->editColumn('nama_ibu', function ($row) {
                return optional($row->profilIbu)->nama_lengkap ?? '-';
            })
            ->editColumn('faskes', function ($row) {
                return optional($row->fasilitasKesehatan)->nama_faskes ?? '-';
            })
            ->editColumn('status', function ($row) {
                $color = $row->status === 'Aktif' ? 'success' : 'secondary';
                return '<span class="badge bg-' . $color . '">' . $row->status . '</span>';
            })
            ->rawColumns(['action', 'status', 'DT_RowIndex']);
    }

    public function query(BukuKia $model): QueryBuilder
    {
        return $model->newQuery()->with(['profilIbu', 'fasilitasKesehatan']);
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('bukukia-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0)
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
            Column::make('nama_ibu')->title('Nama Ibu')->addClass('text-start')->orderable(false),
            Column::make('faskes')->title('Faskes')->addClass('text-start')->orderable(false),
            Column::make('no_reg_kohort_ibu')->title('No. Reg Kohort Ibu')->addClass('text-start'),
            Column::make('status')->title('Status')->addClass('text-center'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(320)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'BukuKia_' . date('YmdHis');
    }
}
