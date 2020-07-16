<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientProfileRequest;
use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Profile  $profile
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
     * @param  \App\Profile  $profile
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(PatientProfileRequest $request)
    {
        if($request->new_password)
        {
            return $this->changePassword($request);
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

    private function changePassword($request)
    {
        if(Hash::check($request->password , $request->user()->password))
        {
            $request->user()->update(['password'=>$request->new_password]);
            return redirect()->route('profiles.show',['profile',$request->user()->profileable])
                   ->with(['success','Password Changed']);
        }
        else
        {
            return redirect()->route('profiles.edit',['profile' => $request->user()->profileable])
                    ->withErrors(['password'=>'Wrong password']);
        }
    }


}
