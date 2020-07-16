@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">

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
                        <th>#</th>
                        <th>Date</th>
                        <th>Doctor</th>
                        <th>Patient</th>
                        <th>Pain</th>
                        <th>Status</th>
                        <th colspan="2" class="text-center">Actions</th>
                    </thead>
                    <tbody>
                        @forelse ($appointments as $appointment)
                            <tr>
                                <td>{{ $appointment->id }}</td>
                                <td>{{ $appointment->date }}</td>
                                <td>{{ optional($appointment->doctor)->name }}</td>
                                <td>{{ $appointment->patient->name }}</td>
                                <td> {{ $appointment->pain->title }} </td>
                                <td> {{ AppointmentStatus::$statuses[$appointment->status] }}</td>

                                @if ( $appointment->status ===  AppointmentStatus::WAITING)
                                    <td> <a href="{{ route('dashboard.appointments.edit',['appointment'=>$appointment]) }}" class="btn btn-primary">Assign Doctor</a> </td>
                                @endif

                                @if ( $appointment->status ===  AppointmentStatus::BOTH_REFUSE )

                                    <td> <a href="{{ route('dashboard.appointments.edit',['appointment'=>$appointment]) }}" class="btn btn-warning">Edit</a> </td>

                                @elseif ( $appointment->status ===  AppointmentStatus::DOCTOR_REFUSE)

                                    <td> <a href="{{ route('dashboard.appointments.edit',['appointment'=>$appointment]) }}" class="btn btn-info">Reassign Doctor</a> </td>

                                @elseif (  $appointment->status ===  AppointmentStatus::PATIENT_REFUSE)

                                    <td> <a href="{{ route('dashboard.appointments.edit',['appointment'=>$appointment]) }}" class="btn btn-info">Reschedule</a> </td>

                                @endif

                                <td> <a href="{{ route('dashboard.appointments.show',['appointment'=>$appointment]) }}" class="btn btn-primary">Show</a> </td>



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
