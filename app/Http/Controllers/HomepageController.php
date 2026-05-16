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
}
