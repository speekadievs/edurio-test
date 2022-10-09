<?php

namespace Tests\Feature\Services;

use App\Exceptions\NoAnswersException;
use App\Models\Survey;
use App\Models\User;
use App\Services\SurveyService;
use Database\Seeders\SurveySeeder;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class SurveyServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_survey_with_questions(): void
    {
        $this->seed(SurveySeeder::class);

        $service = new SurveyService($this->app->make(Survey::class));

        $survey = $service->getWithQuestions(1);

        $this->assertEquals(1, $survey->id);
        $this->assertCount(10, $survey->questions);
    }

    /** @test */
    public function survey_can_be_filled(): void
    {
        $user = User::factory()->count(1)->create()[0];

        $this->seed(SurveySeeder::class);

        $service = new SurveyService($this->app->make(Survey::class));

        $survey = $service->getWithQuestions(1);

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

        try {
            $service->fill($user, $survey, $answers);

            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e);
        }
    }

    /** @test */
    public function it_fails_to_fill_empty_survey(): void
    {
        $user = User::factory()->count(1)->create()[0];

        $this->seed(SurveySeeder::class);

        $service = new SurveyService($this->app->make(Survey::class));

        $survey = $service->getWithQuestions(1);

        try {
            $service->fill($user, $survey, []);
        } catch (Exception $e) {
            $this->assertInstanceOf(NoAnswersException::class, $e);
        }
    }
}
