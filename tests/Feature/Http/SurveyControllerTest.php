<?php

namespace Tests\Feature\Http;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Database\Seeders\SurveySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SurveyControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_a_survey(): void
    {
        $this->seed(SurveySeeder::class);

        $response = $this->get('/api/surveys/1');

        $response->assertStatus(200);
        $response->assertJsonPath('id', 1);
    }

    /** @test */
    public function it_cannot_fill_a_survey_with_incorrect_data(): void
    {
        $user = User::factory()->count(1)->create()[0];

        $this->seed(SurveySeeder::class);

        $response = $this->actingAs($user)->post('/api/surveys/1', [
            'answers' => []
        ], [
            'Content-Type' => 'application/json',
            'Accept'       => 'application/json'
        ]);

        $response->assertStatus(422);

        $response = $this->actingAs($user)->post('/api/surveys/1', [
            'answers' => [
                ['question_id' => 99999999]
            ]
        ], [
            'Content-Type' => 'application/json',
            'Accept'       => 'application/json'
        ]);

        $response->assertStatus(422);
    }

    /** @test */
    public function it_can_fill_a_survey(): void
    {
        $user = User::factory()->count(1)->create()[0];

        $this->seed(SurveySeeder::class);

        $survey = $this->get('/api/surveys/1')->json();

        $answers = array_map(function ($question) {
            $value = 'some text';

            if ($question['type'] === 'radio') {
                $value = $question['options'][0]['id'];
            }

            return [
                'question_id' => $question['id'],
                'value'       => $value
            ];
        }, $survey['questions']);

        $response = $this->actingAs($user)->json('POST', '/api/surveys/1', [
            'answers' => $answers
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
    }
}
