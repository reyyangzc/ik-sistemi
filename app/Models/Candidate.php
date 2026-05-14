<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $fillable = [
        'job_posting_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'resume_path',
        'status',
        'notes'
    ];

    public function jobPosting()
    {
        return $this->belongsTo(JobPosting::class);
    }
}
