<?php

namespace App\Services;

use App\Contracts\Services\ResultServiceInterface;
use App\Contracts\Services\SurveyServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ResultService implements ResultServiceInterface
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
     * @return Collection
     */
    public function getStats(int $id): Collection
    {
        $survey = $this->service->get($id);

        return $survey->questions()
            ->select([
                'survey_questions.id',
                'survey_questions.value as question',
                'survey_questions.type',
                DB::raw('AVG(survey_options."value") as average'),
                DB::raw('COUNT(survey_answers.id) as count'),
            ])
            ->leftJoin('survey_answers', 'survey_answers.survey_question_id', '=', 'survey_questions.id')
            ->leftJoin('survey_options', 'survey_options.id', '=', 'survey_answers.survey_option_id')
            ->groupBy('survey_questions.id')
            ->orderBy('survey_questions.id', 'ASC')
            ->get();
    }

    /**
     * @param int $id
     * @param int $userId
     * @return Collection
     */
    public function getAnswersByUser(int $id, int $userId): Collection
    {
        $survey = $this->service->get($id);

        return $survey->questions()
            ->select([
                'survey_questions.id',
                'survey_questions.value as question',
                'survey_questions.type',
                DB::raw('CASE WHEN survey_answers.survey_option_id IS NULL THEN survey_answers. "value" ELSE survey_options. "value" END AS "value"')
            ])
            ->leftJoin('survey_answers', 'survey_answers.survey_question_id', '=', 'survey_questions.id')
            ->leftJoin('survey_options', 'survey_options.id', '=', 'survey_answers.survey_option_id')
            ->where('survey_answers.user_id', $userId)
            ->get();
    }
}
