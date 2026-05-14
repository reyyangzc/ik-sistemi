<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'serial_number',
        'type',
        'status',
        'notes'
    ];

    public function assignments()
    {
        return $this->hasMany(InventoryAssignment::class);
    }

    public function currentAssignment()
    {
        return $this->hasOne(InventoryAssignment::class)->whereNull('returned_at');
    }
}
