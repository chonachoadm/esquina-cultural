<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePlayInfoRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'desc' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:8192',
            'theater' => 'required|integer|exists:theaters,id',
            'user_id' => 'required|integer|exists:users,id',
            'ticket_price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Este campo no puede quedar vacío.',
            'title.max' => 'El título no puede superar los 255 caracteres.',
            'desc.required' => 'Este campo no puede quedar vacío.',
            'image.image' => 'El archivo debe ser una imagen válida.',
            'image.mimes' => 'El archivo debe ser una imagen válida (jpeg, png, jpg, gif, webp).',
            'image.max' => 'El archivo no puede superar los 8 MB.',
            'theater.required' => 'Debes seleccionar un teatro.',
            'theater.exists' => 'El teatro seleccionado no existe.',
            'user_id.required' => 'Debes seleccionar un usuario creador.',
            'user_id.integer' => 'Este usuario no es válido.',
            'user_id.exists' => 'El usuario seleccionado no existe.',
            'ticket_price.required' => 'El precio es requerido.',
            'ticket_price.numeric' => 'El precio debe ser un número.',
            'ticket_price.min' => 'El precio no puede ser negativo.',
            'duration.required' => 'La duración es requerida.',
            'duration.integer' => 'La duración debe ser un número entero.',
            'duration.min' => 'La duración debe ser mayor a 0.',
        ];
    }
}
