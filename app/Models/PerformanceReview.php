<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerformanceReview extends Model
{
    protected $fillable = ['employee_id', 'reviewer_id', 'score', 'comments', 'period'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
