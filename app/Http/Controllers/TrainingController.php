<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Training;

class TrainingController extends Controller
{
    public function index()
    {
        $trainings = Training::latest()->get();
        return view('trainings.index', compact('trainings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'training_date' => 'required|date',
            'instructor' => 'nullable|string|max:255',
            'description' => 'nullable|string'
        ]);

        Training::create($request->all());

        return redirect()->back()->with('success', 'Eğitim başarıyla eklendi.');
    }

    public function destroy(Training $training)
    {
        $training->delete();
        return redirect()->back()->with('success', 'Eğitim kaydı silindi.');
    }
}
