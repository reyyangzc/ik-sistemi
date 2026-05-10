<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    // Veritabanındaki personelleri çekmeye çalışırız
    // Eğer henüz Employee modelini veya tablosunu tam yapmadıysak burası hata verebilir
    try {
        $employees = \App\Models\Employee::all();
    } catch (\Exception $e) {
        $employees = []; // Hata alırsak boş liste gönderelim ki sayfa açılmasın
    }

    return view('employees.index', compact('employees'));
}
    /**
     * Show the form for creating a new resource.
     */
   public function create()
{
    // Veritabanındaki departmanları ve ünvanları çekiyoruz ki formda "Seçiniz" kutusunda gösterelim
    $departments = \App\Models\Department::all();
    $positions = \App\Models\Position::all();

    // employees klasöründeki create sayfasını aç ve bu verileri oraya gönder
    return view('employees.create', compact('departments', 'positions'));
}

    /**
     * Store a newly created resource in storage.
     */
  public function store(Request $request)
    {
        // 1. Formdan gelen verileri alıp doğruluyoruz
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:employees,email',
            'phone'      => 'nullable|string|max:20',
            'hire_date'  => 'required|date',
            'base_salary'=> 'required|numeric',
            'department_id' => 'required|exists:departments,id',
            'position_id'   => 'required|exists:positions,id',
        ]);

        // 2. Doğrulanan veriyi veritabanına kaydet
        \App\Models\Employee::create($validated);

        // 3. İşlem bitince personel listesi sayfasına geri dön
        return redirect()->route('employees.index');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(\App\Models\Employee $employee)
{
    // Veritabanındaki tüm departman ve ünvanları çekiyoruz (dropdownlar için)
    $departments = \App\Models\Department::all();
    $positions = \App\Models\Position::all();

    // Personel bilgileriyle birlikte edit sayfasına gönderiyoruz
    return view('employees.edit', compact('employee', 'departments', 'positions'));
}

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, \App\Models\Employee $employee)
{
    $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name'  => 'required|string|max:255',
        'email'      => 'required|email|unique:employees,email,'.$employee->id,
        'phone'      => 'nullable|string|max:20',
        'hire_date'  => 'required|date',
        'base_salary'=> 'required|numeric',
        'department_id' => 'required|exists:departments,id',
        'position_id'   => 'required|exists:positions,id',
    ]);

    $employee->update($validated);
    return redirect()->route('employees.index');
}

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(\App\Models\Employee $employee)
{
    $employee->delete();
    return redirect()->route('employees.index');
}
}
