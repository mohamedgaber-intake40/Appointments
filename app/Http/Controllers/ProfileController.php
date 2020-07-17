<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $profile = $request->user()->profileable;
        return view('profiles.show',['profile'=>$profile]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $profile = $request->user()->profileable;
        return view('profiles.edit',['profile' => $profile]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PatientProfileRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(PatientProfileRequest $request)
    {
        if($request->new_password)
        {
            $this->changePassword($request);
        }
        $profile = $request->user()
        ->profileable
        ->update($request->only(
            [   'firstname',
                'lastname',
                'email',
                'mobile',
                'birthdate',
                'gender',
                'country',
                'occupation'
            ]
        ));
        return redirect()->route('profiles.show',['profile',$profile])->with(['success','Profile Updated']);;
    }
    /**
     * Change User Password
     *
     * @param \App\Http\Requests\PatientProfileRequest $request
     * @return void
     */
    private function changePassword($request)
    {
        $user = $request->user();
        if(Hash::check($request->password ,$user->password))
        {
           $user->update(['password'=>$request->new_password]);
        }
        else
        {
            return redirect()->route('profiles.edit',['profile' =>$user->profileable])
                    ->withErrors(['password'=>'Wrong password']);
        }
    }


}
