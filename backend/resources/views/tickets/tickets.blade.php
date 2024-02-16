@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')
    @if(Auth::user()->u_role == 1)
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-2 bg-dark">
                    @include('_parts.t_sidebar')
                </div>
                <div class="col-sm-10 pt-5">
                    <div class="card mt-5">
                        <div class="card-header bg-dark">
                                <div class="float-start" data-bs-toggle="tooltip" data-bs-placement="top" title="Create Ticket"><a href="/newticket" class="btn btn-sm btn-primary"><i class="bi bi-plus-circle"></i></a></div>
                                <div class="float-end">@include('_parts.t_search')</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
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
            
                                    @include('_parts.t_table')
            
                                </div>
                            </div>                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="container">
            <div class="row">
                <div class="col-sm-12 pt-5">
                    <div class="card mt-5">
                        <div class="card-header bg-dark pb-0">
                                <div class="float-start"><a href="/newticket" class="btn btn-sm btn-primary my-1">Create ticket</a></div>
                                <div class="float-end">@include('_parts.t_search')</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
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
            
                                    @include('_parts.t_table')
            
                                </div>
                            </div>                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection