<?php

namespace App\Services;

use App\Contracts\Services\SurveyServiceInterface;
use App\Models\Survey;
use App\Models\User;

class SurveyService implements SurveyServiceInterface
{
    private Survey $model;

    /**
     * @param Survey $model
     */
    public function __construct(Survey $model)
    {
        $this->model = $model;
    }

    /**
     * @param int $id
     * @return Survey
     */
    public function get(int $id): Survey
    {
        return $this->model->withQuestions()->findOrFail($id);
    }

    /**
     * @param User $user
     * @param Survey $survey
     * @param array $answers
     * @return void
     */
    public function fill(User $user, Survey $survey, array $answers): void
    {
        $answers = array_map(function ($answer) use ($user, $survey) {
            return $this->formatAnswer($user, $survey, $answer);
        }, $answers);

        $this->model->answers()->insert($answers);
    }

    /**
     * @param User $user
     * @param Survey $survey
     * @param array $answer
     * @return array
     */
    private function formatAnswer(User $user, Survey $survey, array $answer)
    {
        $question = $survey->questions->where('id', $answer['question_id'])->first();

        $item = [
            'user_id'            => $user->id,
            'survey_question_id' => $answer['question_id'],
            'survey_option_id'   => null,
            'value'              => null
        ];

        switch ($question->type) {
            case 'text':
                $item['value'] = $answer['value'];
                break;
            case 'radio':
                $item['survey_option_id'] = (int)$answer['value'];
                break;
        }

        return $item;
    }
}
