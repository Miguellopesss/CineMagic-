<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminFormRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->admin?->id)
            ],
            'photo_filename' => 'sometimes|image|max:4096',
            'blocked' => 'required|boolean',
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nome é obrigatório',
            'name.string' => 'Nome deve ser uma string',
            'name.max' => 'Nome não deve conter mais de 255 caracteres',
            'email.required' => 'E-mail é obrigatório',
            'email.string' => 'E-mail deve ser uma string',
            'email.email' => 'E-mail deve ser um endereço de e-mail válido',
            'email.max' => 'E-mail não deve conter mais de 255 caracteres',
            'password.required' => 'Senha é obrigatória',
            'password.string' => 'Senha deve ser uma string',
            'password.min' => 'Senha deve ter pelo menos 8 caracteres',
            'password.confirmed' => 'Confirmação de senha não corresponde',
            'blocked.required' => 'Campo bloqueado é obrigatório',
            'blocked.boolean' => 'Campo bloqueado deve ser verdadeiro ou falso',
        ];
    }
}
