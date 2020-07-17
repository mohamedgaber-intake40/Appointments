<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Enums\AppointmentStatus;
use App\Enums\UserType;
use App\Http\Requests\AppointmentRequest;
use App\Notifications\AppointmentUpdatedNotification;
use App\Pain;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        if($user->type == UserType::PATIENT)
        $appointments = $request->user()->patientAppointments()->orderBy('updated_at','desc')
                        ->with(['doctor','doctor.profileable','pain'])->paginate(10);
        else
        $appointments = $request->user()->doctorAppointments()->orderBy('updated_at','desc')
                        ->with(['patient','patient.profileable','pain'])->paginate(10);

        return view('appointments.index' ,['appointments'=> $appointments]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pains = Pain::all();
        return view('appointments.create',['pains' => $pains]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AppointmentRequest $request)
    {
        $request->user()->patientAppointments()->create(['pain_id' => $request->pain]);
        return redirect()->route('appointments.index')->with(['success'=> 'Appointment Created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        $appointment->load(['doctor','doctor.profileable','patient','patient.profileable','pain']);
        return view('appointments.show',['appointment'=>$appointment]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
        $pains = Pain::all();
        return view('appointments.edit',['appointment'=>$appointment ,'pains' => $pains]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(AppointmentRequest $request, Appointment $appointment)
    {
        $user = $request->user();
        if($request->refuse)
            if(
                    (
                        $user->type == UserType::PATIENT &&
                        $appointment->patient->id == $user->id &&
                        $appointment->date &&
                        !$appointment->is_patient_refuse
                    ) ||
                    (
                        $user->type == UserType::DOCTOR &&
                        $appointment->doctor->id == $user->id &&
                        !$appointment->is_doctor_refuse
                    )
            )
                return $this->refuse($request,$appointment);
            else
                abort(403);

        if(
            $user->type == UserType::PATIENT &&
            $appointment->patient->id == $user->id &&
            $appointment->status == AppointmentStatus::WAITING
        )
        {

            $appointment->update(['pain_id'=>$request->pain]);
            return redirect()->route('appointments.index')->with(['success'=>'Appointment updated']);
        }
            abort(403);
    }

    private function refuse($request,$appointment)
    {
        if($request->user()->type == userType::PATIENT)
            $appointment->update(['is_patient_refuse'=>1]);
        else
            $appointment->update(['is_doctor_refuse'=>1]);

        return redirect()->route('appointments.index')->with(['updated'=>'Appointment refused']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request , Appointment $appointment)
    {
        $user=$request->user();
        if($user->type == UserType::PATIENT && $appointment->patient->id == $user->id )
        {
            $appointment->delete();
            return redirect()->route('appointments.index')->with(['success'=>'Appointment deleted']);
        }
        abort(403);
    }
}
