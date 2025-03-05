<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenreFormRequest extends FormRequest
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
        ];
        if (strtolower($this->getMethod()) == 'post') {
            // This will merge 2 arrays:
            // (adds the "code" rule to the $rules array)
            $rules = array_merge($rules, [
                'code' => 'required|string|max:20|unique:genres,code',
            ]);
        }
        return $rules;
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Código é obrigatório',
            'code.string' => 'Código deve ser uma String',
            'code.max' => 'Código não deve conter mais de 20 caracteres',
            'code.unique' => 'Código deve ser único',
            'name.required' => 'Nome é obrigatório',
            'name.string' => 'Nome deve ser uma String',
            'name.max' => 'Nome não deve conter mais de 255 caracteres',
        ];
    }
}
