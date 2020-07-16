@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"># {{ $appointment->id }}</div>

                    <div class="card-body">
                            <div class="form-group row ">
                                <h5 class="col-md-4 text-md-center">Date:</h5>

                                <div class="col-md-6 text-md-center">
                                    <h5>{{ $appointment->date }}</h5>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <h5 class="col-md-4 text-md-center">Patient:</h5>

                                <div class="col-md-6 text-md-center">
                                    <h5>{{ $appointment->patient->name }}</h5>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <h5 class="col-md-4 text-md-center">Doctor:</h5>

                                <div class="col-md-6 text-md-center">
                                    <h5>{{ $appointment->doctor->name }}</h5>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <h5 class="col-md-4 text-md-center">Pain:</h5>

                                <div class="col-md-6 text-md-center">
                                    <h5>{{ $appointment->pain->title }}</h5>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <h5 class="col-md-4 text-md-center">Status:</h5>

                                <div class="col-md-6 text-md-center">
                                    <h5>{{ AppointmentStatus::$statuses[$appointment->status] }}</h5>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <h5 class="col-md-4 text-md-center">Created At:</h5>

                                <div class="col-md-6 text-md-center">
                                    <h5>{{ $appointment->created_at }}</h5>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <h5 class="col-md-4 text-md-center">Updated At:</h5>

                                <div class="col-md-6 text-md-center">
                                    <h5>{{ $appointment->updated_at }}</h5>
                                </div>
                            </div>



                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection

