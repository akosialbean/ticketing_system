@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2 bg-dark">
                @include('_parts.t_sidebar')
            </div>
            <div class="col-sm-10 pt-5">
                <div class="card mt-5">
                    <div class="card-header"><strong>{{$title['title']}}</strong></div>
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
        
                                <a href="/newticket" class="btn btn-sm btn-primary my-1">Create ticket</a>
        
                                @include('_parts.t_search')
        
                                @include('_parts.t_table')
        
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection