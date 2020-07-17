@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Apppointment</div>

                    <div class="card-body">
                            <div class="form-group row">
                                <h5 for="doctor" class="col-md-4  text-md-right">Doctor</h5>

                                <div class="col-md-6">
                                    <h5>{{ optional($appointment->doctor)->name }}</h5>
                                </div>
                            </div>

                            <div class="form-group row">
                                <h5 for="patient" class="col-md-4  text-md-right">Patient </h5>

                                <div class="col-md-6">
                                    <h5>{{ $appointment->patient->name }}</h5>
                                </div>
                            </div>

                            <div class="form-group row">
                                <h5 for="pain" class="col-md-4  text-md-right">Pain </h5>

                                <div class="col-md-6">
                                    <h5>{{ $appointment->pain->title }}</h5>
                                </div>
                            </div>

                            <div class="form-group row">
                                <h5 for="date" class="col-md-4 text-md-right">Date </h5>

                                <div class="col-md-6">
                                    <h5>{{ optional($appointment->date)->toDayDateTimeString() }}</h5>
                                </div>
                            </div>

                            <div class="form-group row">
                                <h5 for="created_at" class="col-md-4  text-md-right">Created At </h5>

                                <div class="col-md-6">
                                    <h5>{{ $appointment->created_at->toDayDateTimeString() }}</h5>
                                </div>
                            </div>

                            <div class="form-group row">
                                <h5 for="updated_at" class="col-md-4  text-md-right">Updated At </h5>

                                <div class="col-md-6">
                                    <h5>{{ $appointment->updated_at->toDayDateTimeString() }}</h5>
                                </div>
                            </div>




                            @if( ( $appointment->date && !$appointment->is_patient_refuse && Auth::user()->type == UserType::PATIENT ) || (Auth::user()->type == UserType::DOCTOR &&!$appointment->is_doctor_refuse ))
                                <div class="form-group row justify-content-center">
                                    <form action="{{  route('appointments.update',['appointment'=>$appointment]) }}" method="POST">
                                        @csrf
                                        @method('put')
                                         <button class="btn btn-secondary">Refuse </button>
                                        <input type="hidden" value="1" name="refuse">
                                    </form>
                                </div>
                                @endif

                                @if(!$appointment->date && Auth::user()->type == UserType::PATIENT)
                                    <div  class="form-group row justify-content-center">
                                         <a  href="{{ route('appointments.edit',['appointment'=>$appointment]) }}" class="btn btn-warning" >Edit</a>
                                    </div>
                                @endif

                                @if(Auth::user()->type == UserType::PATIENT)
                                    <div class="form-group row justify-content-center">
                                        <form action="{{ route('appointments.destroy',['appointment'=>$appointment]) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div class="form-group row justify-content-center">
                                @endif

                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection

