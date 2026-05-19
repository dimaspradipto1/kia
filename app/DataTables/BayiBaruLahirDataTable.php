<?php

namespace App\DataTables;

use App\Models\BayiBaruLahir;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BayiBaruLahirDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('action', function ($row) {
                return '<div class="d-flex justify-content-center gap-1">
                    <a href="' . route('bayi-baru-lahir.edit', $row->id) . '" class="btn btn-warning btn-sm text-white" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '" title="Hapus">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>';
            })
            ->editColumn('profil_anak', function ($row) {
                $nama = $row->profilAnak->nama_lengkap ?? '-';
                $jk   = $row->profilAnak->jenis_kelamin ?? '-';
                $tgl  = $row->profilAnak->tanggal_lahir
                    ? \Carbon\Carbon::parse($row->profilAnak->tanggal_lahir)->translatedFormat('d M Y')
                    : '-';
                return '<div class="fw-bold text-dark">' . e($nama) . '</div>
                        <small class="text-muted"><i class="bi bi-gender-ambiguous me-1"></i>' . e($jk) . ' &bull; ' . $tgl . '</small>';
            })
            ->editColumn('imunisasi', function ($row) {
                $hb0   = $row->hb0_diberikan ? '<span class="badge bg-success-subtle text-success">HB0 ✓</span>' : '<span class="badge bg-danger-subtle text-danger">HB0 ✗</span>';
                $vitk1 = $row->vit_k1_diberikan ? '<span class="badge bg-success-subtle text-success">Vit K1 ✓</span>' : '<span class="badge bg-danger-subtle text-danger">Vit K1 ✗</span>';
                $salep = $row->salep_mata_diberikan ? '<span class="badge bg-success-subtle text-success">Salep ✓</span>' : '<span class="badge bg-danger-subtle text-danger">Salep ✗</span>';
                return '<div class="d-flex flex-wrap gap-1">' . $hb0 . $vitk1 . $salep . '</div>';
            })
            ->editColumn('skrining', function ($row) {
                $shk = $row->shk_dilakukan
                    ? '<span class="badge bg-success-subtle text-success">SHK ✓</span>'
                    : '<span class="badge bg-secondary-subtle text-secondary">SHK -</span>';
                $pjb = $row->pjb_dilakukan
                    ? '<span class="badge bg-success-subtle text-success">PJB ✓</span>'
                    : '<span class="badge bg-secondary-subtle text-secondary">PJB -</span>';
                return '<div class="d-flex flex-wrap gap-1">' . $shk . $pjb . '</div>';
            })
            ->editColumn('kondisi_umum', function ($row) {
                $color = match (strtolower($row->kondisi_umum)) {
                    'baik'   => 'success',
                    'sedang' => 'warning',
                    'buruk'  => 'danger',
                    default  => 'secondary',
                };
                return '<span class="badge bg-' . $color . '-subtle text-' . $color . ' px-3 py-2 fw-semibold" style="border-radius:15px;">'
                    . e($row->kondisi_umum) . '</span>';
            })
            ->editColumn('nakes', function ($row) {
                return e($row->nakes->name ?? '-');
            })
            ->rawColumns(['action', 'profil_anak', 'imunisasi', 'skrining', 'kondisi_umum', 'DT_RowIndex'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(BayiBaruLahir $model): QueryBuilder
    {
        $query = $model->newQuery()->with(['profilAnak', 'nakes']);

        if (auth()->user()->role->nama_role === 'ibu hamil') {
            $query->whereHas('profilAnak.bukuKia.profilIbu', function ($q) {
                $q->where('user_id', auth()->id());
            });
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('bayibarulahir-table')
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

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('No')->width(50)->addClass('text-center'),
            Column::computed('profil_anak')->title('Profil Anak')->addClass('text-start')->orderable(false),
            Column::computed('imunisasi')->title('Imunisasi Awal')->addClass('text-center')->orderable(false),
            Column::computed('skrining')->title('Skrining (SHK/PJB)')->addClass('text-center')->orderable(false),
            Column::computed('kondisi_umum')->title('Kondisi Umum')->addClass('text-center')->orderable(false),
            Column::computed('nakes')->title('Tenaga Kesehatan')->addClass('text-start')->orderable(false),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'BayiBaruLahir_' . date('YmdHis');
    }
}
