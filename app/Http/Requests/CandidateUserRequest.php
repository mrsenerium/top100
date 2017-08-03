<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CandidateUserRequest extends Request
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
            'email'         => 'required_without:id|email|max:50',
            'username'      => 'required_without:id|string|max:8',
            'college'       => 'required|string|max:255',
            'major'         => 'required|string|max:255',
            'class'         => 'required|integer|in:30,40',
            'total_hours'   => 'required|integer',
            'nominated'     => 'required|boolean',
            'disqualified'  => 'required|boolean',
            'submitted'     => 'boolean',
            'gender'        => 'required|alpha|in:M,F,U',
            'gpa'           => 'required|numeric|min:0|max:4.0'
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
            'email.required_without'    => 'The email field is required.',
            'username.required_without' => 'The username field is required.',
        ];
    }
}
