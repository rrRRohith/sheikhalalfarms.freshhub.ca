<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MailRequest extends FormRequest
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
        $id = $this->password ?? null;
        

        return [
            'recipient_id'   => 'bail|required',
            'message'    => 'bail|required',
          
           
        ];
        
    }


    public function messages()
    {
        return [];
    }
}
