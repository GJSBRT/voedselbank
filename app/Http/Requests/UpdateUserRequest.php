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
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'user.first_name' => 'required|string|max:100',
            'user.last_name' => 'required|string|max:100',
            'user.email' => 'required|email|max:100',
            'user.password' => 'required|string|max:100',
            'user.role_id' => 'required|int',
        ];
    }

    public function messages()
    {
        return [
            'user.first_name.required' => 'De voornaam is een verplicht veld.',
            'user.first_name.string' => 'De voornaam mag maximaal 100 karakters zijn.',
            'user.first_name.max:100' => 'De voornaam mag maximaal 100 karakters zijn.',
            'user.last_name.required' => 'De achternaam is een verplicht veld.',
            'user.last_name.string' => 'De achternaam mag maximaal 100 karakters zijn.',
            'user.last_name.max:100' => 'De achternaam mag maximaal 100 karakters zijn.',
            'user.email.required' => 'De voornaam is een verplicht veld.',
            'user.email.email' => 'Vul een geldig e-mailadres in.',
            'user.email.max:100' => 'De email mag maximaal 100 karakters zijn.',
            'user.password.required' => 'Het wachtwoord is een verplicht veld.',
            'user.password.string' => 'Het wachtwoord mag maximaal 100 karakters zijn.',
            'user.password.max:100' => 'Het wachtwoord mag maximaal 100 karakters zijn.',
            'user.role_id.required' => 'Vul een rol in.',
            'user.role_id.int' => 'Er is iets mis gegaan met het selecteren van de rol.',
        ];
    }
}
