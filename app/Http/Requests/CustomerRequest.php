<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
        $id = $this->id ?? 0;

        $rules = [
            'firstname'   => 'bail|required|max:50',
            // 'lastname'    => 'bail|required|max:50',
            'address'     => 'bail|required|max:100',
            'username'    => 'bail|required|min:4|unique:users,username,'.$id,
            'password'    => 'bail'.(!$id ? '|required':'').'|min:5',
            'email'       => 'bail|email|unique:users,email,'.$id,
            'phone'       => 'bail',
            'province'    => 'bail|string|max:2|min:2',
        ];

        if($this->email == '') {
            $rules['email'] = '';
        }

        return $rules;
       
    }


    public function messages()
    {
        return [];
    }
}
