<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
        $id = $this->profile ?? null;
        

        return [
            'billing_address'=>'bail|required',
            'shipping_address'=> 'bail|required',
            'order_date'=> 'bail|required',
            // 'due_date'=> 'bail|required',
            // 'shipping_id'=> 'bail|required',
            'shipping_date'=> 'bail|required',
            // 'tracking_code'=> 'bail|required',
           
            
        ];
       
    }


    public function messages()
    {
        return [];
    }
}
