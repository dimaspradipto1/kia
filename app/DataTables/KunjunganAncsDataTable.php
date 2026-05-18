<?php

namespace App\DataTables;

use App\Models\KunjunganAnc;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class KunjunganAncsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<KunjunganAnc> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('action', function ($row) {
                return '<div class="d-flex justify-content-center gap-1">
                    <a href="' . route('buku-kia.show', $row->buku_kia_id) . '#tab-anc" class="btn btn-info btn-sm text-white" title="Lihat di Buku KIA">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="' . route('hasil-lab-ibu.create', ['kunjungan_anc_id' => $row->id]) . '" class="btn btn-sm text-white" style="background-color: #6366F1;" title="Input Hasil Lab">
                        <i class="bi bi-flask-fill"></i> +Lab
                    </a>
                    <a href="' . route('kunjungan-anc.edit', $row->id) . '" class="btn btn-warning btn-sm text-white" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '" title="Hapus">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>';
            })
            ->editColumn('buku_kia', function ($row) {
                $namaIbu = $row->bukuKia->profilIbu->nama_lengkap ?? 'Tidak Diketahui';
                $kohort = $row->bukuKia->no_reg_kohort_ibu ?? '-';
                return '<div class="fw-bold text-dark">' . $namaIbu . '</div>
                        <small class="text-muted text-xs">Kohort: ' . $kohort . '</small>';
            })
            ->editColumn('kunjungan', function ($row) {
                return '<span class="badge bg-light text-pink border border-pink px-2.5 py-1.5 fw-semibold" style="border-radius:15px;">
                            T' . $row->trimester . ' - K' . $row->kunjungan_ke . '
                        </span>';
            })
            ->editColumn('tanggal_kunjungan', function ($row) {
                return \Carbon\Carbon::parse($row->tanggal_kunjungan)->translatedFormat('d F Y');
            })
            ->editColumn('tekanan_darah', function ($row) {
                return '<span class="fw-medium text-dark">' . $row->tekanan_darah_sistolik . '/' . $row->tekanan_darah_diastolik . '</span> <small class="text-muted">mmHg</small>';
            })
            ->editColumn('berat_badan', function ($row) {
                return '<span class="fw-medium text-dark">' . $row->berat_badan . '</span> <small class="text-muted">kg</small>';
            })
            ->editColumn('janin', function ($row) {
                $djj = $row->denyut_jantung_janin ?? '-';
                if ($djj !== '-' && !str_contains(strtolower($djj), 'bpm')) {
                    $djj .= ' bpm';
                }
                $letak = $row->letak_janin ?? '-';
                return '<div class="text-dark small"><i class="bi bi-heart-pulse text-danger me-1"></i>DJJ: <strong>' . $djj . '</strong></div>
                        <div class="text-muted small"><i class="bi bi-person-fill text-teal me-1"></i>Letak: <strong>' . $letak . '</strong></div>';
            })
            ->editColumn('medis_lain', function ($row) {
                $lila = $row->lila_cm ? 'LiLA: ' . $row->lila_cm . 'cm' : '';
                $tt = $row->status_tt ? 'TT: ' . $row->status_tt : '';
                $usg = $row->usg_dilakukan === 'Ya' ? '🟢 USG (' . ($row->hasil_usg ?? 'Normal') . ')' : '🔴 No USG';
                return '<div class="small text-dark">' . $lila . ' | ' . $tt . '</div>
                        <div class="small fw-semibold mt-1">' . $usg . '</div>';
            })
            ->rawColumns(['action', 'buku_kia', 'kunjungan', 'tekanan_darah', 'berat_badan', 'janin', 'medis_lain', 'DT_RowIndex'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(KunjunganAnc $model): QueryBuilder
    {
        return $model->newQuery()->with(['bukuKia.profilIbu', 'nakes', 'fasilitasKesehatan']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('kunjunganancs-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(3, 'desc') // Order by tanggal_kunjungan descending
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

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('No')->width(50)->addClass('text-center'),
            Column::computed('buku_kia')->title('Ibu Hamil')->addClass('text-start')->orderable(false),
            Column::computed('kunjungan')->title('ANC Kunjungan')->addClass('text-center')->orderable(false),
            Column::make('tanggal_kunjungan')->title('Tanggal ANC')->addClass('text-start'),
            Column::computed('tekanan_darah')->title('Tekanan Darah')->addClass('text-center')->orderable(false),
            Column::computed('berat_badan')->title('Berat Badan')->addClass('text-center')->orderable(false),
            Column::computed('janin')->title('Kondisi Janin')->addClass('text-start')->orderable(false),
            Column::computed('medis_lain')->title('Detail Medis')->addClass('text-start')->orderable(false),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(180)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'KunjunganAncs_' . date('YmdHis');
    }
}
