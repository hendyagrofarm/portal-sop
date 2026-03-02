<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalDocuments = Document::count();

        $totalCategories = Document::query()
            ->whereNotNull('kategori')
            ->where('kategori', '!=', '')
            ->distinct()
            ->count('kategori');

        $latestDocuments = Document::latest()
            ->select('id', 'nomor_dokumen', 'judul', 'kategori', 'updated_at')
            ->take(5)
            ->get();

        $categoryBreakdown = Document::query()
            ->select('kategori', DB::raw('COUNT(*) as total'))
            ->whereNotNull('kategori')
            ->where('kategori', '!=', '')
            ->groupBy('kategori')
            ->orderByDesc('total')
            ->take(8)
            ->get();

        $totalUsers = null;
        if ($request->user()?->role === 'admin') {
            $totalUsers = User::count();
        }

        return inertia('Dashboard', [
            'stats' => [
                'totalDocuments' => $totalDocuments,
                'totalCategories' => $totalCategories,
                'totalUsers' => $totalUsers, // null kalau bukan admin
            ],
            'latestDocuments' => $latestDocuments,
            'categoryBreakdown' => $categoryBreakdown,
        ]);
    }
}
