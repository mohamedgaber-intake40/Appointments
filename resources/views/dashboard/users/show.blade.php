@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">User #{{ $user->id }}</div>

                    <div class="card-body">
                            <div class="form-group row">
                                <h5 for="firstname" class="col-md-4 col-form-label text-md-right">First Name</h5>

                                <div class="col-md-6">
                                    <h5>{{ $user->profileable->firstname }}</h5>
                                </div>
                            </div>

                            <div class="form-group row">
                                <h5 for="lastname" class="col-md-4 col-form-label text-md-right">Last Name</h5>

                                <div class="col-md-6">
                                    <h5>{{ $user->profileable->lastname }}</h5>
                                </div>
                            </div>
                            @if($user->type == UserType::PATIENT )
                                <div class="form-group row">
                                    <h5 for="email" class="col-md-4 col-form-label text-md-right">Email</h5>

                                    <div class="col-md-6">
                                        <h5>{{ $user->profileable->email }}</h5>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <h5 for="mobile" class="col-md-4 col-form-label text-md-right">Mobile</h5>

                                    <div class="col-md-6">
                                        <h5>{{ $user->profileable->mobile }}</h5>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <h5 class="col-md-4 col-form-label text-md-right">Birthdate</h5>

                                    <div class="col-md-6">
                                        <h5>{{ $user->profileable->birthdate }}</h5>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <h5 class="col-md-4 col-form-label text-md-right">Gender</h5>

                                    <div class="col-md-6">
                                        <h5>{{ UserGender::$genders[ $user->profileable->gender ] }}</h5>
                                    </div>
                                </div>



                                <div class="form-group row">
                                    <h5 class="col-md-4 col-form-label text-md-right">Country</h5>

                                    <div class="col-md-6">
                                        <h5>{{ $user->profileable->country }}</h5>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <h5 class="col-md-4 col-form-label text-md-right">Occupation</h5>

                                    <div class="col-md-6">
                                        <h5>{{ $user->profileable->occupation }}</h5>
                                    </div>
                                </div>
                            @endif

                            @if($user->type == UserType::DOCTOR )
                                <div class="form-group row">
                                    <h5 class="col-md-4 col-form-label text-md-right">Specialty</h5>

                                    <div class="col-md-6">
                                        <h5>{{ $user->profileable->specialty->title }}</h5>
                                    </div>
                                </div>
                            @endif

                            <div class="form-group row">
                                <h5 class="col-md-4 col-form-label text-md-right">Type</h5>

                                <div class="col-md-6">
                                    <h5>{{ UserType::$types[$user->type]}}</h5>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <a href="{{ route('dashboard.users.edit', ['user'=>$user])  }}" class="btn btn-primary">
                                        Edit
                                    </a>
                                </div>
                            </div>

                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection

