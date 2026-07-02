<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        // Only admin can view audit logs
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

        $query = AuditLog::with('user', 'document');

        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $logs = $query->latest('created_at')->paginate(15);

        $actions = AuditLog::distinct()
            ->pluck('action');

        return view('audit-logs.index', compact('logs', 'actions'));
    }
}