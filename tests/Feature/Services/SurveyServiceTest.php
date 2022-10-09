<?php

namespace Tests\Feature\Services;

use App\Models\Survey;
use App\Models\User;
use App\Services\SurveyService;
use Database\Seeders\SurveySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class SurveyServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_that_it_returns_survey_with_questions()
    {
        $this->seed(SurveySeeder::class);

        $service = new SurveyService($this->app->make(Survey::class));

        $survey = $service->get(1);

        $this->assertEquals(1, $survey->id);
        $this->assertCount(10, $survey->questions);
    }

    public function test_that_survey_can_be_filled()
    {
        $user = User::factory()->count(1)->create()[0];

        $this->seed(SurveySeeder::class);

        $service = new SurveyService($this->app->make(Survey::class));

        $survey = $service->get(1);

        $answers = $survey->questions->map(function ($question) {
            $value = "some random text";

            if ($question->type === 'radio') {
                $value = $question->options->random()->id;
            }

            return [
                'question_id' => $question->id,
                'value'       => $value
            ];
        })->toArray();

        $service->fill($user, $survey, $answers);
    }
}
