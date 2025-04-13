<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCalendarRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date'        => 'required|date_format:Y-m-d',
            'time'        => 'required|date_format:H:i',
            'identifier'  => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'El título es obligatorio.',
            'date.required'  => 'La fecha es obligatoria.',
            'time.required'  => 'La hora es obligatoria.',
            'identifier.required' => 'El paciente no existe.',
        ];
    }
}
