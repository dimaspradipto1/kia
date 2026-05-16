<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\DataTables\FaqDataTable;
use App\Models\Faq;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class FaqController extends Controller
{
    public function index(FaqDataTable $dataTable)
    {
        return $dataTable->render('pages.faq.index');
    }

    public function create()
    {
        return view('pages.faq.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'jawaban' => 'required|string',
            'tips' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        Faq::create($request->all());

        Alert::success('Berhasil', 'FAQ berhasil ditambahkan.');
        return redirect()->route('faqs.index');
    }

    public function show(Faq $faq)
    {
        return view('pages.faq.show', compact('faq'));
    }

    public function edit(Faq $faq)
    {
        return view('pages.faq.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'jawaban' => 'required|string',
            'tips' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        $faq->update($request->all());

        Alert::success('Berhasil', 'FAQ berhasil diperbarui.');
        return redirect()->route('faqs.index');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        Alert::success('Berhasil', 'FAQ berhasil dihapus.');
        return redirect()->route('faqs.index');
    }
}
