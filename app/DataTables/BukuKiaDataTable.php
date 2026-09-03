<?php

namespace App\DataTables;

use App\Models\BukuKia;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BukuKiaDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('action', function ($row) {
                return '<div class="d-flex justify-content-center gap-1">
                    <a href="' . route('buku-kia.show', $row->id) . '" class="btn btn-info btn-sm text-white" title="Detail">
                        <i class="bi bi-eye"></i> Detail
                    </a>
                    <a href="' . route('kunjungan-anc.create', ['buku_kia_id' => $row->id]) . '" class="btn btn-sm text-white" style="background-color: #6366F1;" title="Input ANC">
                        <i class="bi bi-clipboard2-pulse-fill"></i> +ANC
                    </a>
                    <a href="' . route('pemantauan-nifas.create', ['buku_kia_id' => $row->id]) . '" class="btn btn-sm text-white" style="background-color: #16B3AC;" title="Input Nifas">
                        <i class="bi bi-activity"></i> +Nifas
                    </a>
                    <a href="' . route('kb-pasca-salin.create', ['buku_kia_id' => $row->id]) . '" class="btn btn-sm text-white" style="background-color: #EC1E88;" title="Input KB">
                        <i class="bi bi-heart-pulse-fill"></i> +KB
                    </a>
                    <a href="' . route('buku-kia.edit', $row->id) . '" class="btn btn-warning btn-sm text-white" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <form action="' . route('buku-kia.destroy', $row->id) . '" method="POST" class="d-inline delete-form">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="button" class="btn btn-danger btn-sm btn-delete" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>';
            })
            ->editColumn('nama_ibu', function ($row) {
                return optional($row->profilIbu)->nama_lengkap ?? '-';
            })
            ->editColumn('faskes', function ($row) {
                return optional($row->fasilitasKesehatan)->nama_faskes ?? '-';
            })
            ->editColumn('status', function ($row) {
                $color = $row->status === 'Aktif' ? 'success' : 'secondary';
                return '<span class="badge bg-' . $color . '">' . $row->status . '</span>';
            })
            ->rawColumns(['action', 'status', 'DT_RowIndex']);
    }

    public function query(BukuKia $model): QueryBuilder
    {
        $query = $model->newQuery()->with(['profilIbu', 'fasilitasKesehatan']);

        /** @var \App\Models\User $authUser */
        $authUser = \Illuminate\Support\Facades\Auth::user();
        $userRole = strtolower($authUser->role->nama_role ?? '');

        // Jika login sebagai ibu hamil, hanya tampilkan data milik sendiri
        if ($authUser->roles_id == 4 || $userRole === 'ibu hamil') {
            $query->whereHas('profilIbu', function ($q) use ($authUser) {
                $q->where('user_id', $authUser->id);
            });
        }

        // Kader Posyandu hanya melihat Buku KIA sesuai lokasi faskes/wilayah terdaftar
        if (in_array($userRole, ['kader posyandu', 'kader'])) {
            if ($authUser->fasilitas_kesehatan_id) {
                $query->where(function ($q) use ($authUser) {
                    $q->where('fasilitas_kesehatan_id', $authUser->fasilitas_kesehatan_id)
                      ->orWhereHas('profilIbu', function ($sub) use ($authUser) {
                          $sub->where('fasilitas_kesehatan_id', $authUser->fasilitas_kesehatan_id);
                      });
                });
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

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('bukukia-table')
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

    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('No')->width(50)->addClass('text-center'),
            Column::make('nama_ibu')->title('Nama Ibu')->addClass('text-start')->orderable(false),
            Column::make('faskes')->title('Faskes')->addClass('text-start')->orderable(false),
            Column::make('no_reg_kohort_ibu')->title('No. Reg Kohort Ibu')->addClass('text-start'),
            Column::make('status')->title('Status')->addClass('text-center'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(420)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'BukuKia_' . date('YmdHis');
    }
}
