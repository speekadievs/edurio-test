<?php

namespace Tests\Feature\Services;

use App\Models\Survey;
use App\Models\User;
use App\Services\ResultService;
use App\Services\SurveyService;
use Database\Seeders\SurveyAnswerSeeder;
use Database\Seeders\SurveySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class ResultServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_survey_results(): void
    {
        User::factory()->count(1)->create();

        $this->seed([
            SurveySeeder::class,
            SurveyAnswerSeeder::class
        ]);

        $surveyService = new SurveyService($this->app->make(Survey::class));
        $service = new ResultService($surveyService);

        $results = $service->getStats(1);

        $this->assertEquals(null, $results->where('type', 'text')->first()->average);
        $this->assertEquals(1, $results->where('type', 'text')->first()->count);

        $this->assertEquals(1, $results->where('type', 'radio')->first()->count);
        $this->assertGreaterThanOrEqual(0, $results->where('type', 'radio')->first()->average);
    }

    /** @test */
    public function it_returns_survey_answers_by_user(): void
    {
        User::factory()->count(1)->create();

        $this->seed([
            SurveySeeder::class,
            SurveyAnswerSeeder::class
        ]);

        $surveyService = new SurveyService($this->app->make(Survey::class));
        $service = new ResultService($surveyService);

        $results = $service->getAnswersByUser(1, 1);

        $this->assertGreaterThan(0, $results->where('type', 'text')->first()->value);
    }
}
