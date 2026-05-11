<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use App\Models\User;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Personel Listesi
     */
    public function index()
    {
        $employees = Employee::with(['department', 'position'])->latest()->get();
        return view('employees.index', compact('employees'));
    }

    /**
     * Yeni Personel Ekleme Formu
     */
    public function create()
    {
        $departments = Department::all();
        $positions = Position::all();
        return view('employees.create', compact('departments', 'positions'));
    }

    /**
     * Kayıt İşlemi
     */
public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'email'         => 'required|email|unique:employees,email|unique:users,email',
            'department_id' => 'required',
            'position_id'   => 'required',
            'hire_date'     => 'required|date',
            'base_salary'   => 'required|numeric',
        ]);

        // 1. Kullanıcı Oluştur (E-posta çakışmaması için burada unique kontrolü yaptık)
        $user = \App\Models\User::create([
            'name'     => $request->first_name . ' ' . $request->last_name,
            'email'    => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
            'role_id'  => 2, 
        ]);

        // 2. Personel Oluştur
        $employeeData = $validated;
        $employeeData['user_id'] = $user->id; // Hesabı bağladık
        
        $employee = \App\Models\Employee::create($employeeData);

        // 3. Log Kaydı (Artık fillable olduğu için hata vermeyecek)
        \App\Models\Log::create([
            'user_id' => auth()->id(),
            'action'  => 'Personel Tanımlama',
            'description' => "{$employee->first_name} {$employee->last_name} eklendi."
        ]);

        return redirect()->route('employees.index')->with('success', 'Personel başarıyla kadroya alındı!');

    } catch (\Illuminate\Validation\ValidationException $e) {
        // E-posta hatası alırsan seni siyah ekrana değil, kırmızı kutuya atsın:
        return redirect()->back()->withErrors($e->validator)->withInput();
    } catch (\Exception $e) {
        dd("HATA MESAJI: " . $e->getMessage());
    }
}
    /**
     * Güncelleme
     */
    public function update(Request $request, Employee $employee)
    {
        try {
            $validated = $request->validate([
                'first_name'    => 'required|string|max:255',
                'last_name'     => 'required|string|max:255',
                'email'         => 'required|email|unique:employees,email,'.$employee->id,
                'phone'         => 'nullable|string|max:20',
                'hire_date'     => 'required|date',
                'base_salary'   => 'required|numeric',
                'department_id' => 'required|exists:departments,id',
                'position_id'   => 'required|exists:positions,id',
            ]);

            $employee->update($validated);

            Log::create([
                'user_id' => auth()->id(),
                'action' => 'Personel Güncelleme',
                'description' => "{$employee->first_name} {$employee->last_name} adlı personelin bilgileri güncellendi."
            ]);

            return redirect()->route('employees.index')->with('success', 'Bilgiler başarıyla güncellendi.');
            
        } catch (\Exception $e) {
            dd("GÜNCELLEME HATASI:", $e->getMessage());
        }
    }

    /**
     * Silme
     */
    public function destroy(Employee $employee)
    {
        $name = $employee->first_name . ' ' . $employee->last_name;
        
        if($employee->user_id) {
            User::where('id', $employee->user_id)->delete();
        }

        $employee->delete();

        Log::create([
            'user_id' => auth()->id(),
            'action' => 'Personel Çıkışı',
            'description' => "{$name} sistemden ve kadrodan çıkarıldı."
        ]);

        return redirect()->route('employees.index')->with('success', 'Personel sistemden tamamen silindi.');
    }
}