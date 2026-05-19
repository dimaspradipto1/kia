<?php

namespace App\DataTables;

use App\Models\ImunisasiAnak;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ImunisasiAnakDataTable extends DataTable
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
                    <a href="' . route('imunisasi-anak.edit', $row->id) . '" class="btn btn-warning btn-sm text-white" title="Edit">
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
                return '<div class="fw-bold text-dark">' . e($nama) . '</div>
                        <small class="text-muted"><i class="bi bi-gender-ambiguous me-1"></i>' . e($jk) . '</small>';
            })
            ->editColumn('jenis_imunisasi', function ($row) {
                $colors = [
                    'BCG'      => '#8B5CF6',
                    'Hepatitis B' => '#0d6efd',
                    'Polio'    => '#16B3AC',
                    'DPT'      => '#EC1E88',
                    'Campak'   => '#F59E0B',
                    'MMR'      => '#10B981',
                    'HIB'      => '#EF4444',
                    'PCV'      => '#6366F1',
                    'Rotavirus' => '#F97316',
                    'Varisela' => '#84CC16',
                ];
                $color = $colors[$row->jenis_imunisasi] ?? '#6c757d';
                return '<span class="badge px-3 py-2 fw-semibold text-white" style="border-radius:15px; background:' . $color . ';">'
                    . e($row->jenis_imunisasi) . '</span>
                    <div class="text-muted small mt-1">Dosis ke-' . $row->dosis_ke . '</div>';
            })
            ->editColumn('tanggal_pemberian', function ($row) {
                return \Carbon\Carbon::parse($row->tanggal_pemberian)->translatedFormat('d F Y');
            })
            ->editColumn('faskes', function ($row) {
                return e($row->fasilitasKesehatan->nama_faskes ?? '-');
            })
            ->editColumn('nakes', function ($row) {
                return e($row->nakes->name ?? '-');
            })
            ->editColumn('efek_samping', function ($row) {
                $es = $row->efek_samping ?? '-';
                if (strtolower($es) === 'tidak ada' || $es === '-') {
                    return '<span class="badge bg-success-subtle text-success">Tidak Ada</span>';
                }
                return '<span class="badge bg-warning-subtle text-warning">' . e($es) . '</span>';
            })
            ->rawColumns(['action', 'profil_anak', 'jenis_imunisasi', 'efek_samping', 'DT_RowIndex'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ImunisasiAnak $model): QueryBuilder
    {
        $query = $model->newQuery()->with(['profilAnak', 'fasilitasKesehatan', 'nakes']);

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
            ->setTableId('imunisasianak-table')
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

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('No')->width(50)->addClass('text-center'),
            Column::computed('profil_anak')->title('Nama Anak')->addClass('text-start')->orderable(false),
            Column::computed('jenis_imunisasi')->title('Jenis & Dosis')->addClass('text-center')->orderable(false),
            Column::make('tanggal_pemberian')->title('Tanggal Pemberian')->addClass('text-start'),
            Column::computed('faskes')->title('Fasilitas Kesehatan')->addClass('text-start')->orderable(false),
            Column::computed('nakes')->title('Tenaga Kesehatan')->addClass('text-start')->orderable(false),
            Column::computed('efek_samping')->title('Efek Samping')->addClass('text-center')->orderable(false),
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
        return 'ImunisasiAnak_' . date('YmdHis');
    }
}
