<?php

namespace App\Contracts\Services;

use Illuminate\Database\Eloquent\Collection;

interface ResultServiceInterface
{
    public function getStats(int $id): Collection;

    public function getAnswersByUser(int $id, int $userId): Collection;
}
