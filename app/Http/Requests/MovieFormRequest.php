<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieFormRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'genre_code' => 'required|string|max:20',
            'year' => 'required|integer',
            'poster_filename' => 'nullable|image|mimes:jpg|max:4096',
            'synopsis' => 'required|string',
            'trailer_url' => 'nullable|string|max:255',
        ];

        return $rules;
    }

    /**
     * Get the custom error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'title.required' => 'O título é obrigatório.',
            'title.max' => 'O título não pode ter mais de 255 caracteres.',
            'year.required' => 'O ano é obrigatório.',
            'year.integer' => 'O ano deve ser um número inteiro.',
            'poster_filename.mimes' => 'O poster deve ser um arquivo do tipo jpg.',
            'poster_filename.max' => 'O poster não pode ser maior que 4MB.',
            'synopsis.required' => 'A sinopse é obrigatória.',
            'synopsis.string' => 'A sinopse deve ser um texto.',
            'trailer_url.max' => 'A URL do trailer não pode ter mais de 255 caracteres.',
        ];
    }
}
