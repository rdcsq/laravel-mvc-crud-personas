<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RfcPersonaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'rfc' => ['required', 'regex:[A-Z]{4}[0-9]{6}[A-Z0-9]{3}', 'exists:personas,rfc']
        ];
    }
}
