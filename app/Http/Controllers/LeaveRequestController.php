<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    public function index()
    {
        $requests = collect([]); 

        // Sadece admin ise verileri çek
        if (auth()->check() && auth()->user()->role_id == 1) {
            $requests = LeaveRequest::with('employee')->latest()->get();
        }
        
        return view('leaves.index', compact('requests'));
    }

  public function store(Request $request)
{
    
  dd("PERSONEL FORMU GELDİ!", $request->all());
  
    $request->validate([
        'employee_id' => 'required|exists:employees,id',
        'start_date'  => 'required|date',
        'end_date'    => 'required|date|after_or_equal:start_date',
        'type'        => 'required', 
    ]);

    // MANUEL EŞLEŞTİRME (Hata riskini sıfırlar)
    \App\Models\LeaveRequest::create([
        'employee_id' => $request->employee_id,
        'start_date'  => $request->start_date,
        'end_date'    => $request->end_date,
        'status'      => 'pending',
        // EĞER VERİTABANINDA SÜTUN ADI 'type' İSE BURAYA 'type' YAZ:
        'type'        => $request->type, 
        // EĞER VERİTABANINDA 'leave_type_id' İSE BURAYI 'leave_type_id' YAP:
        // 'leave_type_id' => $request->type, 
    ]);

    return redirect()->back()->with('success', 'İzin talebiniz başarıyla iletildi.');
}

    public function updateStatus(Request $request, LeaveRequest $leave)
    {
        $request->validate(['status' => 'required|in:approved,rejected']);
        $leave->update(['status' => $request->status]);
        
        return redirect()->back()->with('success', 'İzin durumu güncellendi.');
    }

    public function destroy(LeaveRequest $leave)
    {
        $leave->delete();
        return redirect()->back()->with('success', 'İzin talebi sistemden silindi.');
    }
}