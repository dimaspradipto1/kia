<?php

namespace App\Http\Controllers;

use App\Models\WilayaDinkes;
use App\Http\Requests\WilayaDinkesRequest;
use App\DataTables\WilayaDinkesDataTable;
use RealRashid\SweetAlert\Facades\Alert;

class WilayaDinkesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(WilayaDinkesDataTable $dataTable)
    {
        return $dataTable->render('pages.wilaya_dinkes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.wilaya_dinkes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WilayaDinkesRequest $request)
    {
        WilayaDinkes::create($request->validated());
        Alert::success('Berhasil', 'Wilayah Dinkes berhasil ditambahkan.');
        return redirect()->route('wilaya-dinkes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(WilayaDinkes $wilayaDinke)
    {
        // Not used currently
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WilayaDinkes $wilayaDinke)
    {
        return view('pages.wilaya_dinkes.edit', compact('wilayaDinke'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WilayaDinkesRequest $request, WilayaDinkes $wilayaDinke)
    {
        $wilayaDinke->update($request->validated());
        Alert::success('Berhasil', 'Wilayah Dinkes berhasil diperbarui.');
        return redirect()->route('wilaya-dinkes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WilayaDinkes $wilayaDinke)
    {
        $wilayaDinke->delete();
        return response()->json(['status' => 'success', 'message' => 'Wilayah Dinkes berhasil dihapus.']);
    }
}
