<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'password' => 'required|string|max:100',
            'role_id' => 'required|int',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Een voornaam is verplicht',
            'first_name.string' => 'Er is iets fout gegaan, probeer a.u.b. opnieuw',
            'first_name.max' => 'Het maximaal aantal tekens is bereikt (100)',
            'last_name.required' => 'Een achternaam is verplicht',
            'last_name.sting' => 'Er is iets fout gegaan, probeer a.u.b. opnieuw',
            'last_name.max' => 'Het maximaal aantal tekens is bereikt (100)',
            'email.required' => 'Een email is verplicht',
            'email.email' => 'Voer een geldige email in',
            'email.max' => 'Het maximaal aantal tekens is bereikt (100)',
            'password.required' => 'Een wachtwoord is verplicht',
            'password.string' => 'Er is iets fout gegaan, probeer a.u.b. opnieuw',
            'role_id.required' => 'Een aangegeven rol is verplicht',
            'role_id.int' => 'Er is iets fout gegaan, probeer a.u.b. opnieuw',
        ];
    }
}
