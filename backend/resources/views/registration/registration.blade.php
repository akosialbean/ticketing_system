@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 9vh;">
    <div class="card">
        <div class="card-header"><strong>New User</strong></div>
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

            <form action="/adduser" method="POST">
                @csrf
                @method('POST')
                <div class="mb-3">
                    <label for="u_fname" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="u_fname" aria-describedby="emailHelp" name="u_fname" required>
                </div>
        
                <div class="mb-3">
                    <label for="u_lname" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="u_lname" name="u_lname" required>
                </div>

                <div class="mb-3">
                    <label for="u_mname" class="form-label">Middle Name</label>
                    <input type="text" class="form-control" id="u_mname" name="u_mname">
                </div>

                <div class="mb-3">
                    <label for="u_email" class="form-label">Email <i>(Optional)</i></label>
                    <input type="email" class="form-control" id="u_email" name="u_email">
                </div>

                <div class="mb-3">
                    <label for="u_department" class="form-label">Department</label>
                    <select class="form-select" name="u_department" id="u_department" required>
                        <option value="">--</option>
                        @foreach($departments as $department)
                            <option value="{{$department->d_id}}">{{$department->d_description}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="u_role" class="form-label">Role</label>
                    <select class="form-select" name="u_role" id="u_role" required>
                        <option value="">--</option>
                        <option value="1">Admin</option>
                        <option value="2">User</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</div>
  
@endsection