<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    // BURAYA EKLE
protected $guarded = [];
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}