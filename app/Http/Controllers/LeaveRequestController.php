<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveRequestController extends Controller
{
    public function index()
    {
        if (auth()->user()->role_id == 1) {
            $leaves = LeaveRequest::with('employee')->latest()->get();
        } else {
            $employee = auth()->user()->employee;
            $leaves = $employee ? LeaveRequest::where('employee_id', $employee->id)->latest()->get() : collect();
        }
        
        return view('leaves.index', compact('leaves'));
    }

    public function create()
    {
        return view('leaves.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'type'        => 'required', 
            'reason'      => 'nullable|string'
        ]);

        $employee = Auth::user()->employee;
        if (!$employee) {
            return redirect()->back()->withErrors(['message' => 'Sadece personeller izin talebinde bulunabilir.']);
        }

        LeaveRequest::create([
            'employee_id' => $employee->id,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'status'      => 'pending',
            'type'        => $request->type, 
            'reason'      => $request->reason,
        ]);

        return redirect()->back()->with('success', 'İzin talebiniz başarıyla iletildi.');
    }

    public function updateStatus(Request $request, LeaveRequest $leave)
    {
        $request->validate(['status' => 'required|in:approved,rejected,suspended']);
        $leave->update(['status' => $request->status]);
        
        return redirect()->back()->with('success', 'İzin durumu güncellendi.');
    }

    public function destroy(LeaveRequest $leave)
    {
        $leave->delete();
        return redirect()->back()->with('success', 'İzin talebi sistemden silindi.');
    }
}