<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        if ($request->filled('modul')) {
            $query->where('modul', $request->modul);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $logs = $query->get();
        $moduls = ActivityLog::distinct()->pluck('modul');
        $users = \App\Models\User::all();

        return view('backend.log-aktivitas.index', compact('logs', 'moduls', 'users'));
    }
}
