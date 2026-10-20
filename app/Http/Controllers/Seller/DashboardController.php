<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSubmission;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $sellerId = $request->user()->id;

        $stats = [
            'pending'  => ProductSubmission::where('seller_id', $sellerId)->where('submission_status', 'pending')->count(),
            'approved' => ProductSubmission::where('seller_id', $sellerId)->where('submission_status', 'approved')->count(),
            'rejected' => ProductSubmission::where('seller_id', $sellerId)->where('submission_status', 'rejected')->count(),
            'ready'    => Product::where('seller_id', $sellerId)->where('status', 'ready')->count(),
            'sold_out' => Product::where('seller_id', $sellerId)->where('status', 'sold_out')->count(),
        ];

        // 10 pengajuan terbaru beserta status & catatan admin
        $submissions = ProductSubmission::with(['category', 'media'])
            ->where('seller_id', $sellerId)
            ->latest()
            ->take(10)
            ->get();

        return view('seller.dashboard', compact('stats', 'submissions'));
    }
}
