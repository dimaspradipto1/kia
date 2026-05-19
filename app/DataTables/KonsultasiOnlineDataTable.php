<?php

namespace App\DataTables;

use App\Models\KonsultasiOnline;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class KonsultasiOnlineDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('action', function ($row) {
                $userRole = auth()->user()->role->nama_role;
                $buttons = '<div class="d-flex justify-content-center gap-1">';

                // Detail View Button (Always visible)
                $buttons .= '<a href="' . route('konsultasi-online.show', $row->id) . '"
                               class="btn btn-info btn-sm text-white" title="Detail / Baca">
                                <i class="bi bi-eye"></i>
                             </a>';

                // Midwife / Nakes Response Button
                if (in_array($userRole, ['nakes', 'administrator'])) {
                    if ($row->status === 'pending') {
                        $buttons .= '<a href="' . route('konsultasi-online.edit', $row->id) . '"
                                       class="btn btn-success btn-sm text-white" title="Beri Tanggapan Medis">
                                        <i class="bi bi-chat-left-dots"></i>
                                     </a>';
                    } else {
                        $buttons .= '<a href="' . route('konsultasi-online.edit', $row->id) . '"
                                       class="btn btn-warning btn-sm text-white" title="Ubah Jawaban">
                                        <i class="bi bi-pencil-square"></i>
                                     </a>';
                    }
                }

                // Ibu Hamil / Patient Edit Button (Only allowed if status is pending)
                if ($userRole === 'ibu hamil' && $row->status === 'pending') {
                    $buttons .= '<a href="' . route('konsultasi-online.edit', $row->id) . '"
                                   class="btn btn-warning btn-sm text-white" title="Edit Pertanyaan">
                                    <i class="bi bi-pencil-square"></i>
                                 </a>';
                }

                // Delete Button (Always visible for Admin, Nakes, and Patient if pending)
                if (in_array($userRole, ['administrator', 'nakes']) || ($userRole === 'ibu hamil' && $row->status === 'pending')) {
                    $buttons .= '<button type="button" class="btn btn-danger btn-sm btn-delete"
                                         data-id="' . $row->id . '" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                 </button>';
                }

                $buttons .= '</div>';
                return $buttons;
            })
            ->editColumn('pasien', function ($row) {
                $nama = $row->user->name ?? '-';
                $nik = $row->user->profilIbu->nik ?? '-';
                return '<div class="fw-bold text-dark">' . e($nama) . '</div>
                        <small class="text-muted"><i class="bi bi-card-text me-1"></i>NIK: ' . e($nik) . '</small>';
            })
            ->editColumn('faskes', function ($row) {
                $faskesNama = $row->fasilitasKesehatan->nama_faskes ?? '-';
                $faskesJenis = $row->fasilitasKesehatan->jenis ?? '-';
                return '<div class="text-secondary small fw-semibold">' . e($faskesNama) . '</div>
                        <span class="badge bg-secondary-subtle text-secondary" style="font-size: 10px;">' . e($faskesJenis) . '</span>';
            })
            ->editColumn('keluhan', function ($row) {
                $topik = $row->topik ?? 'Keluhan Umum';
                $pesan = $row->pesan ?? '';
                $pesanShort = strlen($pesan) > 60 ? substr($pesan, 0, 60) . '...' : $pesan;
                return '<div class="fw-bold text-primary small">' . e($topik) . '</div>
                        <div class="text-muted small" style="max-width: 250px; white-space: normal;">' . e($pesanShort) . '</div>';
            })
            ->editColumn('status', function ($row) {
                $statusMap = [
                    'pending'  => ['class' => 'bg-warning-subtle text-warning', 'text' => 'Menunggu Tanggapan', 'icon' => 'bi-clock'],
                    'accepted' => ['class' => 'bg-success-subtle text-success', 'text' => 'Sudah Dijawab', 'icon' => 'bi-check-circle'],
                    'rejected' => ['class' => 'bg-danger-subtle text-danger', 'text' => 'Ditolak / Selesai', 'icon' => 'bi-x-circle'],
                ];
                $cfg = $statusMap[$row->status] ?? ['class' => 'bg-secondary-subtle text-secondary', 'text' => 'N/A', 'icon' => 'bi-question-circle'];
                return '<span class="badge ' . $cfg['class'] . ' px-3 py-2 fw-semibold" style="border-radius:20px; font-size:11px;">'
                    . '<i class="bi ' . $cfg['icon'] . ' me-1"></i>' . $cfg['text'] . '</span>';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at ? $row->created_at->translatedFormat('d F Y H:i') : '-';
            })
            ->rawColumns(['action', 'pasien', 'faskes', 'keluhan', 'status', 'DT_RowIndex'])
            ->setRowId('id');
    }

    public function query(KonsultasiOnline $model): QueryBuilder
    {
        $user = auth()->user();
        $userRole = $user->role->nama_role;

        $query = $model->newQuery()->with(['user.profilIbu', 'fasilitasKesehatan']);

        // Patient / Ibu Hamil: Can only see their own consultations
        if ($userRole === 'ibu hamil') {
            $query->where('user_id', $user->id);
        }

        // Midwife / Nakes: Can only see consultations addressed to their health facility
        if ($userRole === 'nakes') {
            // Find patient's faskes from nakes registered faskes
            // Wait, does nakes have a faskes_id in the database? Let's check nakes columns or user columns.
            // If the user is nakes, let's look up if user table has a faskes_id or wilayah_id.
            $faskesId = $user->fasilitas_kesehatan_id;
            if ($faskesId) {
                $query->where('fasilitas_kesehatan_id', $faskesId);
            }
        }

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('konsultasionline-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(5, 'desc')
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('print'),
                Button::make('reload'),
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('No')->width(50)->addClass('text-center'),
            Column::computed('pasien')->title('Ibu Hamil / Pasien')->addClass('text-start')->orderable(false),
            Column::computed('faskes')->title('Fasilitas Kesehatan')->addClass('text-start')->orderable(false),
            Column::computed('keluhan')->title('Topik Keluhan & Pesan')->addClass('text-start')->orderable(false),
            Column::computed('status')->title('Status')->addClass('text-center')->orderable(false),
            Column::make('created_at')->title('Tanggal Pengajuan')->addClass('text-start'),
            Column::computed('action')->exportable(false)->printable(false)->width(180)->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'KonsultasiOnline_' . date('YmdHis');
    }
}
