<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request
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
        return [
            'firstname'     => 'required|string|max:255',
            'lastname'      => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'username'      => 'required|max:255',
            //if email equals username@butler.edu, password is not required
            'password'      => 'min:12|confirmed|required_unless:email,'.request()->username.'@butler.edu',
            'roles'         => 'required'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'password.required_unless'      => 'You must provide a password for non-Butler users.',
        ];
    }

}
