<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'performance_id' => 'required|exists:performances,id',
            'ticket_amount' => 'required|min:1',
            'status' => 'required|string|max:255',
        ];
    }
    public function messages(): array
    {
        return [
            'performance_id.required' => 'Este campo no puede quedar vacío.',
            'performance_id.exists' => 'Debe seleccionarse una función existente.',
            'user_id.required' => 'Este campo no puede quedar vacío.',
            'user_id.exists' => 'Debe seleccionarse un usuario existente.',
            'ticket_amount.required' => 'Este campo no puede quedar vacío.',
            'ticket_amount.min' => 'Debe haber al menos 1 entrada por compra.',
            'status.required' => 'Debe seleccionar una de las opciones.',
        ];
    }
}
