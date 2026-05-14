<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->get();
        return view('announcements.index', compact('announcements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Duyuru başarıyla yayınlandı.');
    }

    public function edit(Announcement $announcement)
    {
        return view('announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        $announcement->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('announcements.index')->with('success', 'Duyuru güncellendi.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return redirect()->route('announcements.index')->with('success', 'Duyuru silindi.');
    }
}