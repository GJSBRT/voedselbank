<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'role_id' => 'required|int',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'De voornaam is een verplicht veld.',
            'first_name.string' => 'De voornaam mag maximaal 100 karakters zijn.',
            'first_name.max:100' => 'De voornaam mag maximaal 100 karakters zijn.',
            'last_name.required' => 'De achternaam is een verplicht veld.',
            'last_name.string' => 'De achternaam mag maximaal 100 karakters zijn.',
            'last_name.max:100' => 'De achternaam mag maximaal 100 karakters zijn.',
            'email.required' => 'De voornaam is een verplicht veld.',
            'email.email' => 'Vul een geldig e-mailadres in.',
            'email.max:100' => 'De email mag maximaal 100 karakters zijn.',
            'role_id.required' => 'Vul een rol in.',
            'role_id.int' => 'Er is iets mis gegaan met het selecteren van de rol.',
        ];
    }
}
