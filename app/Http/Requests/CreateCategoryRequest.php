<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
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
            'name' => 'required|max:30|unique:product_category'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Een naam van de categorie is verplicht',
            'name.max' => 'Je hebt over het maximaal aantal karakters ingevoerd',
            'name.unique' => 'Deze categorie bestaat al'
        ];
    }
}
