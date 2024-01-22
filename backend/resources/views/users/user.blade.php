@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')
    <div class="container my-5 py-5">
        <div class="card">
            <div class="card-header">User Account - {{strtoupper($user->u_username)}}</div>
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
                <div class="row">
                    <form action="/user/updateuserprofile" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="id" value="{{$user->id}}">
                        <div class="col-sm-6">
                            <div class="my-1 p-1">
                                <label for="u_fname">First Name</label>
                                <input type="text" name="u_fname" id="u_fname" class="form-control" value="{{$user->u_fname}}">
                            </div>

                            <div class="my-1 p-1">
                                <label for="u_lname">Last Name</label>
                                <input type="text" name="u_lname" id="u_lname" class="form-control" value="{{$user->u_lname}}">
                            </div>

                            <div class="my-1 p-1">
                                <label for="u_mname">Middle Name (Optional)</label>
                                <input type="text" name="u_mname" id="u_mname" class="form-control" value="{{$user->u_mname}}">
                            </div>

                            <div class="my-1 p-1">
                                <label for="u_email">Email (Optional)</label>
                                <input type="email" name="u_email" id="u_email" class="form-control" value="{{$user->u_email}}">
                            </div>

                        </div>

                        <div class="col-sm-6">
                            <div class="my-3 p-3">
                                <label for="u_role">Role</label>
                                <select name="u_role" id="" class="form-select">
                                    <option value="{{$user->u_role}}">
                                        @if($user->u_role == 1)
                                            Admin
                                        @else
                                            User
                                        @endif
                                    </option>
                                    <option value="1">Admin</option>
                                    <option value="2">User</option>
                                </select>
                            </div>

                            <div class="col-sm-6">
                                <div class="my-3">
                                    <label for="u_department">Department</label>
                                    <select name="u_department" id="u_department" class="form-select">
                                        <option value="{{$user->d_id}}">{{$user->d_code}} - {{$user->d_description}}</option>
                                        @foreach($departments as $department)
                                            <option value="{{$department->d_id}}">{{$department->d_description}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="my-3">
                                    <label>Status: @if($user->u_status == 1) Active @else Disabled @endif</label>
                                </div>

                            </div>
                        </div>
                        <button class="btn btn-sm btn-primary">Update</button>
                    </form>
                </div>

                <hr>

                <div class="row">
                    @if($user->id == Auth::user()->id)
                        <div class="col-sm-6">
                            <div class="my-1 p-1">
                                <label for="changepassword">Change Password</label>
                                <form action="/user/changepassword" method="post">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="id" value="{{$user->id}}">
                                    <div class="my-1">
                                        <input type="password" name="old_password" id="old_password" placeholder="Old Password"  required>
                                    </div>

                                    <div class="my-1">
                                        <input type="password" name="u_password" id="u_password" placeholder="New Password" required>
                                    </div>

                                    <div class="my-1">
                                        <input type="password" name="u_password2" id="u_password2" placeholder="Re-type Password" required>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-sm btn-warning">Change Password</button>
                                </form>
                            </div>
                        </div>
                    @endif

                    <div class="col-sm-6">
                        @if(Auth::user()->u_role == 1)
                            <div class="my-1 p-1">
                                <form action="/user/resetpassword" method="post">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="id" value="{{$user->id}}">
                                    <button type="submit" class="btn btn-sm btn-warning">Reset Password</button>
                                </form>
                            </div>
                        @endif

                        @if($user->u_role == 1)
                            @if($user->u_status == 1)
                                <div class="my-1 p-1">
                                    <form action="/user/disable" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="id" value="{{$user->id}}">
                                        <button type="submit" class="btn btn-sm btn-danger">Disable Account</button>
                                    </form>
                                </div>
                            @endif

                            @if($user->u_status == 2)
                                <div class="my-1 p-1">
                                    <form action="/user/reactivate" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="id" value="{{$user->id}}">
                                        <button type="submit" class="btn btn-sm btn-success">Re-activate Account</button>
                                    </form>
                                </div>
                            @endif
                        @endif

                        @if($user->u_role == 1)
                            <div class="my-1 p-1">
                                <a href="/users" class="btn btn-sm btn-primary my-3">Back</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection