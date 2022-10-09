<?php

namespace App\Http\Controllers;

use App\Contracts\Services\SurveyServiceInterface;
use App\Http\Requests\FillSurveyRequest;
use Illuminate\Http\JsonResponse;

class SurveyController extends Controller
{
    private SurveyServiceInterface $service;

    /**
     * @param SurveyServiceInterface $service
     */
    public function __construct(SurveyServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function get(int $id): JsonResponse
    {
        return response()->json($this->service->getWithQuestions($id));
    }

    /**
     * @param FillSurveyRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function fill(FillSurveyRequest $request, int $id): JsonResponse
    {
        $survey = $this->service->getWithQuestions($id);

        $this->service->fill($request->user(), $survey, $request->get('answers'));

        return response()->json([
            'success' => true
        ]);
    }
}
