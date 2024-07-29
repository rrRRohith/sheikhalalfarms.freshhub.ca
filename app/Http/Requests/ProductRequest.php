<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $id = $this->product ?? null;
        

        return [
            'name'   => 'bail|required|max:50',
            'category_id'     => 'bail|required',
            'weight'    => 'bail|required',
            'price'    => 'bail|required',
            'unit'     => 'bail|required',
            'unittype' => 'bail|required',
            'sku'      => 'bail|required|unique:products,sku,'.$id
        ];
        
    }


    public function messages()
    {
        return [];
    }
}
