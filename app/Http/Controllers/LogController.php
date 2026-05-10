<?php

namespace App\Http\Controllers;
use App\Models\Log;

class LogController extends Controller
{
    public function index()
    {
        // Sadece admin erişebilir (Madde 62)
        if (auth()->user()->role_id != 1) { abort(403); }

        $logs = Log::with('user')->latest()->paginate(20);
        return view('logs.index', compact('logs'));
    }
}