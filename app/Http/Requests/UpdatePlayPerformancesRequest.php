<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePlayPerformancesRequest extends FormRequest
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
            'new_performances' => 'nullable|array',
            'new_performances.*' => 'required|date_format:Y-m-d H:i:s',
        ];
    }

    public function messages(): array
    {
        return [
            'new_performances.*.required' => 'Cada función es requerida.',
            'new_performances.*.date_format' => 'El formato de la función debe ser válido (YYYY-MM-DD HH:mm:ss).',
        ];
    }
}
