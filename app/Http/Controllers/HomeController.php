<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
           'slides' => DB::table('site_contents')
    ->where('is_active', true)
    ->where('content_key', 'like', 'hero%')
    ->orderBy('sort_order')
    ->get(),
        ]);
    }

    public function education()
    {
        return view('pages.education');
    }

    public function about()
    {
        return view('home');
    }

    public function testimonials()
    {
        return view('home');
    }
}