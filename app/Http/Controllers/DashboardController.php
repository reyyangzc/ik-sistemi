<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Employee;
use App\Models\Leave;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('user')->latest()->take(5)->get();
        $stats = [];
        $employeeData = [];

        if (auth()->user()->role_id == 1) {
            $stats['employee_count'] = Employee::count();
            
            // Bekleyen Talepler
            $stats['pending_leaves'] = \App\Models\LeaveRequest::where('status', 'pending')->count();
            $stats['pending_expenses'] = \App\Models\ExpenseRequest::where('status', 'pending')->count();
            $stats['pending_profiles'] = \App\Models\ProfileUpdateRequest::where('status', 'pending')->count();
            $stats['total_pending'] = $stats['pending_leaves'] + $stats['pending_expenses'] + $stats['pending_profiles'];
            
            // Bugün İzinli Olanlar
            $today = now()->format('Y-m-d');
            $stats['on_leave_today'] = \App\Models\LeaveRequest::where('status', 'approved')
                ->where('start_date', '<=', $today)
                ->where('end_date', '>=', $today)
                ->with('employee')
                ->get();
            
            // Yaklaşan Doğum Günleri (Önümüzdeki 30 gün)
            $employeesWithBirthdays = Employee::whereNotNull('birth_date')->get();
            $upcomingBirthdays = $employeesWithBirthdays->filter(function($emp) {
                // birth_date veritabanında datetime/date olarak tutuluyor (string dönse de carbon'a parse edebiliriz)
                $birthDate = \Carbon\Carbon::parse($emp->birth_date);
                $birthdayThisYear = \Carbon\Carbon::create(now()->year, $birthDate->month, $birthDate->day);
                
                if ($birthdayThisYear->isPast() && !$birthdayThisYear->isToday()) {
                    $birthdayThisYear->addYear();
                }
                
                return $birthdayThisYear->between(now()->startOfDay(), now()->addDays(30)->endOfDay());
            })->sortBy(function($emp) {
                $birthDate = \Carbon\Carbon::parse($emp->birth_date);
                $birthdayThisYear = \Carbon\Carbon::create(now()->year, $birthDate->month, $birthDate->day);
                if ($birthdayThisYear->isPast() && !$birthdayThisYear->isToday()) {
                    $birthdayThisYear->addYear();
                }
                return $birthdayThisYear;
            })->take(5);
            $stats['upcoming_birthdays'] = $upcomingBirthdays;
            
            // Departman Dağılımı (Grafik İçin)
            $stats['department_distribution'] = \App\Models\Department::withCount('employees')
                ->get()
                ->map(function ($dept) {
                    return [
                        'name' => $dept->name,
                        'count' => $dept->employees_count
                    ];
                });

            // Finansal Takip: Toplam Maaş ve Departman Bazlı Maliyetler
            $stats['total_salary'] = Employee::sum('base_salary');
            
            $stats['department_costs'] = \App\Models\Department::withSum('employees', 'base_salary')
                ->get()
                ->map(function ($dept) {
                    return [
                        'name' => $dept->name,
                        'total' => $dept->employees_sum_base_salary ?? 0
                    ];
                })->sortByDesc('total');

        } else {
            // Employee data
            $employee = auth()->user()->employee;
            if ($employee) {
                $employeeData['salaries'] = $employee->salaries()->latest()->get();
                $employeeData['leaves'] = $employee->leaveRequests()->latest()->take(5)->get();
                $employeeData['complaints'] = \App\Models\Complaint::where('employee_id', $employee->id)->latest()->take(5)->get();
            }
        }

        return view('dashboard', compact('announcements', 'stats', 'employeeData'));
    }
}