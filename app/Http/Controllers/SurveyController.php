<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveyQuestion;
use App\Models\SurveyResponse;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function index()
    {
        if (auth()->user()->role_id == 1) {
            $surveys = Survey::withCount('responses')->latest()->get();
            return view('surveys.admin_index', compact('surveys'));
        }

        $surveys = Survey::where('status', 'active')
            ->where(function ($query) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>', now());
            })->latest()->get();

        $employeeId = auth()->user()->employee->id;
        $completedSurveys = SurveyResponse::where('employee_id', $employeeId)
            ->pluck('survey_id')->unique()->toArray();

        return view('surveys.employee_index', compact('surveys', 'completedSurveys'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role_id != 1) abort(403);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'expires_at' => 'nullable|date|after:today',
            'questions' => 'required|array|min:1',
            'questions.*.text' => 'required|string',
            'questions.*.type' => 'required|in:text,choice',
            'questions.*.options' => 'nullable|string'
        ]);

        $survey = Survey::create([
            'title' => $request->title,
            'description' => $request->description,
            'expires_at' => $request->expires_at,
            'status' => 'active'
        ]);

        foreach ($request->questions as $q) {
            $options = null;
            if ($q['type'] == 'choice' && !empty($q['options'])) {
                $options = array_map('trim', explode(',', $q['options']));
            }

            SurveyQuestion::create([
                'survey_id' => $survey->id,
                'question_text' => $q['text'],
                'type' => $q['type'],
                'options' => $options
            ]);
        }

        return redirect()->route('surveys.index')->with('success', 'Anket başarıyla oluşturuldu.');
    }

    public function show(Survey $survey)
    {
        if (auth()->user()->role_id == 1) {
            $survey->load(['questions', 'responses.employee']);
            return view('surveys.show_admin', compact('survey'));
        }

        $employeeId = auth()->user()->employee->id;
        $hasCompleted = SurveyResponse::where('survey_id', $survey->id)
            ->where('employee_id', $employeeId)->exists();

        if ($hasCompleted || $survey->status != 'active' || ($survey->expires_at && $survey->expires_at < now())) {
            return redirect()->route('surveys.index')->with('error', 'Bu ankete daha önce katıldınız veya anket süresi doldu.');
        }

        $survey->load('questions');
        return view('surveys.take', compact('survey'));
    }

    public function submit(Request $request, Survey $survey)
    {
        if (auth()->user()->role_id == 1) abort(403);

        $employeeId = auth()->user()->employee->id;
        
        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required'
        ]);

        foreach ($request->answers as $questionId => $answer) {
            SurveyResponse::create([
                'survey_id' => $survey->id,
                'employee_id' => $employeeId,
                'survey_question_id' => $questionId,
                'answer_text' => is_array($answer) ? json_encode($answer) : $answer
            ]);
        }

        return redirect()->route('surveys.index')->with('success', 'Anket yanıtınız başarıyla kaydedildi. Teşekkürler!');
    }
}
