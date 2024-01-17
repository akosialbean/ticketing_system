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

                    @foreach($getTicket as $ticket)
                        <div class="mb-3">
                            <label for="t_title" class="form-label h1">
                                #{{$ticket->t_id}}
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
                            @if(Auth::user()->u_role == 1)
                                @if($ticket->t_status == 2)
                                    <form action="/acknowledge" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="t_id" value="{{$ticket->t_id}}">
                                        <button type="submit" class="btn btn-sm btn-primary">Acknowledge</button>
                                    </form>
                                @endif
                            @endif

                            @if($ticket->t_status == 1 || $ticket->t_status == 2 || $ticket->t_status == 3)
                                <button type="submit" class="btn btn-sm btn-danger my-3" data-bs-toggle="modal" data-bs-target="#cancellationReason">Cancel Ticket</button>
                            @endif

                            <hr>

                            <p><Strong class="h3">History</Strong></p>
                            <p><strong>Created by: </strong>{{$createdby->u_fname}} {{$createdby->u_lname}}</p>
                            <p><strong>Opened by: </strong>{{$openedby->u_fname}} {{$openedby->u_lname}}</p>
                            <p><strong>Acknowleged by: </strong>{{$acknowledgedby->u_fname}} {{$acknowledgedby->u_lname}}</p>
                            <p><strong>Resolved by: </strong>{{$resolvedby->u_fname}} {{$resolvedby->u_lname}}</p>
                            <p><strong>Closed by: </strong>{{$closedby->u_fname}} {{$closedby->u_lname}}</p>
                            <p><strong>Cancelled by: </strong>{{$cancelledby->u_fname}} {{$cancelledby->u_lname}}</p>
                        </div>

                        <hr>

                        @if(Auth::user()->u_role == 1)
                            @if($ticket->t_status == 3)
                                <div class="mb-3">
                                    <form action="/resolve" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="t_id" value="{{$ticket->t_id}}">
                                        <label for="t_resolution" class="form-label">Resolution</label>
                                        <textarea name="t_resolution" id="t_resolution" class="form-control" required></textarea>
                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-sm btn-success">Resolve</button>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        @endif

                        @if(($ticket->t_status == 4 || $ticket->t_status == 5))
                            <div class="mb-3">
                                <label for="t_title" class="form-label h2">Resolution</label>
                                <p>{{$ticket->t_resolution}}</p>
                                <p><strong>Resolved by: </strong>{{$resolvedby->u_fname}} {{$resolvedby->u_lname}}</p>
                                <p><strong>Date Resolved: </strong>{{$ticket->t_resolveddate}}</p>
                            </div>
                        @endif

                        @if(($ticket->t_status == 4))
                            <form action="/close" method="post">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="t_id" value="{{$ticket->t_id}}">
                                <div class="mt-3">
                                    <button class="btn btn-sm btn-warning">Close Ticket</button>
                                </div>
                            </form>
                        @endif

                        @if(($ticket->t_status == 6))
                            <div class="mb-3">
                                <label for="t_cancellationreason" class="form-label h6"><strong>Cancellation Reason</strong></label>
                                <p>{{$ticket->t_cancelreason}}</p>
                                <p><strong>Cancelled by: </strong>{{$cancelledby->u_fname}} {{$cancelledby->u_lname}}</p>
                            </div>
                        @endif

                        <a href="/alltickets" class="btn btn-sm btn-danger">Back</a>

                    @endforeach
                </div>
            </div>
        </div>
    </div>


    <!-- The Modal -->
    @foreach($getTicket as $ticket)
        <div class="modal" id="cancellationReason">
            <div class="modal-sm modal-dialog modal-dialog-centered">
                <div class="modal-content">
            
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Cancel Ticket #{{$ticket->t_id}}?</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
            
                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="/cancel" method="post">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="t_id" value="{{$ticket->t_id}}" class="form-control">
                            <label for="t_cancelreason" class="form-label h6">Reason: </label>
                            <textarea name="t_cancelreason" id="t_cancelreason" class="form-control" required></textarea>
                            <button type="submit" class="btn btn-sm btn-danger my-3 float-end">Cancel Ticket</button>
                        </form>
                    </div>
            
                </div>
            </div>
        </div>
    @endforeach
@endsection