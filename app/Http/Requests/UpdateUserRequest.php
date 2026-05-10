<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'image' => 'nullable|image|max:2048', // 2MB Max
                'bio' => 'nullable|string|max:500',
            ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Este campo no puede quedar vacío.',
            'name.max' => 'El nombre no puede superar los 255 caracteres.',
            'email.required' => 'Este campo no puede quedar vacío.',
            'email.unique' => 'Ya tenemos una cuenta registrada con este correo.',
            'image.max' => 'Esta imagen es muy pesada, el máximo son 2mb.',
            'bio.max' => 'La biografía no puede superar los 500 caracteres.',
        ];
    }
}
