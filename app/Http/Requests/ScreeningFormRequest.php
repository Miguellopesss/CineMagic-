<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScreeningFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'movie_id' => 'required|exists:movies,id',
            'theater_id' => 'required|exists:theaters,id',
            'date' => 'required|date_format:Y-m-d',
            'start_time' => 'required|date_format:H:i:s',
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'movie_id.required' => 'O filme é obrigatório',
            'movie_id.exists' => 'O filme deve existir na base de dados',
            'theater_id.required' => 'O teatro é obrigatório',
            'theater_id.exists' => 'O teatro deve existir na base de dados',
            'date.required' => 'A data é obrigatória',
            'date.date_format' => 'A data deve estar no formato Y-M-D',
            'start_time.required' => 'A hora de início é obrigatória',
            'start_time.date_format' => 'A hora de início deve estar no formato HH:mm:ss',
        ];
    }
}
