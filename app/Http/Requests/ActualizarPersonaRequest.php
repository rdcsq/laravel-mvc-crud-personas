<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActualizarPersonaRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'rfc' => ['required', 'regex:(^([A-Z]{4}[0-9]{6}[A-Z0-9]{3})$)', 'exists:personas,rfc'],
            'nombre' => ['required', 'string', 'max:255', 'min:2'],
            'calle' => ['required', 'string', 'max:255', 'min:2'],
            'numero' => ['required', 'integer', 'min:1'],
            'colonia' => ['required', 'string', 'max:255', 'min:2'],
            'cp' => ['required', 'integer', 'min:1', 'max:99999']
        ];
    }
}
