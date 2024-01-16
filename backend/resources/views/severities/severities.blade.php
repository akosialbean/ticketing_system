@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 9vh;">
        <div class="card">
            <div class="card-header"><strong>Severities</strong></div>
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

                <table class="table table-sm table-hover table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Severity</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($get as $severity)
                            <tr>
                                <td>{{$severity->s_id}}</td>
                                <td>{{$severity->s_title}}</td>
                                <td>{{$severity->s_description}}</td>
                                <td>{{$severity->s_status}}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary">edit</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection