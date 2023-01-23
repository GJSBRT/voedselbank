<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRoleRequest extends FormRequest
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
            'name' => 'required|string|max:100',
            'permissions' => 'required|array',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Een naam voor de rol is verplicht',
            'name.string' => 'De naam moet uit letters bestaan',
            'name.max' => 'U bent over het maximaal aantal tekens gegaan (100)',
            'permissions.required' => 'Permissies aangeven is verplicht',
            'permissions.array' => 'Oei, er is blijkbaar iets mis gegaan'
        ];
    }
}
