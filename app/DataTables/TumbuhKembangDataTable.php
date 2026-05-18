<?php

namespace App\DataTables;

use App\Models\TumbuhKembang;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TumbuhKembangDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('action', function ($row) {
                return '<div class="d-flex justify-content-center gap-1">
                    <a href="' . route('tumbuh-kembang.edit', $row->id) . '" class="btn btn-warning btn-sm text-white" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '" title="Hapus">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>';
            })
            ->editColumn('profil_anak', function ($row) {
                $nama = $row->profilAnak->nama_lengkap ?? '-';
                $usia = $row->usia_bulan . ' bln';
                return '<div class="fw-bold text-dark">' . e($nama) . '</div>
                        <small class="text-muted"><i class="bi bi-clock me-1"></i>' . $usia . '</small>';
            })
            ->editColumn('pengukuran', function ($row) {
                return '<div class="small">
                    <div><i class="bi bi-graph-up-arrow text-primary me-1"></i><strong>' . $row->berat_badan . '</strong> kg &bull; <strong>' . $row->tinggi_badan . '</strong> cm</div>
                    ' . ($row->lingkar_kepala ? '<div class="text-muted">LK: ' . $row->lingkar_kepala . ' cm</div>' : '') . '
                </div>';
            })
            ->editColumn('tanggal_ukur', function ($row) {
                return \Carbon\Carbon::parse($row->tanggal_ukur)->translatedFormat('d F Y');
            })
            ->editColumn('status_gizi', function ($row) {
                $bbU  = $row->status_gizi_bb_u;
                $tbU  = $row->status_gizi_tb_u;
                $bbTb = $row->status_gizi_bb_tb;
                $colorMap = [
                    'Gizi Baik'   => 'success', 'Normal'    => 'success',
                    'Gizi Kurang' => 'warning',  'Pendek'    => 'warning',
                    'Gizi Buruk'  => 'danger',   'Sangat Pendek' => 'danger',
                    'Gizi Lebih'  => 'info',     'Tinggi'    => 'info',
                    'Obesitas'    => 'danger',
                ];
                $c1 = $colorMap[$bbU] ?? 'secondary';
                $c2 = $colorMap[$tbU] ?? 'secondary';
                $c3 = $colorMap[$bbTb] ?? 'secondary';
                return '<div class="d-flex flex-column gap-1">
                    <span class="badge bg-' . $c1 . '-subtle text-' . $c1 . ' px-2">BB/U: ' . e($bbU) . '</span>
                    <span class="badge bg-' . $c2 . '-subtle text-' . $c2 . ' px-2">TB/U: ' . e($tbU) . '</span>
                    <span class="badge bg-' . $c3 . '-subtle text-' . $c3 . ' px-2">BB/TB: ' . e($bbTb) . '</span>
                </div>';
            })
            ->editColumn('status_stunting', function ($row) {
                $s = $row->status_stunting;
                if (!$s) return '<span class="badge bg-secondary-subtle text-secondary">-</span>';
                $c = str_contains(strtolower($s), 'stunting') ? 'danger' : 'success';
                return '<span class="badge bg-' . $c . '-subtle text-' . $c . '">' . e($s) . '</span>';
            })
            ->editColumn('nakes', function ($row) {
                return e($row->nakes->name ?? '-');
            })
            ->rawColumns(['action', 'profil_anak', 'pengukuran', 'status_gizi', 'status_stunting', 'DT_RowIndex'])
            ->setRowId('id');
    }

    public function query(TumbuhKembang $model): QueryBuilder
    {
        return $model->newQuery()->with(['profilAnak', 'fasilitasKesehatan', 'nakes']);
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('tumbuhkembang-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(3, 'desc')
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
            Column::computed('profil_anak')->title('Nama Anak')->addClass('text-start')->orderable(false),
            Column::computed('pengukuran')->title('BB / TB / LK')->addClass('text-start')->orderable(false),
            Column::make('tanggal_ukur')->title('Tanggal Ukur')->addClass('text-start'),
            Column::computed('status_gizi')->title('Status Gizi')->addClass('text-center')->orderable(false),
            Column::computed('status_stunting')->title('Stunting')->addClass('text-center')->orderable(false),
            Column::computed('nakes')->title('Tenaga Kesehatan')->addClass('text-start')->orderable(false),
            Column::computed('action')->exportable(false)->printable(false)->width(100)->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'TumbuhKembang_' . date('YmdHis');
    }
}
