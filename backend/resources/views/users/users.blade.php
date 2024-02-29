@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')
    <div class="container my-5 py-5">
        <div class="card">
            <div class="card-header bg-dark text-light" data-bs-toggle="tooltip" data-bs-placement="top" title="Add User">
                <div class="float-start"><strong>Users | <a href="/register" class="btn btn-sm btn-primary"><i class="bi bi-plus-circle"></i></a></strong></div>
                <div class="float-end">
                    @include('_parts.u_search')
                </div>
            </div>
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
                
                @include('_parts.u_table')
            </div>

            <div class="d-flex justify-content-center">
                {{$users->links()}}
            </div>
        </div>
    </div>
@endsection