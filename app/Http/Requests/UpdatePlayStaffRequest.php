<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePlayStaffRequest extends FormRequest
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
            'staff_ids' => 'nullable|array',
            'new_staff_ids' => 'nullable|array',
            'staff_ids.*' => 'integer|exists:users,id',
            'staff_roles' => 'nullable|array',
            'staff_roles.*' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'staff_ids.*.exists' => 'El usuario seleccionado no existe.',
            'staff_roles.*.max' => 'El rol no puede superar los 255 caracteres.',
        ];
    }
}
