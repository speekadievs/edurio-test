<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SurveyAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'survey_question_id',
        'survey_option_id',
        'value'
    ];

    public $hidden = [
        'user_id',
        'survey_question_id',
        'survey_option_id',
        'created_at',
        'updated_at'
    ];

    public function option(): BelongsTo
    {
        return $this->belongsTo(SurveyOption::class);
    }
}
