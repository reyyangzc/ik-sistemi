<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'type',
        'amount',
        'description',
        'receipt_path',
        'status',
        'admin_note'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
