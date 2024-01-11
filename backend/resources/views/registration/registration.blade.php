@extends('layouts.app')

@section('title', 'Ticketing System')

@section('header')
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark sticky-top">
        <div class="container-fluid">
            <span class="navbar-text small p-0 m-0">Ticketing System</span>
        </div>
    </nav>
@endsection

<!-- --------------------------------------------------------- -->

@section('navigation')
    <nav class="navbar navbar-expand-sm bg-light navbar-light sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand h1" href="#">WMC</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse float-end" id="collapsibleNavbar">
                @if(Auth::user())
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                    </ul>
                @endif
            </div>
        </div>
    </nav>
@endsection

<!-- --------------------------------------------------------- -->

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 9vh;">
    <div class="card">
        <div class="card-header"><strong>New User</strong></div>
        <div class="card-body">
            <form>
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
                        <option value="1">Credit and Collections Deparartment</option>
                        <option value="2">User</option>
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

                <div class="mb-3">
                    <label for="u_username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="u_username" name="u_username" required>
                </div>
        
                <div class="mb-3">
                    <label for="u_password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="u_password" name="u_password" required>
                </div>

                <div class="mb-3">
                    <label for="u_password2" class="form-label">Re-type Password</label>
                    <input type="password" class="form-control" id="u_password2" name="u_password2" required>
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</div>
  
@endsection