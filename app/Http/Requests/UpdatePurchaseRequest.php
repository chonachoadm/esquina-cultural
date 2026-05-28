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
                'performance' => 'required|exists:performances,id',
                'user' => 'required|exists:users,id',
                'ticket_amount' => 'required|min:1',
                'payment_status' => 'required|string|max:255',
                'play' => 'required|exists:plays,id',
            ];
    }
    public function messages(): array
    {
        return [
            'performance.required' => 'Este campo no puede quedar vacío.',
            'performance.exists' => 'Debe seleccionarse una función existente.',
            'user.required' => 'Este campo no puede quedar vacío.',
            'user.exists' => 'Debe seleccionarse un usuario existente.',
            'ticket_amount.required' => 'Este campo no puede quedar vacío.',
            'ticket_amount.min' => 'Debe haber al menos 1 entrada por compra.',
            'payment_status.required' => 'Debe seleccionar una de las opciones.',
            'play.required' => 'Debe seleccionar una de las opciones.',
            'play.exists' => 'Debe seleccionar una obra que se encuentre en nuestra plataforma.',
        ];
    }
}
