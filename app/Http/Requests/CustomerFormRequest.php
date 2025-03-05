<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerFormRequest extends FormRequest
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
            'blocked' => 'required|boolean',
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'blocked.required' => 'Campo bloqueado é obrigatório',
            'blocked.boolean' => 'Campo bloqueado deve ser verdadeiro ou falso',
        ];
    }
}
