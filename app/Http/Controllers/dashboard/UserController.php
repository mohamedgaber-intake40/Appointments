<?php

namespace App\Http\Controllers\dashboard;

use App\AdminProfile;
use App\DoctorProfile;
use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\PatientProfile;
use App\Specialty;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('dashboard.users.index',['users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $profile='';
        if($request->type == UserType::DOCTOR)
        {
            $profile = DoctorProfile::create();
        }
        else if($request->type == UserType::PATIENT)
        {
            $profile = PatientProfile::create();
        }
        else if($request->type == UserType::ADMIN)
        {
            $profile = AdminProfile::create();
        }
        User::create(
            $request->only(['user_name','password','type']) +
            ([
                'profileable_type'=>get_class($profile) ,
                'profileable_id' => $profile->id
            ])
        );

        return redirect()->route('dashboard.users.index')->with(['success'=>'User Created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user->load(['profileable']);
        return view('dashboard.users.show',['user'=>$user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $specialties=[];
        if($user->type == UserType::DOCTOR)
        {
            $specialties=Specialty::all();
        }
        $user->load(['profileable']);
        return view('dashboard.users.edit',['user'=>$user , 'specialties'=>$specialties]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        if($request->new_password)
            $user->update(['password'=>$request->new_password]);

        if($user->type ==  UserType::DOCTOR)
            $this->updateDoctor($request , $user);

        if($request->type != $user->type)
            $this->changeType($request , $user);

        else if($user->type ==  UserType::PATIENT)
            $this->updatePatient($request , $user);

        else if($user->type ==  UserType::ADMIN)
            $this->updateAdmin($request , $user);

        return redirect()->route('dashboard.users.index')->with(['success'=>'User Updated']);

    }

    /**
     * Update Doctor User Data
     *
     * @param \App\Http\Requests\UserRequest $request
     * @param \App\User $user ( type = Doctor )
     * @return void
     */
    private function updateDoctor($request , $user)
    {
        if($request->specialty != $user->profileable->specialty_id) //specialty changed
        {
            $this->modifyCurrentAppointments($user);
        }
        $user->update($request->only(['user_name']));
        $user->profileable->update($request->only(['firstname','lastname','specialty']));
    }

    /**
     * Update Patient User Data
     *
     * @param \App\Http\Requests\UserRequest $request
     * @param \App\User $user ( type = Patient )
     * @return void
     */
    private function updatePatient($request , $user)
    {
        $user->update($request->only(['user_name']));
        $user->profileable->update($request->only(['firstname','lastname','email', 'mobile','birthdate','gender','country','occupation',
        ]));
    }

    /**
     * Update Admin User Data
     *
     * @param \App\Http\Requests\UserRequest $request
     * @param \App\User $user ( type = Admin )
     * @return void
     */
    private function updateAdmin($request , $user)
    {
        $user->update($request->only(['user_name']));
        $user->profileable->update($request->only(['firstname','lastname']));
    }

    /**
     * Change User Type
     *
     * @param \App\Http\Requests\UserRequest $request
     * @param \App\User $user
     * @return void
     */
    private function changeType($request , $user)
    {
        $this->modifyCurrentAppointments($user);
        $user->profileable->delete();
        $profile='';
        if($request->type == UserType::DOCTOR)
        {
            $profile = DoctorProfile::create();
        }
        else if($request->type == UserType::PATIENT)
        {
            $profile = PatientProfile::create();
        }
        else if($request->type == UserType::ADMIN)
        {
            $profile = AdminProfile::create();
        }
        $user->update([
            'profileable_type'=>get_class($profile) ,
            'profileable_id' => $profile->id,
            'type'=>$request->type
        ]);
    }

    /**
     * Modify User Current Appointments
     *
     * @param \App\User $user
     * @return void
     */
    private function modifyCurrentAppointments($user)
    {
        if($user->type == UserType::PATIENT)
        {
            $user->patientAppointments->each(function($appointment){
                $appointment->delete();
            });
        }
        // change doctor appointments status to waiting
        if($user->type == UserType::DOCTOR)
        {
            $user->doctorAppointments->each(function($appointment){
                $appointment->update(['is_doctor_refuse'=>0 ,'is_patient_refuse'=>0 , 'date'=>null , 'doctor_id'=>null ]);
            });
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('dashboard.users.index')->with(['success'=>'User Deleted']);

    }
}
