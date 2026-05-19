<?php

namespace App\DataTables;

use App\Models\ProfilSuami;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProfilSuamiDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '<div class="d-flex justify-content-center gap-1">
                            <a href="' . route('profil-suami.show', $row->id) . '" class="btn btn-info btn-sm text-white" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="' . route('profil-suami.edit', $row->id) . '" class="btn btn-warning btn-sm" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="' . route('profil-suami.destroy', $row->id) . '" method="POST" class="d-inline delete-form">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="button" class="btn btn-danger btn-sm btn-delete" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>';
            })
            ->editColumn('nama_ibu', function($row) {
                return $row->profilIbu->nama_lengkap ?? '-';
            })
            ->editColumn('tanggal_lahir', function($row) {
                return $row->tanggal_lahir ? \Carbon\Carbon::parse($row->tanggal_lahir)->translatedFormat('d F Y') : '-';
            })
            ->rawColumns(['action']);
    }

    public function query(ProfilSuami $model): QueryBuilder
    {
        $query = $model->newQuery()->with('profilIbu');

        if (auth()->user()->role->nama_role === 'ibu hamil') {
            $query->whereHas('profilIbu', function ($q) {
                $q->where('user_id', auth()->id());
            });
        }

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('profilsuami-table')
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
            Column::make('nik')->title('NIK')->addClass('text-start'),
            Column::make('nama_lengkap')->title('Nama Suami')->addClass('text-start'),
            Column::make('nama_ibu')->title('Nama Istri')->addClass('text-start'),
            Column::make('nomor_wa')->title('WhatsApp')->addClass('text-start'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(120)
                  ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'ProfilSuami_' . date('YmdHis');
    }
}
