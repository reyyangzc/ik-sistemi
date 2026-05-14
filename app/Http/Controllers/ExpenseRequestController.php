<?php

namespace App\Http\Controllers;

use App\Models\ExpenseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExpenseRequestController extends Controller
{
    public function index()
    {
        if (auth()->user()->role_id == 1) {
            $requests = ExpenseRequest::with('employee')->latest()->get();
            return view('expenses.index', compact('requests'));
        }

        $employee = auth()->user()->employee;
        $requests = ExpenseRequest::where('employee_id', $employee->id)->latest()->get();
        return view('expenses.my_requests', compact('requests'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:expense,advance',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:1000',
            'receipt' => 'nullable|file|mimes:jpeg,png,pdf|max:5120'
        ]);

        $path = null;
        if ($request->hasFile('receipt')) {
            $path = $request->file('receipt')->store('receipts', 'public');
        }

        ExpenseRequest::create([
            'employee_id' => auth()->user()->employee->id,
            'type' => $request->type,
            'amount' => $request->amount,
            'description' => $request->description,
            'receipt_path' => $path,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Talebiniz başarıyla oluşturuldu.');
    }

    public function approve(Request $request, ExpenseRequest $expense)
    {
        if (auth()->user()->role_id != 1) abort(403);

        $expense->update([
            'status' => 'approved',
            'admin_note' => $request->admin_note
        ]);

        return back()->with('success', 'Talep onaylandı.');
    }

    public function reject(Request $request, ExpenseRequest $expense)
    {
        if (auth()->user()->role_id != 1) abort(403);

        $expense->update([
            'status' => 'rejected',
            'admin_note' => $request->admin_note
        ]);

        return back()->with('success', 'Talep reddedildi.');
    }
}
