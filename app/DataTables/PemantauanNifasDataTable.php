<?php

namespace App\DataTables;

use App\Models\PemantauanNifas;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PemantauanNifasDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<PemantauanNifas> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<div class="d-flex gap-2 justify-content-center">';
                $btn .= '<a href="' . route('pemantauan-nifas.edit', $row->id) . '" class="btn btn-warning btn-sm text-white shadow-sm" style="border-radius:6px;" title="Edit"><i class="bi bi-pencil-fill"></i></a>';
                $btn .= '<button type="button" class="btn btn-danger btn-sm shadow-sm btn-delete" style="border-radius:6px;" data-id="' . $row->id . '" title="Hapus"><i class="bi bi-trash-fill"></i></button>';
                $btn .= '<form id="delete-form-' . $row->id . '" action="' . route('pemantauan-nifas.destroy', $row->id) . '" method="POST" class="d-none">';
                $btn .= csrf_field();
                $btn .= method_field('DELETE');
                $btn .= '</form>';
                $btn .= '</div>';
                return $btn;
            })
            ->editColumn('buku_kia', function ($row) {
                $ibuName = $row->bukuKia->profilIbu->nama_lengkap ?? '-';
                $noReg = $row->bukuKia->no_reg_kohort_ibu ?? '-';
                return '<div><strong>' . $ibuName . '</strong><br><small class="text-muted">Reg Kohort: ' . $noReg . '</small></div>';
            })
            ->editColumn('nakes', function ($row) {
                return $row->nakes->name ?? '-';
            })
            ->editColumn('tanggal', function ($row) {
                return $row->tanggal ? \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d F Y') : '-';
            })
            ->addColumn('status_gejala', function ($row) {
                $gejala = [];
                if ($row->demam === 'Ya') $gejala[] = 'Demam';
                if ($row->pendarahan === 'Ya') $gejala[] = 'Pendarahan';
                if ($row->nyeri_ulu_hati === 'Ya') $gejala[] = 'Nyeri Ulu Hati';
                if ($row->pandangan_kabur === 'Ya') $gejala[] = 'Pandangan Kabur';
                if ($row->keluar_cairan_berbau === 'Ya') $gejala[] = 'Cairan Berbau';
                if ($row->payudara_bengkak === 'Ya') $gejala[] = 'Payudara Bengkak';
                if ($row->gangguan_jiwa === 'Ya') $gejala[] = 'Gangguan Jiwa';
                if ($row->gangguan_bak === 'Ya') $gejala[] = 'Gangguan BAK';

                if (count($gejala) > 0) {
                    return '<div><span class="badge bg-danger shadow-xs mb-1">Ada Keluhan</span><br><small class="text-danger fw-bold">' . implode(', ', $gejala) . '</small></div>';
                }
                return '<span class="badge bg-success shadow-xs">Normal / Sehat</span>';
            })
            ->rawColumns(['buku_kia', 'status_gejala', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<PemantauanNifas>
     */
    public function query(PemantauanNifas $model): QueryBuilder
    {
        return $model->newQuery()->with(['bukuKia.profilIbu', 'nakes']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('pemantauannifas-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(3)
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
        return [
            Column::make('DT_RowIndex')->title('No')->width(50),
            Column::make('buku_kia')->title('Pasien / Buku KIA')->orderable(false),
            Column::make('nakes')->title('Petugas Kesehatan')->orderable(false),
            Column::make('tanggal')->title('Tanggal Pemantauan'),
            Column::make('hari_ke')->title('Hari Ke / KF'),
            Column::make('status_gejala')->title('Status Kesehatan (Gejala)')->orderable(false),
            Column::make('catatan')->title('Catatan'),
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
        return 'PemantauanNifas_' . date('YmdHis');
    }
}
