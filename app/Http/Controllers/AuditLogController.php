<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::with('user', 'document')
            ->where('user_id', auth()->id());

        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $logs = $query->latest('created_at')->paginate(15);

        $actions = AuditLog::where('user_id', auth()->id())
            ->distinct()
            ->pluck('action');

        return view('audit-logs.index', compact('logs', 'actions'));
    }
}