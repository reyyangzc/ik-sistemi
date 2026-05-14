<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_id',
        'employee_id',
        'assigned_at',
        'returned_at',
        'notes'
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
