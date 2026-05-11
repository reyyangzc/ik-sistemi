<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    // BURAYA EKLE (Sınıfın hemen girişi gibi düşün)
    protected $fillable = ['name'];

    // Eğer varsa senin ilişkin aşağıda kalmalı:
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}