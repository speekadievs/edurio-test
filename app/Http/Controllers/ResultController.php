<?php

namespace App\Http\Controllers;

use App\Contracts\Services\ResultServiceInterface;
use Illuminate\Http\JsonResponse;

class ResultController extends Controller
{
    private ResultServiceInterface $service;

    /**
     * @param ResultServiceInterface $service
     */
    public function __construct(ResultServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function getStats(int $id): JsonResponse
    {
        $results = $this->service->getStats($id);

        return response()->json($results);
    }

    public function getAnswersByUser(int $id, int $userId): JsonResponse
    {
        $answers = $this->service->getAnswersByUser($id, $userId);

        return response()->json($answers);
    }
}
