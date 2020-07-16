<?php

namespace App\Http\Requests;

use App\Enums\AppointmentStatus;
use App\Enums\UserType;
use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
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
        if($this->routeIs('appointments.store'))
        {
            return [
                'pain'=>'required|exists:pains,id'
            ];
        }
        else if($this->routeIs('appointments.update'))
        {
            if( $this->appointment->status == AppointmentStatus::WAITING )
            {
                return [
                    'pain'=>'required|exists:pains,id'
                ];
            }
            else if( $this->user()->type == UserType::PATIENT )
            {
                return [
                    'refuse'=>'required|in:1'
                ];
            }
            else if( $this->user()->type == UserType::DOCTOR )
            {
                return [
                    'refuse'=>'required|in:1'
                ];
            }
        }
        return [];

    }
}
