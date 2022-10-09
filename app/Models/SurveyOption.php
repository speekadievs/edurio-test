<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyOption extends Model
{
    use HasFactory;

    public int $id;
    public int $survey_question_id;

    public string $label;
    public string $value;
}
