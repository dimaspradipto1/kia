<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\DataTables\UserDataTable;
use App\Models\User;
use App\Models\Role;
use App\Models\WilayaDinkes;
use App\Models\FasilitasKesehatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render('pages.user.index');
    }

    public function create()
    {
        $roles = Role::all();
        $wilayaDinkes = WilayaDinkes::all();
        $fasilitasKesehatan = FasilitasKesehatan::all();
        return view('pages.user.create', compact('roles', 'wilayaDinkes', 'fasilitasKesehatan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles_id' => 'required|exists:roles,id',
            'wilaya_dinkes_id' => 'nullable|exists:wilaya_dinkes,id',
            'fasilitas_kesehatan_id' => 'nullable|exists:fasilitas_kesehatans,id',
            'is_active' => 'required|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('users', 'public');
        }

        User::create($data);

        Alert::success('Berhasil', 'User berhasil ditambahkan.');
        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $wilayaDinkes = WilayaDinkes::all();
        $fasilitasKesehatan = FasilitasKesehatan::all();
        return view('pages.user.edit', compact('user', 'roles', 'wilayaDinkes', 'fasilitasKesehatan'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'roles_id' => 'required|exists:roles,id',
            'wilaya_dinkes_id' => 'nullable|exists:wilaya_dinkes,id',
            'fasilitas_kesehatan_id' => 'nullable|exists:fasilitas_kesehatans,id',
            'is_active' => 'required|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('password');
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $data['photo'] = $request->file('photo')->store('users', 'public');
        }

        $user->update($data);

        Alert::success('Berhasil', 'User berhasil diperbarui.');
        return redirect()->route('users.index');
    }

    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        Alert::success('Berhasil', 'Password user berhasil diperbarui.');
        return redirect()->back();
    }

    public function destroy(User $user)
    {
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }
        
        $user->delete();
        Alert::success('Berhasil', 'User berhasil dihapus.');
        return redirect()->route('users.index');
    }

    public function toggleStatus(User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Status user berhasil diubah.',
            'new_status' => $user->is_active
        ]);
    }

    public function exportTemplate()
    {
        // Export logic
    }

    public function import(Request $request)
    {
        // Import logic
    }
}
