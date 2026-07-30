<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePurchaseRequest extends FormRequest
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
            'performance_id' => 'required|exists:performances,id',
            'user_id' => 'exists:users,id',
            'name' => 'string|max:255',
            'email' => 'email|max:255',
            'ticket_amount' => 'required|min:1',
            'status' => 'required|string|max:255',
            'play_id' => 'required|exists:plays,id',
        ];
    }
    public function messages(): array
    {
        return [
            'performance_id.required' => 'Este campo no puede quedar vacío.',
            'performance_id.exists' => 'Debe seleccionarse una función existente.',
            'user_id.exists' => 'Debe seleccionarse un usuario existente.',
            'ticket_amount.required' => 'Este campo no puede quedar vacío.',
            'ticket_amount.min' => 'Debe haber al menos 1 entrada por compra.',
            'status.required' => 'Debe seleccionar una de las opciones.',
            'play_id.required' => 'Debe seleccionar una de las opciones.',
            'play_id.exists' => 'Debe seleccionar una obra que se encuentre en nuestra plataforma.',
        ];
    }
}
