<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSubmission;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'pending_submissions' => ProductSubmission::where('submission_status', 'pending')->count(),
            'products'            => Product::count(),
            'categories'          => Category::count(),
            'sellers'             => User::where('role', 'seller')->count(),
        ];

        // Pengajuan yang paling lama menunggu ditaruh di atas.
        $pendingSubmissions = ProductSubmission::with(['seller', 'category'])
            ->where('submission_status', 'pending')
            ->oldest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'pendingSubmissions'));
    }
}
