<?php

namespace App\DataTables;

use App\Models\Pembiayaan;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PembiayaanDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('nama_ibu', function ($row) {
                return $row->profilIbu->nama_lengkap ?? '-';
            })
            ->addColumn('status', function ($row) {
                return $row->is_active
                    ? '<span class="badge bg-success">Aktif</span>'
                    : '<span class="badge bg-secondary">Tidak Aktif</span>';
            })
            ->editColumn('tanggal_berlaku', function ($row) {
                return $row->tanggal_berlaku
                    ? \Carbon\Carbon::parse($row->tanggal_berlaku)->translatedFormat('d F Y')
                    : '-';
            })
            ->addColumn('action', function ($row) {
                return '<div class="d-flex justify-content-center gap-1">
                            <a href="' . route('pembiayaan.show', $row->id) . '" class="btn btn-info btn-sm text-white" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="' . route('pembiayaan.edit', $row->id) . '" class="btn btn-warning btn-sm" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="' . route('pembiayaan.destroy', $row->id) . '" method="POST" class="d-inline delete-form">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="button" class="btn btn-danger btn-sm btn-delete" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>';
            })
            ->rawColumns(['action', 'DT_RowIndex', 'status']);
    }

    public function query(Pembiayaan $model): QueryBuilder
    {
        return $model->newQuery()->with('profilIbu');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('pembiayaan-table')
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
            Column::make('DT_RowIndex')->title('No')->width(50)->addClass('text-center')->orderable(false),
            Column::computed('nama_ibu')->title('Nama Ibu')->orderable(false),
            Column::make('jenis_pembiayaan')->title('Jenis Pembiayaan'),
            Column::make('nama_asuransi')->title('Nama Asuransi'),
            Column::make('nomor_polis')->title('No. Polis'),
            Column::make('tanggal_berlaku')->title('Tgl Berlaku'),
            Column::computed('status')->title('Status')->addClass('text-center')->orderable(false),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Pembiayaan_' . date('YmdHis');
    }
}
