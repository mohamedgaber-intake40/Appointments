@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                  Create Appointment
                </div>
                <div class="card-body">

                   <form action="{{ route('appointments.update',['appointment'=>$appointment]) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="form-group row justify-content-center">
                            <label for="pain" class="col-md-2 col-form-label text-md-right">Pain</label>

                            <div class="col-md-8">
                                <select name="pain" class="form-control">
                                    @foreach ($pains as $pain)
                                        <option value="{{ $pain->id }}" {{ $pain->id == $appointment->pain_id ? 'selected' : '' }} > {{ $pain->title }} </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                   </form>
                </div>
            </div>
        </div>
    </div>
@endsection
