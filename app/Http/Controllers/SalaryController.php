<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use App\Models\Employee;
use App\Models\Log;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    /**
     * Maaş listesini görüntüler.
     * Yetkilendirme: Admin tümünü, Personel sadece kendininkini görür.
     */
    public function index()
    {
        if (auth()->user()->role_id == 1) {
            // Admin: Tüm personellerin maaş geçmişini gör
            $salaries = Salary::with('employee')->latest()->get();
            $employees = Employee::all(); // Maaş ekleme formu için personel listesi
            return view('salaries.index', compact('salaries', 'employees'));
        } else {
            // Personel: Sadece kendi maaş bordrolarını gör
            $salaries = Salary::where('employee_id', auth()->user()->id)->latest()->get();
            return view('salaries.index', compact('salaries'));
        }
    }

    /**
     * Yeni maaş kaydı oluşturur (Sadece Admin).
     */
    public function store(Request $request)
    {
        // Yetki Kontrolü
        if (auth()->user()->role_id != 1) {
            abort(403, 'Bu işlem için yetkiniz yok.');
        }

        // PDF Madde 51: Validasyon ile SQL Injection koruması
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
        ]);

        $salary = Salary::create($validated);

        // PDF Madde 68: İşlem Logu Kaydı
        Log::create([
            'user_id' => auth()->id(),
            'action' => 'Maaş Tanımlandı',
            'description' => $salary->employee->first_name . " için " . $salary->amount . " TL tutarında maaş girişi yapıldı.",
            'ip_address' => $request->ip()
        ]);

        return redirect()->route('salaries.index')->with('success', 'Maaş kaydı başarıyla eklendi.');
    }
}