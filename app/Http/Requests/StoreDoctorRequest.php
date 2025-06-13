<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDoctorRequest extends FormRequest
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
    $doctorId = $this->route('id') ?? $this->input('id');
    $isUpdate = !empty($doctorId);

    $rules = [
        'phone' => 'nullable|string|max:20',
        'address' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'state' => 'required|string|max:255',
        'zip' => 'required|string|max:20',
        'country' => 'required|string|max:255',
        'date_of_birth' => 'required|date',
        'identifier' => [
            'required',
            'string',
            'max:50',
            Rule::unique('doctors', 'identifier')->ignore($doctorId)
        ],
        'specialties' => 'nullable|array',
        'specialties.*' => 'exists:specialties,id'
    ];

    // Add user validation rules for new doctors
    if (!$isUpdate) {
        $rules['firstname'] = 'required|string|max:255';
        $rules['lastname'] = 'required|string|max:255';
        $rules['email'] = 'nullable|email|unique:users,email';
    }

    return $rules;
}
    
}
