<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['creator_id', 'assigned_to', 'title', 'description', 'status', 'due_date'];

    public function subTasks() { return $this->hasMany(SubTask::class); }
    public function comments() { return $this->hasMany(TaskComment::class); }
    public function creator() { return $this->belongsTo(User::class, 'creator_id'); }
    public function assignee() { return $this->belongsTo(User::class, 'assigned_to'); }
}