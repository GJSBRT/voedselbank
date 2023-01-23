<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSupplierRequest extends FormRequest
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
            'company_name' => 'required',
            'address' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required|max:13',
            'contact_name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'company_name.required' => 'De bedrijfsnaam is een verplicht veld.',
            'address.required' => 'Het adres is een verplicht veld.',
            'email.required' => 'Het e-mailadres is een verplicht veld.',
            'email.email' => 'Vul een geldig e-mailadres in.',
            'phone_number.required' => 'Het telefoonnummer is een verplicht veld.',
            'phone_number.max' => 'Vul een geldig telefoonnummer in.',
            'contact_name.required' => 'Het contactpersoon is een verplicht veld.',
        ];
    }
}
