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
            <a class="navbar-brand" href="#">Logo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse float-end" id="collapsibleNavbar">
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
            </div>
        </div>
    </nav>
@endsection

<!-- --------------------------------------------------------- -->

@section('content')
    <h1>Hello World!</h1>
@endsection