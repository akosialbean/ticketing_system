@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')
    <div class="container mt-5 py-5">
        <div class="card">
            <div class="card-header bg-dark text-light"><strong>User Account - {{strtoupper($user->u_username)}}</strong></div>
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
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-header"><strong>User Information</strong></div>
                            <div class="card-body">
                                <form action="/user/updateuserprofile" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="id" value="{{$user->id}}">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="u_fname"><strong>First Name</strong></label>
                                            <input type="text" name="u_fname" id="u_fname" class="form-control form-control-sm w100" value="{{$user->u_fname}}">
                                        </div>
            
                                        <div class="col-md-12 mb-3">
                                            <label for="u_lname"><strong>Last Name</strong></label>
                                            <input type="text" name="u_lname" id="u_lname" class="form-control form-control-sm" value="{{$user->u_lname}}">
                                        </div>
            
                                        <div class="col-md-12 mb-3">
                                            <label for="u_mname"><strong>Middle Name</strong> (Optional)</label>
                                            <input type="text" name="u_mname" id="u_mname" class="form-control form-control-sm" value="{{$user->u_mname}}">
                                        </div>
            
                                        <div class="col-md-12 mb-3">
                                            <label for="u_email"><strong>Email</strong> (Optional)</label>
                                            <input type="email" name="u_email" id="u_email" class="form-control form-control-sm" value="{{$user->u_email}}" required>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label><strong>Status:</strong> @if($user->u_status == 1) Active @else Disabled @endif</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <button class="btn btn-sm btn-primary float-end"><strong class="small"><i class="bi bi-floppy me-2"></i>Save</strong></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div> 
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header"><strong>Access Controls</strong></div>
                            <div class="card-body">
                                <div class="row">
                                    @if(Auth::user()->u_role == 1 && Auth::user()->u_department == 1)
                                        <div class="col-sm-12 mb-3">
                                            <label for="u_username"><strong>Username</strong></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" placeholder="username" name="u_username" id="u_username" value="{{$user->u_username}}" disabled>
                                                <button class="btn btn-sm btn-success" type="button" data-bs-toggle="modal" data-bs-target="#changeusername"><strong class="small"><i class="bi bi-code-square me-2"></i>Change</strong></button>
                                            </div>
                                        </div>
                                    @endif

                                    <form action="#" method="POST">
                                        @csrf
                                        @method('POST')
                                        @if(Auth::user()->u_department == 1)
                                            <div class="col-sm-12 mb-3">
                                                <label for="u_department"><strong>Department</strong></label>
                                                <select name="u_department" id="u_department" class="form-select form-select-sm">
                                                    <option value="{{$user->d_id}}">{{$user->d_code}} - {{$user->d_description}}</option>
                                                    @foreach($departments as $department)
                                                        <option value="{{$department->d_id}}">{{$department->d_description}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif
                                        
                                        @if(Auth::user()->u_department == 1)
                                            <div class="col-sm-12 mb-3">
                                                <label for="u_role"><strong>Role</strong></label>
                                                <select name="u_role" id="" class="form-select form-select-sm">
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
                                        @endif
                                        
                                        <div class="col-md-12">
                                            <button class="btn btn-sm btn-primary float-end"><strong class="small"><i class="bi bi-floppy me-2"></i>Save</strong></button>
                                        </div>
                                    </form>
                                </div>

                                <hr>

                                <div class="row">
                                    @if($user->id == Auth::user()->id)
                                        <div class="col-sm-6">
                                            <label for="changepassword"><strong>Change Password</strong></label>
                                            <form action="/user/changepassword" method="post">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="id" value="{{$user->id}}">
                                                <div class="col-md-12 mb-3">
                                                    <input type="password" class="form-control form-control-sm mb-3" name="old_password" id="old_password" placeholder="Old Password"  required>
                                                </div>

                                                <div class="col-md-12 mb-3">
                                                    <input type="password" class="form-control form-control-sm mb-3" name="u_password" id="u_password" placeholder="New Password" required>
                                                </div>

                                                <div class="col-md-12 mb-3">
                                                    <input type="password" class="form-control form-control-sm mb-3" name="u_password2" id="u_password2" placeholder="Re-type Password" required>
                                                </div>
                                                
                                                <div class="col-md-12 mb-3">
                                                    <button type="submit" class="btn btn-sm btn-warning w-100"><strong class="small"><i class="bi bi-transparency me-2"></i>Change Password</strong></button>
                                                </div>
                                            </form>
                                        </div>
                                    @endif

                                    @if(Auth::user()->u_role == 1 && Auth::user()->u_department == 1)
                                        <div class="col-sm-6">
                                            @if(Auth::user()->u_role == 1 && Auth::user()->u_department == 1)
                                                @if($user->u_status == 1)
                                                    <form action="/user/disable" method="post">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="id" value="{{$user->id}}">
                                                        <button type="submit" class="btn btn-sm btn-danger w-100"><strong class="small"><i class="bi bi-stop-circle me-2"></i>Disable Account</strong></button>
                                                    </form>
                                                @endif

                                                @if($user->u_status == 2)
                                                    <div class="my-1 p-1">
                                                        <form action="/user/reactivate" method="post">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="id" value="{{$user->id}}">
                                                            <button type="submit" class="btn btn-sm btn-success w-100"><strong>Re-activate Account</strong></button>
                                                        </form>
                                                    </div>
                                                @endif
                                            @endif

                                            <form action="/user/resetpassword" method="post">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="id" value="{{$user->id}}">
                                                <button type="submit" class="btn btn-sm btn-warning w-100"><strong class="small"><i class="bi bi-arrow-repeat me-2"></i>Reset Password</strong></button>
                                            </form>
                                        </div>
                                    @endif

                                    
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection


<div class="modal" id="changeusername">
    <div class="modal-dialog modal-sm modal-dialog-centered">
      <div class="modal-content">
  
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Change Username</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
  
        <!-- Modal body -->
        <div class="modal-body">
            <form action="/user/{{$user->id}}/changeusername" method="POST">
                @csrf
                @method('PATCH')
                <input type="text" name="u_username" id="u_username" class="form-control form-control-sm mb-3" value="{{$user->u_username}}">
                <button type="submit" class="btn btn-sm btn-primary float-end">Save</button>
            </form>
        </div>
  
      </div>
    </div>
  </div>