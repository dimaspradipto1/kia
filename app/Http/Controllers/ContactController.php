<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\DataTables\ContactDataTable;
use App\Models\Contact;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ContactController extends Controller
{
    public function index(ContactDataTable $dataTable)
    {
        return $dataTable->render('pages.contact.index');
    }

    public function create()
    {
        return view('pages.contact.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lokasi'    => 'required|string|max:255',
            'alamat'         => 'required|string',
            'email'          => 'nullable|email|max:255',
            'telepon'        => 'nullable|string|max:50',
            'jam_operasional'=> 'nullable|string|max:255',
            'map_embed'      => 'nullable|string',
            'is_active'      => 'required|boolean',
        ]);

        Contact::create($request->all());

        Alert::success('Berhasil', 'Data kontak berhasil ditambahkan.');
        return redirect()->route('contacts.index');
    }

    public function show(Contact $contact)
    {
        return view('pages.contact.show', compact('contact'));
    }

    public function edit(Contact $contact)
    {
        return view('pages.contact.edit', compact('contact'));
    }

    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'nama_lokasi'    => 'required|string|max:255',
            'alamat'         => 'required|string',
            'email'          => 'nullable|email|max:255',
            'telepon'        => 'nullable|string|max:50',
            'jam_operasional'=> 'nullable|string|max:255',
            'map_embed'      => 'nullable|string',
            'is_active'      => 'required|boolean',
        ]);

        $contact->update($request->all());

        Alert::success('Berhasil', 'Data kontak berhasil diperbarui.');
        return redirect()->route('contacts.index');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        Alert::success('Berhasil', 'Data kontak berhasil dihapus.');
        return redirect()->route('contacts.index');
    }
}
