<?php

namespace App\Http\Controllers\dashboard;

use App\Appointment;
use App\Enums\AppointmentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\DashBoardAppointmentRequest;
use App\Notifications\AppointmentUpdatedNotification;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appointments = Appointment::orderBy('updated_at','desc')
                        ->with(['doctor','doctor.profileable','pain'])->paginate(10);
        return view('dashboard.appointments.index',['appointments' => $appointments]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        $appointment->load(['doctor','doctor.profileable','pain']);
        return view('dashboard.appointments.show',['appointment'=>$appointment]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
        $doctorProfiles = $appointment->pain->specialty->doctorProfiles;
        $doctorProfiles->load(['user']);

        return view('dashboard.appointments.edit',
         [
            'appointment' => $appointment ,
            'doctorProfiles' => $doctorProfiles
         ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\DashBoardAppointmentRequest  $request
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(DashBoardAppointmentRequest $request, Appointment $appointment)
    {
        if( $appointment->status == AppointmentStatus::DOCTOR_REFUSE )
            return $this->reassignDoctor($request , $appointment);

        else if( $appointment->status == AppointmentStatus::PATIENT_REFUSE )
            return $this->reschedule($request , $appointment);

        $message = '';
        if($appointment->status == AppointmentStatus::BOTH_REFUSE )
        {
            $message = "The Appointment that was scheduled at {$appointment->date->toDayDateTimeString()} its Doctor has been reassigned  ";
            $message .="and has been rescheduled to {$appointment->date->toDayDateTimeString()}";
        }

        $appointment->update(
            $request->only( ['date','doctor_id'] ) +
            ( $appointment->status == AppointmentStatus::BOTH_REFUSE ? ['is_doctor_refuse' => 0 , 'is_patient_refuse' => 0 ] : [] )
        );
        //new appointment
        if(!$message)
        {
            $message = "The Appointment with Pain {$appointment->pain->title} has been scheduled at {$appointment->date->toDayDateTimeString()} ";
        }

        $appointment->patient->profileable->notify(new AppointmentUpdatedNotification($appointment , $message));
        $doctor_message =  "The Appointment with Pain {$appointment->pain->title} has been assigned to you at {$appointment->date->toDayDateTimeString()} ";

        $appointment->doctor->profileable->notify(new AppointmentUpdatedNotification($appointment , $doctor_message));

        return redirect()->route('dashboard.appointments.index')->with(['success'=>'Appointment updated']);

    }
    /**
     * Reassign Doctor to Appointment
     *
     * @param  \App\Http\Requests\DashBoardAppointmentRequest  $request
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    private function reassignDoctor($request , $appointment)
    {
        $appointment->update( $request->only(['doctor_id']) + ['is_doctor_refuse' => 0 ] );

        $message = "The Appointment that was scheduled at {$appointment->date->toDayDateTimeString()} its Doctor has been reassigned ";
        $appointment->patient->profileable->notify(new AppointmentUpdatedNotification($appointment , $message));

        return redirect()->route('dashboard.appointments.index')->with(['success'=>'Doctor reassigned']);

    }

     /**
     * Reschedule Doctor to Appointment
     *
     * @param  \App\Http\Requests\DashBoardAppointmentRequest  $request
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    private function reschedule($request , $appointment)
    {
        $old_date = $appointment->date->toDayDateTimeString();
        $appointment->update( $request->only(['date']) + ['is_patient_refuse' => 0 ]);

        $message = "The Appointment that was scheduled at {$old_date} has been  rescheduled to {$appointment->date->toDayDateTimeString()}";
        $appointment->patient->profileable->notify(new AppointmentUpdatedNotification($appointment , $message));
        $appointment->doctor->profileable->notify(new AppointmentUpdatedNotification($appointment , $message));

        return redirect()->route('dashboard.appointments.index')->with(['success'=>'Appointment rescheduled']);

    }


}
