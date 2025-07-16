<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Models\User;

class ActivityLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-activity-logs');
    }

    public function index(Request $request)
    {
        $this->authorize('view-activity-logs');

        $logs = ActivityLog::with(['user', 'causer'])
            ->latest()
            ->paginate(20);

        // Carregar os usuários para o dropdown de filtro
        $users = User::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        $logs = ActivityLog::with(['user', 'model'])
            ->when($request->user_id, fn($q, $id) => $q->where('user_id', $id))
            ->when($request->event, fn($q, $event) => $q->where('event', $event))
            ->when($request->model_type, function($q, $type) {
                $q->where('model_type', 'App\Models\\' . $type);
            })
            ->when($request->search, fn($q, $search) => 
                $q->whereHas('user', fn($q) => 
                    $q->where('name', 'like', "%$search%")
                )
                ->orWhere('description', 'like', "%$search%")
            )
            ->latest()
            ->paginate(25);

        return view('admin.activity-logs.index', [
            'logs' => $logs,
            'users' => $users
        ]);
    }

    public function show(ActivityLog $activityLog)
    {
        $this->authorize('view-activity-logs');

        return view('admin.activity-logs.show', compact('activityLog'));
    }
}
