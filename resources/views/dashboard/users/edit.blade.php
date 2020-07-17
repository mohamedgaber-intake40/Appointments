@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">User #{{ $user->id }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('dashboard.users.update',['user'=>$user]) }}">
                            @csrf
                            @method('put')

                            <div class="form-group row">
                                <label for="user_name" class="col-md-4 col-form-label text-md-right">User Name</label>

                                <div class="col-md-6">
                                    <input id="user_name" type="text" class="form-control @error('user_name') is-invalid @enderror" name="user_name" value="{{ old('user_name') ?old('user_name')  : $user->user_name  }}"  autocomplete="user_name" autofocus>

                                    @error('user_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="firstname" class="col-md-4 col-form-label text-md-right">First Name</label>

                                <div class="col-md-6">
                                    <input id="first_name" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') ?old('firstname')  : $user->profileable->firstname  }}"  autocomplete="firstname" autofocus>

                                    @error('firstname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="lastname" class="col-md-4 col-form-label text-md-right">Last Name</label>

                                <div class="col-md-6">
                                    <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" value="{{ old('lastname') ?  old('lastname') : $user->profileable->lastname }}"name="lastname"  autocomplete="current-lastname">

                                    @error('lastname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            @if($user->type == UserType::PATIENT)
                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ? old('email') :  $user->profileable->email  }}"  autocomplete="current-email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="mobile" class="col-md-4 col-form-label text-md-right">Mobile</label>

                                    <div class="col-md-6">
                                        <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') ? old('mobile') : $user->profileable->mobile  }}"  autocomplete="current-mobile">

                                        @error('mobile')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="birthdate" class="col-md-4 col-form-label text-md-right">Birthdate</label>
                                    <div class="col-md-6">
                                        <input id="birthdate" type="date" class="form-control @error('birthdate') is-invalid @enderror" name="birthdate" value="{{ old('birthdate') ? old('birthdate') : $user->profileable->birthdate  }}"  autocomplete="current-birthdate">

                                        @error('birthdate')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="gender" class="col-md-4 col-form-label text-md-right">Gender</label>

                                    <div class="col-md-6">
                                        <select name="gender" id="gender" class="form-control">
                                            @foreach ( UserGender::$genders as $key => $value )
                                                <option value="{{ $key }}" {{ $user->profileable->gender == $key ?: 'selected' }}> {{ $value }} </option>
                                            @endforeach
                                        </select>

                                        @error('gender')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>



                                <div class="form-group row">
                                    <label for="country" class="col-md-4 col-form-label text-md-right">Country</label>

                                    <div class="col-md-6">
                                        <input id="country" type="text" class="form-control @error('country') is-invalid @enderror" name="country" value="{{ old('country') ? old('country')  :  $user->profileable->country }}"  autocomplete="current-country">

                                        @error('country')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="occupation" class="col-md-4 col-form-label text-md-right">Occupation</label>

                                    <div class="col-md-6">
                                        <input id="occupation" type="text" class="form-control @error('occupation') is-invalid @enderror" name="occupation" value="{{ old('occupation')  ? old('occupation') : $user->profileable->occupation }}"  autocomplete="current-occupation">

                                        @error('occupation')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            @if($user->type == UserType::DOCTOR)
                                <div class="form-group row">
                                    <label for="specialty" class="col-md-4 col-form-label text-md-right">Specialty</label>

                                    <div class="col-md-6">

                                        <select name="specialty" id="specialty" class="form-control @error('specialty') is-invalid @enderror ">
                                            @foreach ($specialties as $specialty)
                                                <option value="{{ $specialty->id }}" {{ $specialty->id == optional($user->profileable->specialty)->id ? 'selected' : '' }}>{{ $specialty->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('specialty')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            @endif


                            <div class="form-group row">
                                <label for="type" class="col-md-4 col-form-label text-md-right">Type</label>

                                <div class="col-md-6">

                                    <select name="type" id="type" class="form-control @error('type') is-invalid @enderror ">
                                        @foreach (UserType::$types as $key =>$type)
                                            <option value="{{ $key }}" {{ $user->type == $key ? 'selected' : '' }}>{{ $type }}</option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div id="change-password" class=" @error ('new_password') d-block @else d-none @enderror" >


                                <div class="form-group row">
                                    <label  class="col-md-4 col-form-label text-md-right">New Password</label>

                                    <div class="col-md-6">
                                        <input  type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password"   >

                                        @error('new_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label  class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                                    <div class="col-md-6">
                                        <input  type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password_confirmation"   >
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row ">
                                <div class="col-md-8 offset-md-4">
                                    <button type="button" class="btn btn-info" id="change-password-btn">
                                        Change Password
                                    </button>
                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>


@endsection
@section('script')
    <script src="{{ asset('/js/profile.js') }}"></script>
@endsection

