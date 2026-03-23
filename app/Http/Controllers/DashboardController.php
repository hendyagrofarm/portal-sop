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
        $totalDocuments = Document::where('status', 'active')->count();

        $totalCategories = Document::query()
            ->where('status', 'active')
            ->whereNotNull('kategori')
            ->where('kategori', '!=', '')
            ->distinct()
            ->count('kategori');

        $latestDocuments = Document::query()
            ->where('status', 'active')
            ->latest()
            ->select('id', 'nomor_dokumen', 'judul', 'kategori', 'updated_at')
            ->take(5)
            ->get();

        $categoryBreakdown = Document::query()
            ->select('kategori', DB::raw('COUNT(*) as total'))
            ->where('status', 'active')
            ->whereNotNull('kategori')
            ->where('kategori', '!=', '')
            ->groupBy('kategori')
            ->orderByDesc('total')
            ->take(8)
            ->get();

        $revokedDocuments = Document::query()
            ->where('status', 'revoked')
            ->latest('revoked_at')
            ->select('id', 'nomor_dokumen', 'judul', 'kategori', 'revoked_at', 'revoked_reason')
            ->take(5)
            ->get();

        $totalRevoked = Document::where('status', 'revoked')->count();

        $totalUsers = null;
        if ($request->user()?->role === 'admin') {
            $totalUsers = User::count();
        }

        return inertia('Dashboard', [
            'stats' => [
                'totalDocuments' => $totalDocuments,
                'totalCategories' => $totalCategories,
                'totalUsers' => $totalUsers,
                'totalRevoked' => $totalRevoked,
            ],
            'latestDocuments' => $latestDocuments,
            'categoryBreakdown' => $categoryBreakdown,
            'revokedDocuments' => $revokedDocuments,
        ]);
    }
}