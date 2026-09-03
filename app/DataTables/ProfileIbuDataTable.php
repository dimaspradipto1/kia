<?php

namespace App\DataTables;

use App\Models\ProfilIbu;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProfileIbuDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<ProfilIbu> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('action', function ($row) {
                return '<div class="d-flex justify-content-center gap-1">
                            <a href="' . route('profil-ibu.show', $row->id) . '" class="btn btn-info btn-sm text-white" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="' . route('profil-ibu.edit', $row->id) . '" class="btn btn-warning btn-sm" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="' . route('profil-ibu.destroy', $row->id) . '" method="POST" class="d-inline delete-form">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="button" class="btn btn-danger btn-sm btn-delete" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>';
            })
            ->addColumn('faskes_name', function($row) {
                return $row->fasilitasKesehatan->nama_faskes ?? '-';
            })
            ->editColumn('nama_ibu_kandung', function($row) {
                return $row->nama_ibu_kandung ?? '-';
            })
            ->editColumn('tanggal_lahir', function($row) {
                return $row->tanggal_lahir ? \Carbon\Carbon::parse($row->tanggal_lahir)->translatedFormat('d F Y') : '-';
            })
            ->rawColumns(['action', 'DT_RowIndex']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<ProfilIbu>
     */
    public function query(ProfilIbu $model): QueryBuilder
    {
        $query = $model->newQuery()->with(['user', 'fasilitasKesehatan']);

        /** @var \App\Models\User $authUser */
        $authUser = \Illuminate\Support\Facades\Auth::user();
        $userRole = strtolower($authUser->role->nama_role ?? '');

        // Ibu hamil (roles_id = 4) hanya melihat datanya sendiri
        if ($authUser->roles_id == 4 || $userRole === 'ibu hamil') {
            $query->where('user_id', $authUser->id);
        }

        // Kader Posyandu hanya melihat daftar ibu hamil sesuai lokasi dimana kader posyandu terdaftar (Faskes / Wilayah)
        if (in_array($userRole, ['kader posyandu', 'kader'])) {
            if ($authUser->fasilitas_kesehatan_id) {
                $query->where('fasilitas_kesehatan_id', $authUser->fasilitas_kesehatan_id);
            } elseif ($authUser->wilaya_dinkes_id) {
                $query->whereHas('fasilitasKesehatan', function ($q) use ($authUser) {
                    $q->where('wilayah_id', $authUser->wilaya_dinkes_id);
                });
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('profileibu-table')
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

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('No')->width(50)->addClass('text-center'),
            Column::make('nik')->title('NIK')->addClass('text-start'),
            Column::make('nama_lengkap')->title('Nama Lengkap'),
            Column::make('nama_ibu_kandung')->title('Nama Ibu Kandung'),
            Column::make('tempat_lahir')->title('Tempat Lahir'),
            Column::make('tanggal_lahir')->title('Tgl Lahir'),
            Column::computed('faskes_name')->title('Faskes'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(120)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ProfileIbu_' . date('YmdHis');
    }
}
