<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePlayRequest extends FormRequest
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
            'staff_ids' => 'nullable|array',
            'staff_ids.*' => 'integer|exists:users,id',
            'staff_roles' => 'nullable|array',
            'staff_roles.*' => 'nullable|string|max:255',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'day_times' => 'required|array|min:1',
            'day_times.*' => 'required|date_format:H:i',
        ];
    }
    public function messages(): array
    {
        return [
            'title.required' => 'Este campo no puede quedar vacío.',
            'title.max' => 'El título no puede superar los 255 caracteres.',

            'desc.required' => 'Este campo no puede quedar vacío.',

            'image.image' => 'El archivo debe ser una imagen válida.',
            'image.mimes' => 'Los formatos de imagen aceptados son: jpeg, png, jpg, gif y webp.',
            'image.max' => 'Esta imagen es muy pesada, el máximo son 2mb.',

            'theater.required' => 'Debe seleccionar un teatro.',
            'theater.integer' => 'Este teatro no es válido.',
            'theater.exists' => 'Este teatro no está registrado en nuestra plataforma.',

            'user_id.required' => 'Debe seleccionar un usuario creador.',
            'user_id.integer' => 'Este usuario no es válido.',
            'user_id.exists' => 'Este usuario no está registrado en nuestra plataforma.',

            'ticket_price.required' => 'El precio de la entrada es obligatorio.',
            'ticket_price.numeric' => 'El precio debe ser un número válido.',
            'ticket_price.min' => 'El precio no puede ser negativo.',

            'duration.min' => 'La duración debe ser al menos 1 minuto.',

            'staff_ids.array' => 'Los integrantes del elenco deben ser seleccionados correctamente.',
            'staff_ids.*.integer' => 'Uno de los integrantes seleccionados no es válido.',
            'staff_ids.*.exists' => 'Uno de los integrantes seleccionados no existe en el sistema.',

            'staff_roles.array' => 'Los roles deben estar en formato correcto.',
            'staff_roles.*.string' => 'Cada rol debe ser un texto válido.',
            'staff_roles.*.max' => 'El rol no puede exceder 255 caracteres.',


            'start_date.required' => 'Es necesario seleccionar la fecha de la primera función.',
            'start_date.after_or_equal' => 'La fecha no puede ser previa a hoy.',

            'end_date.required' => 'Es necesario seleccionar la fecha de la última función.',
            'end_date.after' => 'La última función debe ser posterior a la primera función.',

            'day_times.required' => 'Debes seleccionar al menos un día de función.',
            'day_times.*.date_format' => 'El formato de hora no es válido.',
        ];
    }
}
