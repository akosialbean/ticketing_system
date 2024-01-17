@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')
    <div class="container mt-3">
        <div class="card">
            <div class="card-header">Tickets</div>
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

                <a href="/newticket" class="btn btn-sm btn-primary my-3">Create ticket</a>
                
                <table class="table table-sm table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Department</th>
                            <th>Created by</th>
                            <th>Date Created</th>
                            <th>Severity</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($alltickets as $tickets)
                        <tr>
                            <td><small>{{$tickets->t_id}}</small></td>
                            <td><small>{{$tickets->t_title}}</small></td>
                            <td><small>{{$tickets->d_code}}</small></td>
                            <td><small>{{$tickets->u_fname}} {{$tickets->u_lname}}</small></td>
                            <td><small>{{$tickets->created_at}}</small></td>
                            <td><small>{{$tickets->s_title}}</small></td>
                            <td><small>
                                @if($tickets->t_status == 1)
                                    New
                                @elseif($tickets->t_status == 2)
                                    Opened
                                @elseif($tickets->t_status == 3)
                                    Acknowledged
                                @elseif($tickets->t_status == 4)
                                    Resolved
                                @elseif($tickets->t_status == 5)
                                    Closed
                                @else
                                    Cancelled
                                @endif
                            </small></td>
                            <td>
                                @if($tickets->t_status == 1)
                                    <form action="/openticket" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="t_id" value="{{$tickets->t_id}}">
                                        <button type="submit" class="btn btn-sm btn-info">view</button>
                                    </form>
                                @else
                                    <a href="/ticket/{{$tickets->t_id}}" class="btn btn-sm btn-primary">
                                        view
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {{$alltickets->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection