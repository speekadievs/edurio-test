<?php

namespace Database\Seeders;

use App\Models\Survey;
use App\Models\User;
use Faker\Provider\Lorem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SurveyAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = $this->getUsers();
        $survey = $this->getSurvey();

        Log::info('Will populate answers for ' . count($users) . ' users');

        $answers = $this->populate($users, $survey);

        $this->insert($answers);
    }

    private function populate($users, $survey)
    {
        $answers = [];

        foreach ($users as $user) {
            foreach ($survey->questions as $question) {
                $answer = [
                    'user_id'            => $user->id,
                    'survey_question_id' => $question->id,
                    'survey_option_id'   => null,
                    'value'              => null
                ];

                switch ($question->type) {
                    case 'text':
                        $answer['value'] = Lorem::sentence();
                        break;
                    case 'radio':
                        $option = $question->options->random();

                        $answer['survey_option_id'] = $option->id;
                        break;
                }

                $answers[] = $answer;
            }
        }

        return $answers;
    }

    private function insert($answers)
    {
        $chunks = array_chunk($answers, 10000);

        foreach ($chunks as $chunk) {
            DB::table('survey_answers')->insert($chunk);
        }
    }

    private function getSurvey()
    {
        return Survey::with('questions.options')->first();
    }

    private function getUsers()
    {
        return User::select('id')->get();
    }
}
