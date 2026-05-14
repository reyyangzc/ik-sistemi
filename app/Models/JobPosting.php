<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPosting extends Model
{
    protected $fillable = [
        'title',
        'department_id',
        'description',
        'status'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }
}
