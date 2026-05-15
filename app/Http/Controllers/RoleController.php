<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\DataTables\RoleDataTable;
use App\Models\Role;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class RoleController extends Controller
{
    public function index(RoleDataTable $dataTable)
    {
        return $dataTable->render('pages.role.index');
    }

    public function create()
    {
        return view('pages.role.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_role' => 'required|string|max:255|unique:roles',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        Role::create($request->all());

        Alert::success('Berhasil', 'Role berhasil ditambahkan.');
        return redirect()->route('roles.index');
    }

    public function edit(Role $role)
    {
        return view('pages.role.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'nama_role' => 'required|string|max:255|unique:roles,nama_role,' . $role->id,
            'deskripsi' => 'nullable|string|max:255',
        ]);

        $role->update($request->all());

        Alert::success('Berhasil', 'Role berhasil diperbarui.');
        return redirect()->route('roles.index');
    }

    public function destroy(Role $role)
    {
        if ($role->users()->count() > 0) {
            Alert::error('Gagal', 'Role tidak dapat dihapus karena masih digunakan oleh user.');
            return redirect()->back();
        }

        $role->delete();
        Alert::success('Berhasil', 'Role berhasil dihapus.');
        return redirect()->route('roles.index');
    }
}
