<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTheaterRequest extends FormRequest
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
            'user' => 'required|integer|exists:users,id',
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:500',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'capacity' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:8192',
        ];
    }
    public function messages(): array
    {
        return [
            'user.required' => 'Este campo no puede quedar vacío.',
            'user.exists' => 'Seleccioná un usuario registrado en nuestra plataforma.',
            'name.required' => 'Este campo no puede quedar vacío.',
            'name.max' => 'El nombre no puede superar los 255 caracteres.',
            'bio.max' => 'La biografía no puede superar los 500 caracteres.',
            'address.required' => 'Este campo no puede quedar vacío.',
            'capacity.required' => 'Este campo no puede quedar vacío.',
            'capacity.min' => 'La capacidad de la sala no puede ser menos que 1.',
            'image.image' => 'El archivo debe ser una imagen válida.',
            'image.mimes' => 'Los formatos de imagen aceptados son: .jpeg, .png, .jpg, .gif y .webp.',
        ];
    }
}
