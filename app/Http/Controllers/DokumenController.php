<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\BukuKia;
use App\Http\Requests\DokumenRequest;
use App\DataTables\DokumenDataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class DokumenController extends Controller
{
    public function index(DokumenDataTable $dataTable)
    {
        return $dataTable->render('pages.dokumen.index');
    }

    public function create()
    {
        $bukuKia = BukuKia::with('profilIbu')->get();
        return view('pages.dokumen.create', compact('bukuKia'));
    }

    public function store(DokumenRequest $request)
    {
        $validated = $request->validated();

        foreach ($request->items as $item) {
            $filePath = $item['file']->store('dokumen', 'public');
            
            Dokumen::create([
                'buku_kia_id'   => $validated['buku_kia_id'],
                'jenis_dokumen' => $item['jenis'],
                'file'          => $filePath,
                'status_verifikasi' => 'pending',
            ]);
        }

        Alert::success('Berhasil', count($request->items) . ' dokumen berhasil ditambahkan.');
        return redirect()->route('dokumen.index');
    }

    public function show(Dokumen $dokumen)
    {
        return view('pages.dokumen.show', compact('dokumen'));
    }

    public function edit(Dokumen $dokumen)
    {
        $bukuKia = BukuKia::with('profilIbu')->get();
        return view('pages.dokumen.edit', compact('dokumen', 'bukuKia'));
    }

    public function update(DokumenRequest $request, Dokumen $dokumen)
    {
        $data = $request->validated();

        if ($request->hasFile('file')) {
            if ($dokumen->file) {
                Storage::disk('public')->delete($dokumen->file);
            }
            $data['file'] = $request->file('file')->store('dokumen', 'public');
        }

        // Handle verification update if user is Nakes/Admin
        if ($request->has('status_verifikasi')) {
            $data['diverifikasi_oleh'] = auth()->id();
            $data['tanggal_verifikasi'] = now();
        }

        $dokumen->update($data);

        Alert::success('Berhasil', 'Dokumen berhasil diperbarui.');
        return redirect()->route('dokumen.index');
    }

    public function destroy(Dokumen $dokumen)
    {
        if ($dokumen->file) {
            Storage::disk('public')->delete($dokumen->file);
        }
        
        $dokumen->delete();

        Alert::success('Berhasil', 'Dokumen berhasil dihapus.');
        return redirect()->route('dokumen.index');
    }

    public function updateStatus(Request $request, Dokumen $dokumen)
    {
        $request->validate([
            'status' => 'required|in:verified,rejected'
        ]);

        $dokumen->update([
            'status_verifikasi' => $request->status,
            'diverifikasi_oleh' => auth()->id(),
            'tanggal_verifikasi' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status dokumen berhasil diperbarui.'
        ]);
    }
}
