<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PerformanceReview;

class PerformanceReviewController extends Controller
{
    public function index()
    {
        if (auth()->user()->role_id == 1) {
            $reviews = PerformanceReview::with(['employee', 'reviewer'])->latest()->get();
            $employees = \App\Models\Employee::all();
            return view('performance.index', compact('reviews', 'employees'));
        } else {
            $employee = auth()->user()->employee;
            $reviews = $employee ? PerformanceReview::where('employee_id', $employee->id)->with('reviewer')->latest()->get() : collect();
            return view('performance.index', compact('reviews'));
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'score' => 'required|integer|min:1|max:5',
            'period' => 'required|string',
            'comments' => 'nullable|string'
        ]);

        PerformanceReview::create([
            'employee_id' => $request->employee_id,
            'reviewer_id' => auth()->id(),
            'score' => $request->score,
            'period' => $request->period,
            'comments' => $request->comments
        ]);

        return redirect()->back()->with('success', 'Performans değerlendirmesi başarıyla kaydedildi.');
    }

    public function destroy(PerformanceReview $performance)
    {
        $performance->delete();
        return redirect()->back()->with('success', 'Değerlendirme silindi.');
    }
}
