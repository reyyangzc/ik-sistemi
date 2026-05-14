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
            // Admin: Tüm personellerin maaş geçmişi ve güncel maaşları
            $employees = Employee::with(['department', 'position', 'salaries'])->get();
            return view('salaries.index', compact('employees'));
        } else {
            // Personel: Sadece kendi maaş bordrolarını gör
            $employee = auth()->user()->employee;
            $salaries = $employee ? Salary::where('employee_id', $employee->id)->latest()->get() : collect();
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
            'bonus' => 'nullable|numeric|min:0',
            'deduction' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'payment_date' => 'required|date',
        ]);

        $amount = $validated['amount'];
        $bonus = $validated['bonus'] ?? 0;
        $deduction = $validated['deduction'] ?? 0;
        $net_salary = $amount + $bonus - $deduction;

        $validated['bonus'] = $bonus;
        $validated['deduction'] = $deduction;
        $validated['net_salary'] = $net_salary;

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

    /**
     * Maaş Bordrosunu PDF olarak indirir.
     */
    public function downloadPdf(Salary $salary)
    {
        // Yetki Kontrolü: Personel sadece kendi maaşını indirebilir
        if (auth()->user()->role_id != 1 && auth()->user()->employee->id != $salary->employee_id) {
            abort(403, 'Bu bordroyu görüntüleme yetkiniz yok.');
        }

        $salary->load(['employee.department', 'employee.position']);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('salaries.pdf', compact('salary'));
        
        return $pdf->download('Bordro_' . $salary->employee->first_name . '_' . $salary->employee->last_name . '_' . \Carbon\Carbon::parse($salary->payment_date)->format('Y_m') . '.pdf');
    }
}