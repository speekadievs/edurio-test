<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Survey extends Model
{
    use HasFactory;

    public $guarded = [];

    public $hidden = [
        'created_at',
        'updated_at'
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(SurveyQuestion::class);
    }

    public function answers(): HasManyThrough
    {
        return $this->hasManyThrough(SurveyAnswer::class, SurveyQuestion::class);
    }

    public function scopeWithQuestions(Builder $query)
    {
        $query->with('questions.options');
    }

    public function scopeWithAnswers(Builder $query)
    {
        $query->with('answers.option');
    }
}
