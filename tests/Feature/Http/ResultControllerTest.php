<?php

namespace Tests\Feature\Http;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Database\Seeders\SurveyAnswerSeeder;
use Database\Seeders\SurveySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResultControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_survey_stats(): void
    {
        User::factory()->count(1)->create();

        $this->seed([
            SurveySeeder::class,
            SurveyAnswerSeeder::class
        ]);

        $response = $this->get('/api/surveys/1/stats');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id'    => 1,
            'type'  => 'radio',
            'count' => 1
        ]);
    }

    /** @test */
    public function it_returns_survey_answers(): void
    {
        User::factory()->count(1)->create();

        $this->seed([
            SurveySeeder::class,
            SurveyAnswerSeeder::class
        ]);

        $response = $this->get('/api/surveys/1/answers/1');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id'    => 1,
            'type'  => 'radio',
        ]);
    }
}
