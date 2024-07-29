<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventoryRequest extends FormRequest
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
        $id = $this->inventory ?? null;
        

        return [
            'product_id'   => 'bail|required',
            'warehouse_id'=>'bail|required',
            'stock_qty'=>'bail|required'
            
        ];
        
        
    }


    public function messages()
    {
        return [];
    }
}
