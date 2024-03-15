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
            <div class="card-header"><strong class="small">Login</strong></div>
            <div class="card-body px-5" style="background:url({{asset('imgs/wmc.jpg')}}) fixed no-repeat;background-size: cover;">
                <div class="row">
                    <div class="col-sm-12 col-md-9 col-lg-9 col-xl-9" style="height: 100%"></div>
                    <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">
                        <form action="/log" method="POST">
                            @csrf
                            <div class="card">
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
                                        <div class="col-lg-12 mb-3">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text"><strong class="small">Username</strong></span>
                                                <input type="text" name="u_username" id="u_username" class="form-control form-control-sm" placeholder="Username" autofocus required>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mb-3">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text"><strong class="small">Password</strong></span>
                                                <input type="password" name="password" id="u_password" class="form-control form-control-sm" placeholder="******" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <button type="submit" class="btn btn-primary btn-sm ms-auto float-end" onclick="disablebtn()"><strong class="small">Login</strong></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                
            </div>
        </div>
    </div>
@endsection