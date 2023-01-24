<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDeliveryRequest extends FormRequest
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
            'supplier_id' => 'required',
            'expected_at' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'supplier_id.required' => 'Dit is een verplicht veld.',
            'expected_at.required' => 'Het is verplicht om een verwachte bezorgdatum in te voeren.',
        ];
    }
}
