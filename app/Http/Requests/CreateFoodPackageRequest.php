<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFoodPackageRequest extends FormRequest
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
            'notes' => 'string',
            'customer' => 'required',
            'products' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'notes.string' => 'Er is blijkbaar iets mis gegaan met uw notitie',
            'customer.required' => 'Een klant vermelden is verplicht',
            'products.required' => 'Een product toevoegen is verplicht'
        ];
    }
}
