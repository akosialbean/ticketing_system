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
    <div class="container my-5 py-5">
        <div class="card">
            <div class="card-header">Login</div>
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

                <form action="/log" method="POST">
                    @csrf
                    <div class="container px-5">
                        <div class="row justify-content-center">
                            <div class="col-2 px-5 py-3">
                                <label for="u_username">Username</label>
                            </div>
                            <div class="col-5 px-5">
                                <input type="text" id="u_username" class="form-control" name="u_username" required>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-2 px-5 py-3">
                                <label for="u_password">Password</label>
                            </div>
                            <div class="col-5 px-5">
                                <input type="password" id="u_password" name="password" class="form-control" required>
                            </div>
                        </div>
                        <div class="row justify-content-center py-3">
                            <div class="col-2">
                                <button type="submit" class="btn btn-primary btn-sm ms-auto float-start">Login</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection