@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                  Edit Appointment
                </div>
                <div class="card-body">

                   <form action="{{ route('dashboard.appointments.update',['appointment'=>$appointment]) }}" method="POST">
                        @csrf
                        @method('put')
                        @if( $appointment->status != AppointmentStatus::PATIENT_REFUSE )

                            <div class="form-group row justify-content-center">
                                <label for="dctor" class="col-md-2 col-form-label text-md-right">Doctor</label>

                                <div class="col-md-8">
                                    <select name="doctor_id" class="form-control @error('doctor_id') is-invalid @enderror">
                                        @foreach ($doctorProfiles as $doctorProfile)
                                            <option value="{{ $doctorProfile->user->id }}" {{ $doctorProfile->user->id == $appointment->doctor_id ? 'selected' : '' }} > {{ $doctorProfile->user->name }} </option>
                                        @endforeach
                                    </select>

                                    @error('doctor_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                            </div>
                        @endif

                        @if( $appointment->status != AppointmentStatus::DOCTOR_REFUSE )

                            <div class="form-group row justify-content-center">
                                    <label for="date" class="col-md-2 col-form-label text-md-right">Date</label>

                                    <div class="col-md-8">
                                        <input  type="datetime-local" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date') ? old('date') : Carbon::parse($appointment->date)->format('h:i d/m/y ')  }}"
                                        required >
                                        @error('date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                            </div>
                        @endif

                        <div class="form-group row justify-content-center">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                   </form>
                </div>
            </div>
        </div>
    </div>
@endsection
