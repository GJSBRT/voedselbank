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
            'customer' => 'required',
            'products' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'customer.required' => 'Een klant vermelden is verplicht',
            'products.required' => 'Een product toevoegen is verplicht'
        ];
    }
}
