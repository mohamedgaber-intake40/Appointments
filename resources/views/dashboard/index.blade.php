@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">

                <div class="form-group row justify-content-center mt-4  text-white ">
                    <div class="col-md-6 mx-auto text-center bg-secondary p-5 dashboard">
                        <a href="{{ route('dashboard.appointments.index') }}" class="text-white">Appointments</a>
                    </div>
                </div>

                <div class="form-group row justify-content-center">
                    <div class="col-md-6 mx-auto text-center bg-secondary p-5 dashboard" >
                        <a href="{{ route('dashboard.users.index') }}" class="text-white">Users</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
