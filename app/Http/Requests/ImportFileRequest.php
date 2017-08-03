<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ImportFileRequest extends Request
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
            'import'            => 'required|mimes:csv,txt',
            'username_heading'  => 'required',
            'firstname_heading' => 'required',
            'lastname_heading'  => 'required',
            'email_heading'     => 'required',
            'gender_heading'    => 'required',
            'college_heading'   => 'required',
            'major_heading'     => 'required',
            'class_heading'     => 'required',
            'hours_heading'     => 'required',
            'gpa_heading'       => 'required'
        ];
    }
}
