@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')
    <div class="container my-5 py-5">
        <div class="card">
            <div class="card-header">Users</div>
            <div class="card-body">
                <h1>User {{$user->u_fname}}</h1>
                <a href="/users" class="btn btn-sm btn-danger">Back</a>
            </div>
        </div>
    </div>
@endsection