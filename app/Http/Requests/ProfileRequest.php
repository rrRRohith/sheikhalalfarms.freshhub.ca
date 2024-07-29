<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'firstname'   => 'bail|required|max:50',
            'lastname'    => 'bail|required|max:50',
            'address'     => 'bail|required|max:100',
            // 'username'    => 'bail|required|max:10|min:8|unique:users',
            // 'password'    => 'bail|required|max:10|min:8',
           // 'email'       => 'bail|required|email|unique:users',
            'phone'       => 'bail',
            //'country'     => 'bail|required|string|max:2|min:2',
            'province'     => 'bail|string|max:2|min:2',
        ];
        // }
        // else
        // {
        //   return [
        //     'firstname'   => 'bail|required|max:50',
        //     'lastname'    => 'bail|required|max:50',
        //     'address'     => 'bail|required|max:100',
        //     //'username'    => 'bail|required_without:page_type|unique:users,username,'.$id,
        //     //'password'    => 'bail|max:10|min:8|nullable',
        //     //'email'       => 'bail|unique:users,email,'.$id,
        //     'phone'       => 'bail|numeric',
        //     'country'     => 'bail|required|string|max:2|min:2',
        //     'province'    => 'bail|string|max:2|min:2',
        // ]; 
        // }
    }


    public function messages()
    {
        return [];
    }
}
