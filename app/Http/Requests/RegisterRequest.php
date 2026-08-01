<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:8192',
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
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'Esta contraseña es muy corta, debe tener por lo menos 6 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'bio.max' => 'La biografía no puede superar los 500 caracteres.',
        ];
    }
}
