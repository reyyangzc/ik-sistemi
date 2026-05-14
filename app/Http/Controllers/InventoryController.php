<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\InventoryAssignment;
use App\Models\Employee;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        if (auth()->user()->role_id == 1) {
            $inventories = Inventory::with(['currentAssignment.employee'])->latest()->get();
            $employees = Employee::all();
            return view('inventories.index', compact('inventories', 'employees'));
        }

        $employee = auth()->user()->employee;
        $assignments = InventoryAssignment::with('inventory')
            ->where('employee_id', $employee->id)
            ->latest('assigned_at')
            ->get();
            
        return view('inventories.my_inventory', compact('assignments'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role_id != 1) abort(403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'serial_number' => 'nullable|string|max:255|unique:inventories,serial_number',
            'type' => 'required|string|max:100',
            'notes' => 'nullable|string'
        ]);

        Inventory::create($validated);

        return back()->with('success', 'Demirbaş başarıyla eklendi.');
    }

    public function update(Request $request, Inventory $inventory)
    {
        if (auth()->user()->role_id != 1) abort(403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'serial_number' => 'nullable|string|max:255|unique:inventories,serial_number,' . $inventory->id,
            'type' => 'required|string|max:100',
            'status' => 'required|in:available,assigned,maintenance,retired',
            'notes' => 'nullable|string'
        ]);

        $inventory->update($validated);

        return back()->with('success', 'Demirbaş güncellendi.');
    }

    public function assign(Request $request, Inventory $inventory)
    {
        if (auth()->user()->role_id != 1) abort(403);

        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'assigned_at' => 'required|date'
        ]);

        if ($inventory->status == 'assigned') {
            return back()->withErrors(['error' => 'Bu demirbaş zaten bir personele zimmetli.']);
        }

        InventoryAssignment::create([
            'inventory_id' => $inventory->id,
            'employee_id' => $request->employee_id,
            'assigned_at' => $request->assigned_at,
            'notes' => $request->notes
        ]);

        $inventory->update(['status' => 'assigned']);

        return back()->with('success', 'Demirbaş başarıyla zimmetlendi.');
    }

    public function returnItem(Request $request, Inventory $inventory)
    {
        if (auth()->user()->role_id != 1) abort(403);

        $assignment = $inventory->currentAssignment;

        if ($assignment) {
            $assignment->update([
                'returned_at' => now(),
                'notes' => $assignment->notes . "\nİade Notu: " . $request->notes
            ]);
        }

        $inventory->update([
            'status' => $request->status ?? 'available'
        ]);

        return back()->with('success', 'Zimmet iadesi alındı.');
    }
}
