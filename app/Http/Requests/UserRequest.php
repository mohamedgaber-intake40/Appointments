<?php

namespace App\Http\Requests;

use App\Enums\UserType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        if($this->routeIs('dashboard.users.update'))
        {
            if($this->type != $this->user->type) // type changed
            {
                return [
                    'type'=>'required|between:0,' . (count(UserType::$types)-1),
                ];
            }
            if($this->user->type == UserType::DOCTOR)
            {
                return[
                    'firstname'=>'required|string|max:50',
                    'lastname'=>'required|string|max:50',
                    'user_name' => ['required', 'string', 'max:255'],
                    'type'=>'required|between:0,' . (count(UserType::$types)-1),
                    'specialty'=>'required|exists:specialties,id',
			        'new_password' => 'string|nullable|min:8',

                ];
            }
            else if($this->user->type == UserType::PATIENT)
            {
                return [
                    'firstname'=>'required|string|max:50',
                    'lastname'=>'required|string|max:10',
                    'user_name' => ['required', 'string', 'max:255'],
                    'email'=>'required|email|max:50',
                    'mobile'=>'required|string|max:15|min:10',
                    'birthdate'=>'required|date|before:today',
                    'gender'=>'required|between:0,1',
                    'country'=>'required|string|max:50',
                    'occupation'=>'required|string|max:100',
                    'new_password' => 'string|nullable|min:8',
                    'type'=>'required|between:0,' . (count(UserType::$types)-1),
                ];
            }else if($this->user->type == UserType::ADMIN)
            {
                return[
                    'firstname'=>'required|string|max:50',
                    'lastname'=>'required|string|max:50',
                    'user_name' => ['required', 'string', 'max:255'],
                    'type'=>'required|between:0,' . (count(UserType::$types)-1),
			        'new_password' => 'string|nullable|min:8',
                ];
            }
        }
        else if($this->routeIs('dashboard.users.store'))
        {
            return [
                'user_name' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'type'=>'required|between:0,' . (count(UserType::$types)-1),

            ];
        }
        return [];


    }
}
