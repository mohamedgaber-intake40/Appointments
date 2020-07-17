@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">

                <table class="table text-center " >
                    <thead class="thead-dark">
                        <th>#</th>
                        <th>Pain</th>
                        <th>date</th>
                    </thead>
                    <tbody>
                        @forelse ($notifications as $key =>$notification)
                            <tr class="{{ !$notification->read_at ? 'notifications '  : '' }}">
                                <td>{{ $key+1 }}</td>
                                <td>
                                    <a href="{{ route('notifications.show',['notification'=>$notification->id]) }}" >{{ $notification->data['appointment_pain'] }}
                                    </a>
                                </td>
                                <td>{{ $notification->data['appointment_date'] }}</td>
                            </tr>
                        @empty
                            <td colspan="6">No Notifications yet</td>
                        @endforelse


                    </tbody>
                </table>
                {{ $notifications->links() }}
            </div>
        </div>
    </div>

@endsection
