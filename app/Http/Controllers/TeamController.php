<?php

namespace App\Http\Controllers;

use App\DataTables\TeamDataTable;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class TeamController extends Controller
{
    public function index(TeamDataTable $dataTable)
    {
        return $dataTable->render('pages.team.index');
    }

    public function create()
    {
        return view('pages.team.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'jabatan'   => 'required|string|max:255',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'linkedin'  => 'nullable|url|max:255',
            'tiktok'    => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'facebook'  => 'nullable|url|max:255',
            'urutan'    => 'nullable|integer|min:0',
            'is_active' => 'required|boolean',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('teams', 'public');
        }

        Team::create([
            'nama'      => $request->nama,
            'jabatan'   => $request->jabatan,
            'foto'      => $fotoPath,
            'linkedin'  => $request->linkedin,
            'tiktok'    => $request->tiktok,
            'instagram' => $request->instagram,
            'facebook'  => $request->facebook,
            'urutan'    => $request->urutan ?? 0,
            'is_active' => $request->is_active,
        ]);

        Alert::success('Berhasil', 'Anggota tim berhasil ditambahkan.');
        return redirect()->route('teams.index');
    }

    public function show(Team $team)
    {
        return view('pages.team.show', compact('team'));
    }

    public function edit(Team $team)
    {
        return view('pages.team.edit', compact('team'));
    }

    public function update(Request $request, Team $team)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'jabatan'   => 'required|string|max:255',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'linkedin'  => 'nullable|url|max:255',
            'tiktok'    => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'facebook'  => 'nullable|url|max:255',
            'urutan'    => 'nullable|integer|min:0',
            'is_active' => 'required|boolean',
            'hapus_foto'=> 'nullable|boolean',
        ]);

        $fotoPath = $team->foto;

        // Hapus foto lama jika dicentang
        if ($request->boolean('hapus_foto') && $team->foto) {
            Storage::disk('public')->delete($team->foto);
            $fotoPath = null;
        }

        // Ganti dengan foto baru jika ada upload
        if ($request->hasFile('foto')) {
            if ($team->foto) {
                Storage::disk('public')->delete($team->foto);
            }
            $fotoPath = $request->file('foto')->store('teams', 'public');
        }

        $team->update([
            'nama'      => $request->nama,
            'jabatan'   => $request->jabatan,
            'foto'      => $fotoPath,
            'linkedin'  => $request->linkedin,
            'tiktok'    => $request->tiktok,
            'instagram' => $request->instagram,
            'facebook'  => $request->facebook,
            'urutan'    => $request->urutan ?? 0,
            'is_active' => $request->is_active,
        ]);

        Alert::success('Berhasil', 'Data anggota tim berhasil diperbarui.');
        return redirect()->route('teams.index');
    }

    public function destroy(Team $team)
    {
        if ($team->foto) {
            Storage::disk('public')->delete($team->foto);
        }
        $team->delete();

        Alert::success('Berhasil', 'Anggota tim berhasil dihapus.');
        return redirect()->route('teams.index');
    }
}
