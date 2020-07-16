@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                  Create Appointment
                </div>
                <div class="card-body">

                   <form action="{{ route('appointments.store') }}" method="POST">
                        @csrf
                        <div class="form-group row justify-content-center">
                            <label for="pain" class="col-md-2 col-form-label text-md-right">Pain</label>

                            <div class="col-md-8">
                                <select name="pain" class="form-control @error('pain') is-invalid @enderror ">

                                    @foreach ($pains as $pain)
                                        <option value="{{ $pain->id }}">{{ $pain->title }}</option>
                                    @endforeach

                                </select>
                                @error('pain')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                   </form>
                </div>
            </div>
        </div>
    </div>
@endsection
