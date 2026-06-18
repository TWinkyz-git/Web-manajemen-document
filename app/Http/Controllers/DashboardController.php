<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDocuments = Document::where('user_id', auth()->id())->count();
        $totalCategories = Category::count();
        $recentDocuments = Document::with('category')
            ->where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();
        $recentLogs = AuditLog::with('document')
            ->where('user_id', auth()->id())
            ->latest('created_at')
            ->take(10)
            ->get();

        return view('dashboard', compact(
            'totalDocuments',
            'totalCategories',
            'recentDocuments',
            'recentLogs'
        ));
    }
}