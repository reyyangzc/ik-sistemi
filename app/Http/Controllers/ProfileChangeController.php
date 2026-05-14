<?php

namespace App\Http\Controllers;

use App\Models\ProfileChangeRequest;
use App\Models\Employee;
use Illuminate\Http\Request;

class ProfileChangeController extends Controller
{
    public function index()
    {
        // Admin views all pending requests
        if (auth()->user()->role_id == 1) {
            $requests = ProfileChangeRequest::with('employee')->latest()->get();
            return view('profile_changes.index', compact('requests'));
        }
        
        // Employee views their own requests
        $employee = auth()->user()->employee;
        $requests = ProfileChangeRequest::where('employee_id', $employee->id)->latest()->get();
        return view('profile_changes.my_requests', compact('requests', 'employee'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'marital_status' => 'nullable|in:single,married',
            'children_count' => 'nullable|integer|min:0',
        ]);

        $employee = auth()->user()->employee;

        // Check if there is already a pending request
        $hasPending = ProfileChangeRequest::where('employee_id', $employee->id)
            ->where('status', 'pending')
            ->exists();

        if ($hasPending) {
            return back()->withErrors(['error' => 'Zaten bekleyen bir profil güncelleme talebiniz var.']);
        }

        $requestedData = array_filter([
            'phone' => $request->phone,
            'birth_date' => $request->birth_date,
            'marital_status' => $request->marital_status,
            'children_count' => $request->children_count,
        ]);

        if (empty($requestedData)) {
            return back()->withErrors(['error' => 'Herhangi bir değişiklik yapmadınız.']);
        }

        ProfileChangeRequest::create([
            'employee_id' => $employee->id,
            'requested_data' => $requestedData,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Profil güncelleme talebiniz başarıyla yönetime iletildi.');
    }

    public function approve(Request $request, ProfileChangeRequest $changeRequest)
    {
        if (auth()->user()->role_id != 1) abort(403);

        // Update employee data
        $changeRequest->employee->update($changeRequest->requested_data);

        $changeRequest->update([
            'status' => 'approved',
            'admin_note' => $request->admin_note
        ]);

        return back()->with('success', 'Talep onaylandı ve personel profili güncellendi.');
    }

    public function reject(Request $request, ProfileChangeRequest $changeRequest)
    {
        if (auth()->user()->role_id != 1) abort(403);

        $changeRequest->update([
            'status' => 'rejected',
            'admin_note' => $request->admin_note
        ]);

        return back()->with('success', 'Talep reddedildi.');
    }
}
