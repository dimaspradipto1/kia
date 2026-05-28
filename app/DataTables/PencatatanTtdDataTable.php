<?php

namespace App\DataTables;

use App\Models\PencatatanTtd;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PencatatanTtdDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<PencatatanTtd> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                if (auth()->user()->role->nama_role === 'ibu hamil') {
                    return '-';
                }
                $btn = '<div class="d-flex gap-2 justify-content-center">';
                $btn .= '<a href="' . route('pencatatan-ttd.edit', $row->id) . '" class="btn btn-warning btn-sm text-white shadow-sm" style="border-radius:6px;" title="Edit"><i class="bi bi-pencil-fill"></i></a>';
                $btn .= '<button type="button" class="btn btn-danger btn-sm shadow-sm btn-delete" style="border-radius:6px;" data-id="' . $row->id . '" title="Hapus"><i class="bi bi-trash-fill"></i></button>';
                $btn .= '</div>';
                return $btn;
            })
            ->addColumn('buku_kia', function ($row) {
                $ibuName = $row->bukuKia->profilIbu->nama_lengkap ?? '-';
                $noReg = $row->bukuKia->no_reg_kohort_ibu ?? '-';
                return '<div><strong>' . $ibuName . '</strong><br><small class="text-muted">Reg Kohort: ' . $noReg . '</small></div>';
            })
            ->editColumn('tanggal', function ($row) {
                return $row->tanggal ? \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d F Y') : '-';
            })
            ->editColumn('diminum', function ($row) {
                $status = trim(strtolower($row->diminum));
                if (in_array($status, ['ya', '1', 'yes', 'ya (diminum)'])) {
                    return '<span class="badge bg-success shadow-xs"><i class="bi bi-check-circle me-1"></i> Ya</span>';
                }
                return '<span class="badge bg-danger shadow-xs"><i class="bi bi-x-circle me-1"></i> Tidak</span>';
            })
            ->rawColumns(['buku_kia', 'diminum', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @param PencatatanTtd $model
     * @return QueryBuilder<PencatatanTtd>
     */
    public function query(PencatatanTtd $model): QueryBuilder
    {
        $query = $model->newQuery()->with(['bukuKia.profilIbu']);

        if (auth()->user()->role->nama_role === 'ibu hamil') {
            $query->whereHas('bukuKia.profilIbu', function ($q) {
                $q->where('user_id', auth()->id());
            });
        }

        return $query->orderBy('tanggal', 'desc');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('pencatatanttd-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(2)
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
        $cols = [
            Column::make('DT_RowIndex')->title('No')->width(50)->addClass('text-center'),
            Column::computed('buku_kia')->title('Ibu Hamil / Buku KIA')->addClass('text-start'),
            Column::make('tanggal')->title('Tanggal Pemberian')->addClass('text-start'),
            Column::make('diminum')->title('Status Konsumsi')->addClass('text-center'),
            Column::make('catatan')->title('Catatan')->addClass('text-start'),
        ];

        if (auth()->user()->role->nama_role !== 'ibu hamil') {
            $cols[] = Column::computed('action')
                        ->exportable(false)
                        ->printable(false)
                        ->width(100)
                        ->addClass('text-center');
        }

        return $cols;
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'PencatatanTtd_' . date('YmdHis');
    }
}
