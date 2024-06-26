@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')
    <div class="container-fluid mt-5 pt-5">
        <div class="card">
            <div class="card-header bg-dark text-light"><strong class="small">Dashboard</strong></div>
            <div class="card-body">
                <div class="container-fluid">
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
                        <div class="col-lg-4 mb-3">
                            <div class="card">
                                <div class="card-header"><strong>{{$userdept->d_code}} - Total Tickets</strong></div>
                                <div class="card-body text-center">
                                    <strong class="display-3">{{$totalTickets}}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 mb-3">
                            <div class="card">
                                <div class="card-header"><strong>{{$userdept->d_code}} - New Ticket Status</strong></div>
                                <div class="card-body pb-1">
                                    {!! $tickets->container() !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 mb-3">
                            <div class="card">
                                <div class="card-header"><strong>{{$userdept->d_code}} - Ticket Resolutions</strong></div>
                                <div class="card-body">
                                    {!! $resolved->container() !!}
                                </div>
                            </div>
                        </div>

                        
                    </div>

                    <div class="row">
                        <div class="col-lg-6 my-3">
                            <div class="card">
                                <div class="card-header"><strong>{{$userdept->d_code}} - {{now()->year}} Tickets</strong></div>
                                <div class="card-body">
                                    {!! $createdticket->container() !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 my-3">
                            <div class="card">
                                <div class="card-header"><strong>{{now()->year}} Resolved Tickets</strong></div>
                                <div class="card-body">
                                    {{ $resolvers->container() }}
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 my-3">
                            <div class="card">
                                <div class="card-header"><strong>{{now()->year}} Tickets Created Per Department</strong></div>
                                <div class="card-body">
                                    {{ $departments->container() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ $tickets->cdn() }}"></script>
    <script src="{{ $resolved->cdn() }}"></script>
    <script src="{{ $createdticket->cdn() }}"></script>
    <script src="{{ $cancelled->cdn() }}"></script>
    <script src="{{ $resolvers->cdn() }}"></script>
    <script src="{{ $departments->cdn() }}"></script>

    {{ $tickets->script() }}
    {{ $resolved->script() }}
    {{ $createdticket->script() }}
    {{ $cancelled->script() }}
    {{ $resolvers->script() }}
    {{ $departments->script() }}
@endsection