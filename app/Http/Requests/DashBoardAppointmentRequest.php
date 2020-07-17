<?php

namespace App\Http\Requests;

use App\Appointment;
use App\Enums\AppointmentStatus;
use App\Enums\UserType;
use Illuminate\Foundation\Http\FormRequest;

class DashBoardAppointmentRequest extends FormRequest
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
        if($this->routeIs('dashboard.appointments.update'))
        {
            if($this->appointment->status == AppointmentStatus::DOCTOR_REFUSE)
            {
                return [
                    'doctor_id'=>'required|exists:users,id',

                ];

            }else if($this->appointment->status == AppointmentStatus::PATIENT_REFUSE)
            {
                return [
                    'date'=>'date|after:now'
                ];
            }
            else
            {
                return [
                    'doctor_id'=>'required|exists:users,id',
                    'date'=>'date|after:now'
                ];
            }
        }
        else if($this->routeIs('appointments.update'))
        {
            if($this->appointment->status == AppointmentStatus::WAITING)
            {
                return [
                    'pain_id'=>'required|exists:pains'
                ];
            }
            if($this->user()->type == UserType::PATIENT)
            {
                return [
                    'is_patient_refuse'=>'required|in:1'
                ];
            }
            else
            {
                return [
                    'is_doctor_refuse'=>'required|in:1'
                ];
            }

        }
        return [];

    }

}
