<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{
    protected $fillable = [
        'survey_id',
        'employee_id',
        'survey_question_id',
        'answer_text'
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function question()
    {
        return $this->belongsTo(SurveyQuestion::class, 'survey_question_id');
    }
}
