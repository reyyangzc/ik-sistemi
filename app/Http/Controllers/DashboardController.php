<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Employee;
use App\Models\Leave;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Dashboard ana sayfasını görüntüler.
     */
    
 public function index()
{
    $announcements = \App\Models\Announcement::with('user')->latest()->take(5)->get();
    
    $stats = [];
    if (auth()->user()->role_id == 1) {
        $stats['employee_count'] = \App\Models\Employee::count();
        $stats['pending_leaves'] = \App\Models\Leave::where('status', 'pending')->count();
    }

    return view('dashboard', compact('announcements', 'stats'));
}
}