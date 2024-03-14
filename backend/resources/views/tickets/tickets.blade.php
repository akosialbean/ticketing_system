@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')
    @if(Auth::user()->u_role == 1)
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2 bg-secondary mb-0">
                    @include('_parts.t_sidebar')
                </div>
                <div class="col-md-10 pt-5">
                    <div class="card mt-5">
                        <div class="card-header bg-dark clearfix">
                                <div class="float-start" data-bs-toggle="tooltip" data-bs-placement="top" title="Create Ticket">
                                    <strong class="text-light me-3">
                                        @switch($myticket)                                            
                                            @case('search')
                                                Search Tickets
                                                @break
                                            @case('newtickets')
                                                New Tickets
                                                @break
                                            @case('overduetickets')
                                                Overdue Tickets
                                                @break
                                            @case('mytickets')
                                                My Tickets
                                                @break
                                            @case('assignedtickets')
                                                Assigned Tickets
                                                @break
                                            @case('opentickets')
                                                Open Tickets
                                                @break
                                            @case('acknowledgedtickets')
                                                Acknowledged Tickets
                                                @break
                                            @case('resolvedtickets')
                                                Resolved Tickets
                                                @break
                                            @case('closedtickets')
                                                Closed Tickets
                                                @break
                                            @case('cancelledtickets')
                                                Cancelled Tickets
                                                @break
                                            @default
                                                All Tickets
                                                @break
                                        @endswitch
                                    </strong>
                                    <a href="/newticket" class="btn btn-sm btn-primary"><i class="bi bi-plus-circle"></i></a>
                                </div>
                                <div class="float-end">@include('_parts.t_search')</div>
                        </div>
                        <div class="card-body  bg-body-secondary">
                            <div class="row">
                                <div class="col-md-12">
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
                <div class="col-md-12 pt-5">
                    <div class="card mt-5">
                        <div class="card-header bg-dark pb-0">
                                <div class="float-start"><a href="/newticket" class="btn btn-sm btn-primary my-1">Create ticket</a></div>
                                <div class="float-end">@include('_parts.t_search')</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
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