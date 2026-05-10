<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 
        'last_name', 
        'email', 
        'phone', 
        'hire_date', 
        'base_salary', 
        'department_id', 
        'position_id'
    ];
    // Personelin eğitim bilgileri
public function education() {
    return $this->hasMany(Education::class);
}

// Personelin belgeleri
public function documents() {
    return $this->hasMany(Document::class);
}

// Personelin maaş geçmişi
public function salaries() {
    return $this->hasMany(Salary::class);
}
}