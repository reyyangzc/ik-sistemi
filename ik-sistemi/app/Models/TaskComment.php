<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskComment extends Model
{
    protected $fillable = ['task_id', 'user_id', 'comment'];

    // Bu yorum TEK BİR göreve aittir
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    // Bu yorumu yazan TEK BİR kullanıcı vardır
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}