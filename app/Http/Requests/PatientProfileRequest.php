<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PatientProfileRequest extends FormRequest
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
            'firstname'=>'required|string|max:50',
            'lastname'=>'required|string|max:10',
            'email'=>'required|email|max:50',
            'mobile'=>'required|string|max:15|min:10',
            'birthdate'=>'required|date|before:today',
            'gender'=>'required|between:0,1',
            'country'=>'required|string|max:50',
            'occupation'=>'required|string|max:100',
			'password' => 'required_with:new_password|string|nullable|min:8',
			'new_password' => 'string|nullable|min:8',
        ];
    }
}
