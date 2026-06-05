<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
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
                'body' => 'required|string|max:500',
            ];
    }
    public function messages(): array
    {
        return [
            'body.required' => 'Este campo no puede quedar vacío.',
            'body.max' => 'El comentario no puede superar los 500 caracteres.',        
            ];
    }
}
