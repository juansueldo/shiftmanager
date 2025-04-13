<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StorePatientRequest extends FormRequest
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
        $id = $this->input('id');
        return [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:patients,email,NULL,id',
            'phone' => 'nullable|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'identifier'    => [
                'required',
                'string',
                'max:50',
                Rule::unique('patients', 'identifier')->ignore($id)
            ],
        ];
    }

    public function messages(){
        return [
            'firstname.required' => 'The firtname is required.',
            'lastname.required' => 'The lastname is required.',
            'email.email' => 'The email is invalid.',
            'email.unique' => 'Email is already in use.',
            'identifier.required' => 'The identifier is required.',
            'identifier.unique' => 'Identifier is already in use.',
            // Agrega más mensajes personalizados según sea necesario
        ];
    }
}
