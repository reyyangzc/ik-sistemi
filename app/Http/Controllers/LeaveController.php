<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\LeaveType;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    // 1. Tüm İzinleri Listele (Admin hepsini, Personel sadece kendininkini görür)
    public function index()
    {
        if (auth()->user()->role_id == 1) {
            $leaves = Leave::with(['employee', 'leaveType'])->latest()->get();
        } else {
            // User ile Employee ilişkisi üzerinden sadece giriş yapanın izinleri
            $leaves = Leave::where('employee_id', auth()->user()->id)->with('leaveType')->get();
        }
        return view('leaves.index', compact('leaves'));
    }

    // 2. Yeni İzin Talebi Sayfası
    public function create()
    {
        $leaveTypes = LeaveType::all();
        return view('leaves.create', compact('leaveTypes'));
    }

    // 3. İzin Talebini Kaydet (Güvenlik: Validasyon)
    public function store(Request $request)
    {
        $request->validate([
            'leave_type_id' => 'required',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        Leave::create([
            'employee_id' => auth()->user()->id,
            'leave_type_id' => $request->leave_type_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'status' => 'pending' // Başlangıçta beklemede
        ]);

        return redirect()->route('dashboard')->with('success', 'İzin talebiniz iletildi.');
    }

// 4. Admin Onaylama Mekanizması ve Log Kaydı
    public function updateStatus(Request $request, \App\Models\Leave $leave)
    {
        // 1. Yetki Kontrolü (Sadece Admin)
        if (auth()->user()->role_id != 1) {
            abort(403, 'Yetkisiz işlem.');
        }

        $oldStatus = $leave->status;
        $newStatus = $request->status; // 'approved' veya 'rejected' gelecek

        // 2. Veritabanını Güncelle
        $leave->update(['status' => $newStatus]);

        // 3. İşlem Logu Kaydı
        \App\Models\Log::create([
            'user_id' => auth()->id(),
            'action' => 'İzin Durumu Değiştirildi',
            'description' => "{$leave->employee->first_name} isimli personelin izni '{$oldStatus}' durumundan '{$newStatus}' durumuna getirildi.",
        ]);

        return back()->with('success', 'İşlem başarıyla loglandı ve güncellendi.');
    }
}