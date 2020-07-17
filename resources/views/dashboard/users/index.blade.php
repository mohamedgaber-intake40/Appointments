@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <a href="{{ route('dashboard.users.create') }}" class="btn btn-primary float-right mr-2 mb-2">Create</a>
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
                    </div>
                </div>
                <!-- end Notifications -->

                <table class="table text-center " style="min-height: 600px;">
                    <thead class="thead-dark">
                        <th>#</th>
                        <th>User Name</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th colspan="3" class="text-center">Actions</th>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->user_name }}</td>
                                <td>{{ $user->name }}</td>
                                <td> {{ UserType::$types[$user->type] }} </td>
                                <td>
                                    <a href="{{ route('dashboard.users.show',['user'=>$user]) }}" class="btn btn-info">Show</a>                               </td>
                                <td>
                                    <a href="{{ route('dashboard.users.edit',['user'=>$user]) }}" class="btn btn-warning">Edit</a>
                               </td>
                               <td>
                                   <form action="{{ route('dashboard.users.destroy',['user'=>$user]) }}" method="POST">
                                       @csrf
                                       @method('delete')
                                       <button type="submit"class="btn btn-danger">Delete</button>
                                   </form>
                               </td>

                            </tr>
                        @empty
                            <td colspan="6">No Users yet</td>
                        @endforelse


                    </tbody>
                </table>
                {{ $users->links() }}
            </div>
        </div>
    </div>

@endsection
