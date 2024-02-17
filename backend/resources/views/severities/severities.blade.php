@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')
    <div class="container d-flex justify-content-center align-items-center my-5 py-5">
        <div class="card">
            <div class="card-header bg-dark text-light" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Severity"><strong>Severities | <a href="/newseverity" class="btn btn-sm btn-primary"><i class="bi bi-plus-circle"></i></a></strong></div>
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

                <table class="table table-sm table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Severity</th>
                            <th>Description</th>
                            <th>Response Time</th>
                            <th>Resolution Time</th>
                            <th>Escalation Time</th>
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
                                <td>{{$severity->s_responsetime}}</td>
                                <td>{{$severity->s_resolutiontime}}</td>
                                <td>{{$severity->s_escalationtime}}</td>
                                <td>
                                    @if($severity->s_status == 1)
                                        Active
                                    @else
                                        Disabled
                                    @endif
                                </td>
                                <td>
                                    <a href="/severity/{{$severity->s_id}}" class="btn btn-sm btn-primary">edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection