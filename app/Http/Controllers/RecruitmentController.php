<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use App\Models\Candidate;
use App\Models\Department;
use Illuminate\Http\Request;

class RecruitmentController extends Controller
{
    public function index()
    {
        // Admin only
        if (auth()->user()->role_id != 1) abort(403);

        $postings = JobPosting::with('department')->withCount('candidates')->latest()->get();
        $departments = Department::all();

        return view('recruitment.index', compact('postings', 'departments'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role_id != 1) abort(403);

        $request->validate([
            'title' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'description' => 'required|string',
            'status' => 'required|in:active,closed,draft'
        ]);

        JobPosting::create($request->all());

        return redirect()->route('recruitment.index')->with('success', 'İş ilanı başarıyla oluşturuldu.');
    }

    public function candidates(JobPosting $posting)
    {
        if (auth()->user()->role_id != 1) abort(403);

        $posting->load('candidates');
        return view('recruitment.candidates', compact('posting'));
    }

    public function addCandidate(Request $request, JobPosting $posting)
    {
        if (auth()->user()->role_id != 1) abort(403);

        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string'
        ]);

        $posting->candidates()->create($request->all());

        return back()->with('success', 'Aday başarıyla eklendi.');
    }

    public function updateCandidateStatus(Request $request, Candidate $candidate)
    {
        if (auth()->user()->role_id != 1) abort(403);

        $request->validate([
            'status' => 'required|in:applied,reviewing,interviewed,hired,rejected'
        ]);

        $candidate->update(['status' => $request->status]);

        return back()->with('success', 'Aday durumu güncellendi.');
    }
}
