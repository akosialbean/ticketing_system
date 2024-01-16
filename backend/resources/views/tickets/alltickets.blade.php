@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')
    <div class="container">
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
                    <th>Title</th>
                    <th>Created by</th>
                    <th>Severity</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach($alltickets as $tickets)
                <tr>
                    <td>{{$tickets->t_id}}</td>
                    <td>{{$tickets->t_title}}</td>
                    <td>{{$tickets->t_description}}</td>
                    <td>{{$tickets->t_createdby}}</td>
                    <td>{{$tickets->t_severity}}</td>
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
    </div>
@endsection