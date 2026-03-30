<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskComment;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Stratejik Rapor Ekranı (Dashboard)
     * CEO/CSO ve Personel bazlı filtreleme yapar.
     */
    public function index()
    {
        $user = Auth::user();

        // 1. Yetki Kontrolü: İbrahim Uğur Yılmaz (Admin) her şeyi görür
        if ($user->email === 'admin@ik.com') {
            $tasks = Task::with(['assignee', 'subTasks', 'comments.user'])->get();
        } else {
            // 2. Personel sadece kendine atanan dosyaları görür
            $tasks = Task::where('assigned_to', $user->id)
                         ->with(['assignee', 'subTasks', 'comments.user'])
                         ->get();
        }

        // Tasarımı giydirdiğimiz yeni dashboard view'ına gönderiyoruz
        return view('dashboard', compact('tasks'));
    }

    /**
     * Operasyonel Durum Güncelleme
     * İş Kuralı: Alt süreçler bitmeden ana dosya kapatılamaz.
     */
    public function updateStatus(Request $request, $id)
    {
        $task = Task::with('subTasks')->findOrFail($id);
        $newStatus = $request->input('status');

        // İş Kuralı Denetimi
        if ($newStatus === 'tamamlandi') {
            $unfinishedSubTasks = $task->subTasks()->where('status', 'yapilacak')->count();

            if ($unfinishedSubTasks > 0) {
                return redirect()->back()->with('error', 'KRİTİK HATA: Bekleyen alt süreçler varken dosya arşive kaldırılamaz!');
            }
        }

        $task->status = $newStatus;
        $task->save();

        return redirect()->back()->with('success', 'Dosya durumu başarıyla güncellendi.');
    }

    /**
     * Kurumsal Not (Yorum) Ekleme
     */
    public function storeComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|min:3'
        ]);

        TaskComment::create([
            'task_id' => $id,
            'user_id' => Auth::id(), // Giriş yapan kullanıcının ID'si otomatik alınır
            'comment' => $request->comment
        ]);

        return redirect()->back()->with('success', 'Kurumsal not sisteme işlendi.');
    }
}