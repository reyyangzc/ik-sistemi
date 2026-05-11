<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    // Duyuruları listeleme ve ekleme formu sayfası
    public function index()
    {
        $announcements = Announcement::latest()->get();
        return view('announcements.index', compact('announcements'));
    }

    // Yeni duyuruyu veritabanına kaydetme
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => auth()->id(), // Giriş yapan adminin ID'si
        ]);

        return redirect()->back()->with('success', 'Duyuru başarıyla yayınlandı.');
    }

    // Duyuru silme
    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return redirect()->back()->with('success', 'Duyuru silindi.');
    }
}