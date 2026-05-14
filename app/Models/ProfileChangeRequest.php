<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProfileChangeRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'requested_data',
        'status', // pending, approved, rejected
        'admin_note'
    ];

    protected $casts = [
        'requested_data' => 'array'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
