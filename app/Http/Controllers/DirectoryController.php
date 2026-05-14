<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class DirectoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $employees = Employee::with(['department', 'position'])
            ->when($search, function ($query, $search) {
                return $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('department', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('position', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->orderBy('first_name')
            ->get();

        return view('directory.index', compact('employees', 'search'));
    }
}
