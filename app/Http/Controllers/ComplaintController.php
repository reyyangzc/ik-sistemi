<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    // Admin list of complaints
    public function index()
    {
        $complaints = Complaint::with('employee')->latest()->get();
        return view('complaints.index', compact('complaints'));
    }

    // Store complaint from employee
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $employee = Auth::user()->employee;
        if (!$employee) {
            return redirect()->back()->withErrors(['message' => 'Sadece personeller şikayet ve istek gönderebilir.']);
        }

        Complaint::create([
            'employee_id' => $employee->id,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'İstek/Şikayetiniz başarıyla iletildi.');
    }

    // Update status (Admin)
    public function update(Request $request, Complaint $complaint)
    {
        $request->validate([
            'status' => 'required|in:unread,read,resolved'
        ]);

        $complaint->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Şikayet durumu güncellendi.');
    }
}
