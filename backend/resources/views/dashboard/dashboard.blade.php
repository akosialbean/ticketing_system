@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')
    <div class="container-fluid mt-5 pt-5">
        <div class="card">
            <div class="card-header"><strong class="small">Dashboard</strong></div>
            <div class="card-body">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 my-3">
                            <div class="card">
                                <div class="card-body">
                                    {!! $tickets->container() !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 my-3">
                            <div class="card">
                                <div class="card-body">
                                    {!! $resolved->container() !!}
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="col-sm-6 my-3">
                            <div class="card">
                                <div class="card-body">
                                    {!! $tickets->container() !!}
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

    {{ $tickets->script() }}
    {{ $resolved->script() }}
@endsection