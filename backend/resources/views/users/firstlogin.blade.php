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
    <div class="container mt-5 p-5">
        <div class="card">
            <div class="card-header">Change Password</div>
            <div class="card-body px-5">
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

                <form action="/user/firstlogin/changepassword" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="id" value="{{Auth::user()->id}}">
                    <div class="container px-5">
                        <div class="row justify-content-center">
                            <div class="col-4 py-3 text-end">
                                <label for="u_password">New Password</label>
                            </div>
                            <div class="col-5 px-2">
                                <input type="password" id="u_password" class="form-control" name="u_password" autofocus required>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-4 py-3 text-end">
                                <label for="u_password2">Re-type Password</label>
                            </div>
                            <div class="col-5 px-2">
                                <input type="password" id="u_password2" name="u_password2" class="form-control" required>
                            </div>
                        </div>
                        <div class="row justify-content-center py-3">
                            <div class="col-5">
                                <button type="submit" class="btn btn-primary btn-sm ms-auto float-start">Update Password</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection