<?php

namespace Database\Seeders;

use App\Models\Survey;
use Faker\Provider\Lorem;
use Illuminate\Database\Seeder;

class SurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $survey = Survey::create();

        for ($i = 0; $i < 9; $i++) {
            $question = $survey->questions()->create([
                'type'  => 'radio',
                'value' => Lorem::sentence()
            ]);

            for ($j = 0; $j < 6; $j++) {
                $question->options()->create([
                    'label' => $j,
                    'value' => $j
                ]);
            }
        }

        $survey->questions()->create([
            'type'  => 'text',
            'value' => Lorem::sentence()
        ]);
    }
}
