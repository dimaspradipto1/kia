<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Faq;

class HomepageController extends Controller
{
    public function index()
    {
        $faqs = Faq::where('is_active', true)->get();
        return view('layouts.homepage.index', compact('faqs'));
    }

    public function about()
    {
        return view('layouts.homepage.about');
    }

    public function contact()
    {
        return view('layouts.homepage.contact');
    }

    public function artikel()
    {
        return view('layouts.homepage.artikel');
    }

    public function layanan()
    {
        return view('layouts.homepage.layanan');
    }
}
