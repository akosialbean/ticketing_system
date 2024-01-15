@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header"><strong>Ticket</strong></div>
            <div class="card-body">
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

                    @foreach($data as $ticket)
                        <div class="mb-3">
                            <label for="t_title" class="form-label h1">
                                Ticket #{{$ticket->t_id}} -
                                @if($ticket->t_status == 1)
                                    New
                                @elseif($ticket->t_status == 2)
                                    Open
                                @elseif($ticket->t_status == 3)
                                    Acknowledged
                                @elseif($ticket->t_status == 4)
                                    Resolved
                                @elseif($ticket->t_status == 5)
                                    Closed
                                @elseif($ticket->t_status == 6)
                                    Cancelled
                                @endif
                            </label>
                        </div>

                        <div class="mb-3">
                            <label for="t_title" class="form-label h2">{{$ticket->t_title}}</label>
                        </div>

                        <div class="mb-3">
                            <p>{{$ticket->t_description}}</p>
                        </div>

                        <div class="mb-3">
                            <p>Category: {{$ticket->c_description}}</p>
                        </div>

                        <div class="mb-3">
                            <p>Requested by: {{$ticket->u_fname}} {{$ticket->u_lname}}</p>
                        </div>

                        <div class="mb-3">
                            @if(($ticket->t_status == 2))
                                <form action="/acknowledge" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="t_id" value="{{$ticket->t_id}}">
                                    <button type="submit" class="btn btn-sm btn-primary">Acknowledge</button>
                                </form>
                            @endif
                        </div>

                        <hr>

                        @if($ticket->t_status == 3)
                            <div class="mb-3">
                                <label for="t_resolution" class="form-label">Resolution</label>
                                <textarea name="t_resolution" id="t_resolution" class="form-control"></textarea>
                                <div class="mt-3">
                                    <button class="btn btn-sm btn-success">Resolve</button>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection