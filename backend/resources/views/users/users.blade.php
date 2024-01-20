@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')
    <div class="container my-5 py-5">
        <div class="card">
            <div class="card-header">Users</div>
            <div class="card-body">
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        <strong>{{ session()->get('success') }}</strong>
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        <strong>{{ session()->get('error') }}</strong>
                    </div>
                @endif

                <a href="/register" class="btn btn-sm btn-primary my-3">Add User</a>
                
                <table class="table table-sm table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Username</th>
                            <th>Department</th>
                            <th>Role</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->u_lname}}</td>
                            <td>{{$user->u_fname}}</td>
                            <td>{{$user->u_mname}}</td>
                            <td>{{$user->u_username}}</td>
                            <td>{{$user->d_description}}</td>
                            <td>
                                @if($user->u_role == 1)
                                    Admin                            
                                @else
                                    User
                                @endif
                            </td>
                            <td>
                                @if($user->u_status == 1)
                                    Active
                                @else
                                    Disabled
                                @endif
                            </td>
                            <td>
                                <a href="/user/{{$user->id}}" class="btn btn-sm btn-primary"><i class="bi bi-three-dots-vertical"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection