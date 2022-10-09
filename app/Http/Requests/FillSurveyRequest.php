<?php

namespace App\Http\Requests;

use App\Models\SurveyQuestion;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FillSurveyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'answers.*.question_id' => [
                'required',
                Rule::exists(SurveyQuestion::class, 'id')
            ],

            'answers.*.value' => [
                'required'
            ]
        ];
    }
}
