<?php

namespace App\DataTables;

use App\Models\PerkembanganSidtk;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PerkembanganSidtkDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('action', function ($row) {
                return '<div class="d-flex justify-content-center gap-1">
                    <a href="' . route('perkembangan-sidtk.edit', $row->id) . '"
                       class="btn btn-warning btn-sm text-white" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <button type="button" class="btn btn-danger btn-sm btn-delete"
                            data-id="' . $row->id . '" title="Hapus">
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
            ->editColumn('domain', function ($row) {
                $colors = [
                    'Gerak Kasar'              => '#0d6efd',
                    'Gerak Halus'              => '#16B3AC',
                    'Bicara & Bahasa'          => '#8B5CF6',
                    'Sosialisasi & Kemandirian'=> '#EC1E88',
                    'Kognitif'                 => '#F59E0B',
                ];
                $color = $colors[$row->domain] ?? '#6c757d';
                return '<span class="badge px-3 py-2 fw-semibold text-white"
                              style="border-radius:15px; background:' . $color . '; font-size:0.8rem;">'
                    . e($row->domain) . '</span>';
            })
            ->editColumn('hasil', function ($row) {
                $map = [
                    'Sesuai'       => ['bg' => 'success', 'icon' => 'bi-check-circle-fill'],
                    'Meragukan'    => ['bg' => 'warning', 'icon' => 'bi-exclamation-circle-fill'],
                    'Penyimpangan' => ['bg' => 'danger',  'icon' => 'bi-x-circle-fill'],
                ];
                $cfg = $map[$row->hasil] ?? ['bg' => 'secondary', 'icon' => 'bi-circle'];
                return '<span class="badge bg-' . $cfg['bg'] . '-subtle text-' . $cfg['bg']
                    . ' px-3 py-2 fw-semibold" style="border-radius:15px; font-size:0.8rem;">'
                    . '<i class="bi ' . $cfg['icon'] . ' me-1"></i>' . e($row->hasil) . '</span>';
            })
            ->editColumn('tindak_lanjut', function ($row) {
                $isDarurat = str_contains($row->tindak_lanjut, 'Rujuk');
                $cls = $isDarurat ? 'danger' : 'primary';
                return '<span class="badge bg-' . $cls . '-subtle text-' . $cls . ' px-2 py-1"
                              style="font-size:0.78rem;">' . e($row->tindak_lanjut) . '</span>';
            })
            ->editColumn('tanggal_skrining', function ($row) {
                return \Carbon\Carbon::parse($row->tanggal_skrining)->translatedFormat('d F Y');
            })
            ->editColumn('nakes', function ($row) {
                return e($row->nakes->name ?? '-');
            })
            ->rawColumns(['action', 'profil_anak', 'domain', 'hasil', 'tindak_lanjut', 'DT_RowIndex'])
            ->setRowId('id');
    }

    public function query(PerkembanganSidtk $model): QueryBuilder
    {
        return $model->newQuery()->with(['profilAnak', 'nakes']);
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('perkembangansidtk-table')
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
            Column::computed('domain')->title('Domain')->addClass('text-center')->orderable(false),
            Column::make('tanggal_skrining')->title('Tanggal Skrining')->addClass('text-start'),
            Column::computed('hasil')->title('Hasil')->addClass('text-center')->orderable(false),
            Column::computed('tindak_lanjut')->title('Tindak Lanjut')->addClass('text-start')->orderable(false),
            Column::computed('nakes')->title('Tenaga Kesehatan')->addClass('text-start')->orderable(false),
            Column::computed('action')->exportable(false)->printable(false)->width(100)->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'PerkembanganSidtk_' . date('YmdHis');
    }
}
