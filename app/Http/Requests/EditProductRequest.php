<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditProductRequest extends FormRequest
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
            'name' => 'required|max:191',
            'ean_number' => 'required|numeric|digits:13',
            'product_category_id' => 'required|numeric|max:20|min:1',
            'quantity' => 'required|numeric|min:1',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Voor dit veld is een naam verplicht!',
            'name.max' => 'Het maximaal aantal hoeveelheid characters dat ingevoerd kan worden is verschreden ( maximaal 191 letters lang )',

            'ean_number.required' => 'Voor dit veld is een ean nummer verplicht!',
            'ean_number.numeric' => 'Dit veld kan alleen nummers bevatten!',
            'ean_number.digits' => 'Dit veld moet 13 nummers lang zijn!',

            'product_category_id.required' => 'Voor dit veld is een product categorie verplicht!',
            'product_category_id.numeric' => 'Dit veld kan alleen nummers bevatten!',
            'product_category_id.max' => 'Het maximaal aantal hoeveelheid nummers dat ingevoerd kan worden is verschreden ( maximaal 20 nummers lang )',
            'product_category_id.min' => 'Het minimaal aantal hoeveelheid nummers dat ingevoerd kan worden is verschreden ( minmaal 1 nummer lang )',


            'quantity.required' => 'Voor dit veld is een hoeveelheid voorraad verplicht!',
            'quantity.numeric' => 'Dit veld kan alleen nummers bevatten!',
            'quantity.min' => 'Het minimaal aantal hoeveelheid nummers dat ingevoerd kan worden is verschreden ( minmaal 1 nummer lang )',

        ];
    }
}
