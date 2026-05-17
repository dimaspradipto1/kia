<?php

namespace App\DataTables;

use App\Models\Dokumen;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\DB;

class DokumenDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {
                // Tombol Detail mengarah ke Detail Buku KIA (Tab Dokumen)
                $btn = '<div class="d-flex gap-1 justify-content-center">';
                $btn .= '<a href="' . route('buku-kia.show', $row->buku_kia_id) . '#tab-dokumen" class="btn btn-sm btn-info text-white" title="Lihat Semua Dokumen"><i class="bi bi-folder2-open me-1"></i> Lihat Dokumen</a>';
                $btn .= '</div>';
                return $btn;
            })
            ->editColumn('buku_kia_id', function ($row) {
                return '<strong>' . ($row->bukuKia->profilIbu->nama_lengkap ?? '-') . '</strong><br><small class="text-muted">QR: ' . ($row->bukuKia->qr_code ?? '-') . '</small>';
            })
            ->addColumn('total_dokumen', function ($row) {
                return '<span class="badge bg-primary">' . $row->total_dokumen . ' Berkas</span>';
            })
            ->addColumn('status_summary', function ($row) {
                $pending = $row->pending_count;
                if ($pending > 0) {
                    return '<span class="badge bg-warning text-dark">' . $pending . ' Perlu Verifikasi</span>';
                }
                return '<span class="badge bg-success">Terverifikasi Semua</span>';
            })
            ->rawColumns(['action', 'buku_kia_id', 'total_dokumen', 'status_summary'])
            ->setRowId('buku_kia_id');
    }

    public function query(Dokumen $model): QueryBuilder
    {
        // Group by buku_kia_id untuk menampilkan 1 baris per pemilik buku
        return $model->newQuery()
            ->select('buku_kia_id', 
                DB::raw('count(*) as total_dokumen'),
                DB::raw('SUM(CASE WHEN status_verifikasi = "pending" THEN 1 ELSE 0 END) as pending_count')
            )
            ->with(['bukuKia.profilIbu'])
            ->groupBy('buku_kia_id');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('dokumen-table')
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
            Column::make('buku_kia_id')->title('Pemilik Buku KIA'),
            Column::computed('total_dokumen')->title('Jumlah Berkas')->addClass('text-center'),
            Column::computed('status_summary')->title('Status Verifikasi')->addClass('text-center'),
            Column::computed('action')
                ->title('Aksi')
                ->exportable(false)
                ->printable(false)
                ->width(150)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Dokumen_Grouped_' . date('YmdHis');
    }
}
