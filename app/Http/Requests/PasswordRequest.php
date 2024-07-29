<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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
            'oldpassword'   => 'bail|required',
            'password'    => 'bail|required|min:8|max:10|confirmed',
           // 'password_confirmation'     => 'bail|required',
           
        ];
        
    }


    public function messages()
    {
        return [];
    }
}
