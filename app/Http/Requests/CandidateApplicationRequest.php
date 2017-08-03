<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CandidateApplicationRequest extends Request
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
            'reflection'                => 'max:7000|required_if:confirm,on',
            'additional_majors'         => 'max:255',
            'academic_honors'           => 'max:255',
            'service.*.name'            => 'max:255',
            'service.*.position_held'   => 'max:255',
            'service.*.description'     => 'max:1000',
            'service.*.involvement'     => 'numeric',
            'activity.*.name'           => 'max:255',
            'activity.*.position_held'  => 'max:255',
            'activity.*.description'    => 'max:1000',
            'activity.*.involvement'    => 'numeric',
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
            'service.*.name.max'                => 'Service name must be less than :max characters.',
            'service.*.position_held.max'       => 'Position held must be less than :max characters.',
            'service.*.description.max'         => 'Service description must be less than :max characters.',
            'service.*.involvement.numeric'     => 'Involvement length must be a number.',
            'activity.*.name.max'               => 'Activity name must be less than :max characters.',
            'activity.*.position_held.max'      => 'Position held must be less than :max characters.',
            'activity.*.description.max'        => 'Activity description must be less than :max characters.',
            'activity.*.involvement.numeric'    => 'Involvement length must be a number.',
        ];
    }
}
