<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
{
    // withCount kullanarak her departmana ait personel sayısını otomatik hesaplıyoruz
    $departments = \App\Models\Department::withCount('employees')->get();
    
    return view('departments.index', compact('departments'));
   }
    
}