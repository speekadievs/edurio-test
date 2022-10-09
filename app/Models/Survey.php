<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Survey extends Model
{
    use HasFactory;

    public $guarded = [];

    public int $id;
    public Carbon $created_at;
    public Carbon $updated_at;

    public function questions(): HasMany
    {
        return $this->hasMany(SurveyQuestion::class);
    }
}
