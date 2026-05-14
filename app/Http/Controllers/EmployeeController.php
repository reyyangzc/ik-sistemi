<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with(['department', 'position', 'user'])->get();
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $departments = Department::all();
        $positions = Position::all();
        return view('employees.create', compact('departments', 'positions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'base_salary' => 'required|numeric',
            'hire_date' => 'required|date',
            'birth_date' => 'nullable|date',
            'marital_status' => 'required|in:single,married',
            'children_count' => 'required|integer|min:0',
            'leave_balance' => 'required|integer|min:0',
        ]);

        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make('RAK12345'),
            'role_id' => 2 // Default to Employee role
        ]);

        Employee::create([
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'department_id' => $request->department_id,
            'position_id' => $request->position_id,
            'base_salary' => $request->base_salary,
            'hire_date' => $request->hire_date,
            'birth_date' => $request->birth_date,
            'marital_status' => $request->marital_status,
            'children_count' => $request->children_count,
            'leave_balance' => $request->leave_balance,
        ]);

        return redirect()->route('employees.index')->with('success', 'Personel başarıyla eklendi.');
    }

    public function show(Employee $employee)
    {
        $employee->load(['department', 'position', 'user', 'leaveRequests']);
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $departments = Department::all();
        $positions = Position::all();
        return view('employees.edit', compact('employee', 'departments', 'positions'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'base_salary' => 'required|numeric',
            'hire_date' => 'required|date',
            'birth_date' => 'nullable|date',
            'marital_status' => 'required|in:single,married',
            'children_count' => 'required|integer|min:0',
            'leave_balance' => 'required|integer|min:0',
        ]);

        $employee->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'department_id' => $request->department_id,
            'position_id' => $request->position_id,
            'base_salary' => $request->base_salary,
            'hire_date' => $request->hire_date,
            'birth_date' => $request->birth_date,
            'marital_status' => $request->marital_status,
            'children_count' => $request->children_count,
            'leave_balance' => $request->leave_balance,
        ]);

        if ($employee->user) {
            $employee->user->update([
                'name' => $request->first_name . ' ' . $request->last_name,
            ]);
        }

        return redirect()->route('employees.index')->with('success', 'Personel başarıyla güncellendi.');
    }

    public function destroy(Employee $employee)
    {
        if ($employee->user) {
            $employee->user->delete();
        }
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Personel başarıyla silindi.');
    }
}