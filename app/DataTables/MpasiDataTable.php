<?php

namespace App\DataTables;

use App\Models\Mpasi;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class MpasiDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('action', function ($row) {
                return '<div class="d-flex justify-content-center gap-1">
                    <a href="' . route('mpasi.edit', $row->id) . '"
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
                $tgl  = $row->tanggal_mulai_mpasi
                    ? \Carbon\Carbon::parse($row->tanggal_mulai_mpasi)->translatedFormat('d M Y')
                    : '-';
                return '<div class="fw-bold text-dark">' . e($nama) . '</div>
                        <small class="text-muted"><i class="bi bi-calendar me-1"></i>Mulai: ' . $tgl . '</small>';
            })
            ->editColumn('jenis_mpasi', function ($row) {
                $colors = [
                    'Bubur Susu'         => '#0d6efd',
                    'Bubur Saring'       => '#16B3AC',
                    'Pure Sayuran'       => '#16a34a',
                    'Pure Buah'          => '#F59E0B',
                    'Bubur Nasi Tim'     => '#8B5CF6',
                    'Nasi Tim'           => '#EC1E88',
                    'Finger Food'        => '#ea580c',
                    'Makanan Keluarga'   => '#6366F1',
                    'Makanan Selingan'   => '#14b8a6',
                ];
                $color = $colors[$row->jenis_mpasi] ?? '#6c757d';
                return '<span class="badge px-2 py-1 text-white fw-semibold"
                              style="border-radius:12px; background:' . $color . '; font-size:0.8rem;">'
                    . e($row->jenis_mpasi) . '</span>';
            })
            ->editColumn('frekuensi', function ($row) {
                return '<span class="badge bg-primary-subtle text-primary px-2 py-1" style="font-size:0.78rem;">'
                    . e($row->frekuensi) . '</span>';
            })
            ->editColumn('tekstur', function ($row) {
                $tMap = [
                    'Cair / Encer'              => 'info',
                    'Semipadat / Lembek'        => 'primary',
                    'Cincang Kasar'             => 'warning',
                    'Dipotong Kecil'            => 'secondary',
                    'Seperti Makanan Keluarga'  => 'success',
                ];
                $cls = $tMap[$row->tekstur] ?? 'secondary';
                return '<span class="badge bg-' . $cls . '-subtle text-' . $cls . ' px-2 py-1" style="font-size:0.78rem;">'
                    . e($row->tekstur) . '</span>';
            })
            ->editColumn('catatan_gizi', function ($row) {
                $catatan = $row->catatan_gizi;
                if (strlen($catatan) > 50) {
                    $catatan = substr($catatan, 0, 50) . '…';
                }
                return '<span class="text-muted small">' . e($catatan) . '</span>';
            })
            ->editColumn('nakes', function ($row) {
                return e($row->nakes->name ?? '-');
            })
            ->rawColumns(['action', 'profil_anak', 'jenis_mpasi', 'frekuensi', 'tekstur', 'catatan_gizi', 'DT_RowIndex'])
            ->setRowId('id');
    }

    public function query(Mpasi $model): QueryBuilder
    {
        $query = $model->newQuery()->with(['profilAnak', 'nakes']);

        if (auth()->user()->role->nama_role === 'ibu hamil') {
            $query->whereHas('profilAnak.bukuKia.profilIbu', function ($q) {
                $q->where('user_id', auth()->id());
            });
        }

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('mpasi-table')
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
            Column::computed('jenis_mpasi')->title('Jenis MPASI')->addClass('text-center')->orderable(false),
            Column::make('tanggal_mulai_mpasi')->title('Tgl Mulai')->addClass('text-start'),
            Column::computed('frekuensi')->title('Frekuensi')->addClass('text-center')->orderable(false),
            Column::computed('tekstur')->title('Tekstur')->addClass('text-center')->orderable(false),
            Column::computed('catatan_gizi')->title('Catatan Gizi')->addClass('text-start')->orderable(false),
            Column::computed('nakes')->title('Tenaga Kesehatan')->addClass('text-start')->orderable(false),
            Column::computed('action')->exportable(false)->printable(false)->width(100)->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Mpasi_' . date('YmdHis');
    }
}
