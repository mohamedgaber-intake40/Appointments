@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">

                @if(Auth::user()->type == UserType::PATIENT)
                    <a href="{{ route('appointments.create') }}" class="btn btn-primary float-right mr-2 mb-2">Create</a>
                @endif
                <!-- Notifications -->
                <div class="row justify-content-center">
                    <div class="col-6">
                        @if (Session::has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{Session::get('success')}}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if (Session::has('updated'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{Session::get('updated')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    </div>
                </div>
                <!-- end Notifications -->

                <table class="table text-center " style="min-height: 600px;">
                    <thead class="thead-dark">
                        <th>Date</th>
                        @if(Auth::user()->type === UserType::PATIENT)
                        <th>Doctor</th>
                        @else
                        <th>Patient</th>
                        @endif
                        <th>Pain</th>
                        <th colspan="3" class="text-center">Actions</th>
                    </thead>
                    <tbody>
                        @forelse ($appointments as $appointment)
                            <tr>
                                <td>{{ $appointment->date }}</td>

                                @if(Auth::user()->type === UserType::PATIENT)
                                    <td>{{ optional($appointment->doctor)->name }}</td>
                                @else
                                    <td>{{ $appointment->patient->name }}</td>
                                @endif

                                <td> {{ $appointment->pain->title }} </td>

                                @if( ( $appointment->date && !$appointment->is_patient_refuse && Auth::user()->type == UserType::PATIENT ) || (Auth::user()->type == UserType::DOCTOR &&!$appointment->is_doctor_refuse ))
                                <form action="{{  route('appointments.update',['appointment'=>$appointment]) }}" method="POST">
                                    @csrf
                                    @method('put')
                                    <td> <button class="btn btn-secondary">Refuse</button> </td>
                                    <input type="hidden" value="1" name="refuse">
                                </form>
                                @endif
                                @if(!$appointment->date && Auth::user()->type == UserType::PATIENT)
                                    <td> <a  href="{{ route('appointments.edit',['appointment'=>$appointment]) }}" class="btn btn-warning" >Edit</a> </td>
                                @endif
                                @if(Auth::user()->type == UserType::PATIENT)

                                    <td>
                                        <form action="{{ route('appointments.destroy',['appointment'=>$appointment]) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger">Delete</button> </td>
                                        </form>
                                @endif
                            </tr>
                        @empty
                            <td colspan="6">No Appointments yet</td>
                        @endforelse


                    </tbody>
                </table>
                {{ $appointments->links() }}
            </div>
        </div>
    </div>

@endsection
