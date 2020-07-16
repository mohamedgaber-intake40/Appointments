<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Enums\UserType;
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
    public function store(Request $request)
    {
        $request->user()->patientAppointments()->create(['pain_id' => $request->pain]);
        return redirect()->route('appointments.index')->with(['success'=> 'Appointment Created']);
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
    public function update(Request $request, Appointment $appointment)
    {
        //authorization
        if($request->refuse)
            return $this->refuse($request,$appointment);

        //authorization
        $appointment->update(['pain_id'=>$request->pain]);
        return redirect()->route('appointments.index')->with(['success'=>'Appointment updated']);
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
    public function destroy(Appointment $appointment)
    {
        // authorization
        $appointment->delete();
        return redirect()->route('appointments.index')->with(['success'=>'Appointment deleted']);

    }
}
