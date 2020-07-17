@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Notification</div>

                    <div class="card-body">
                            <div class="form-group row">

                                <div class="col-md-12 text-center">
                                    <h5>{{ $notification->data['message'] }}</h5>
                                </div>
                            </div>

                            <div class="form-group row justify-content-center">

                                <div class="col-md-8 mx-auto text-center">
                                    <a href="{{ route('appointments.show',['appointment'=>$appointment]) }}" class="btn btn-info mx-auto text-center">View Appointment</a>
                                </div>
                            </div>










                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection

