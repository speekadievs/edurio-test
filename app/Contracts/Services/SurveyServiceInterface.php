<?php

namespace App\Contracts\Services;

use App\Models\Survey;
use App\Models\User;

interface SurveyServiceInterface
{
    public function get(int $id): Survey;

    public function getWithQuestions(int $id): Survey;

    public function fill(User $user, Survey $survey, array $answers);
}
