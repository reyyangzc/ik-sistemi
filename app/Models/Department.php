<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name'];

    // Bu satır çok önemli; Departman üzerinden ünvanlara ulaşmamızı sağlar
    public function positions()
    {
        return $this->hasMany(Position::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}