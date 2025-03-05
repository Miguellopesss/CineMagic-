<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TheaterFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Altere conforme a lógica de autorização do seu aplicativo
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome' => 'required|string|max:255',
            'num_rows' => 'required|integer|min:1', // pelo menos uma fila
            'num_seats_per_row' => 'required|integer|min:1', // pelo menos um assento por fila
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nome.required' => 'O nome do teatro é obrigatório.',
            'nome.string' => 'O nome do teatro deve ser uma string.',
            'nome.max' => 'O nome do teatro não deve exceder :max caracteres.',
            'num_rows.required' => 'O número de filas é obrigatório.',
            'num_rows.integer' => 'O número de filas deve ser um valor inteiro.',
            'num_rows.min' => 'O número de filas deve ser pelo menos :min.',
            'num_seats_per_row.required' => 'O número de lugares por fila é obrigatório.',
            'num_seats_per_row.integer' => 'O número de lugares por fila deve ser um valor inteiro.',
            'num_seats_per_row.min' => 'O número de lugares por fila deve ser pelo menos :min.',
        ];
    }
}
