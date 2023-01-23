<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterCustomerRequest extends FormRequest
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
            'first_name' => 'required|max:30',
            'last_name' => 'required|max:30',
            'email' => 'required|max:40|unique:customer',
            'phone_number' => 'required|max:18|',
            'address' => 'required|max:70',
            'adult_amount' => 'required|numeric|min:1|max:30',
            'child_amount' => 'required|numeric|max:30',
            'baby_amount' => 'required|numeric|max:30',
            'notes' => 'max:500'

        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Voornaam verplicht',
            'first_name.max' => 'Voornaam mag maximaal 30 tekens lang zijn',
            'last_name.required' => 'Achternaam verplicht',
            'last_name.max' => 'Achternaam mag maximaal 30 tekens lang zijn',
            'email.required' => 'Email is verplicht',
            'email.max' => 'Email mag maximaal 40 tekens lang zijn',
            'email.unique' => 'Email moet unique zijn',
            'phone_number.required' => 'Telefoonnummer is verplicht',
            'phone_number.max' => 'Voer een geldig telefoonnummer in',
            'address.required' => 'Adres verplicht',
            'address.max' => 'Voer een geldig adres in',
            'adult_amount.required' => 'Voer het aantal volwassenen in',
            'adult_amount.min' => 'Voer het aantal volwassenen in',
            'adult_amount.max' => 'Maximaal aantal bereikt (30)',
            'child_amount.max' => 'Maximaal aantal bereikt (30)',
            'child_amount.required' => 'Voer het aantal kinderen in',
            'baby_amount.max' => 'Maximaal aantal bereikt (30)',
            'baby_amount.required' => 'Voer het aantal babies in',
            'notes.max' => 'Maximaal aantal tekens bereikt in de notities',


        ];
    }
}
