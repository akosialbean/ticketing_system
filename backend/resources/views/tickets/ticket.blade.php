@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')
    <div class="container my-5 pt-5">
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

                    @foreach($tickets as $ticket)
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
                            <p>Severity: {{$ticket->t_severity}}</p>
                        </div>

                        <div class="mb-3">
                            <p>Assigned to: @if($assignedto){{$assignedto->u_fname}} {{$assignedto->u_lname}}@endif</p>
                        </div>

                        <div class="mb-3">
                            @if($ticket->t_createdby == Auth::user()->id)
                                @if($ticket->t_status == 1 || $ticket->t_status == 2)
                                    <a href="/ticket/{{$ticket->t_id}}/editticket" class="btn btn-sm btn-primary my-3">Edit</a>
                                @endif
                            @endif

                            @if(Auth::user()->u_role == 1)
                                @if($ticket->t_status == 1 || $ticket->t_status == 2 || $ticket->t_status == 3)
                                    @if($ticket->t_severity < 1)
                                        <hr>

                                        <form action="/ticket/{{$ticket->t_id}}/setseverity" method="post">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="t_id" class="form-control" value="{{$ticket->t_id}}">
                                            <label for="t_severity"><small>Severity</small></label>
                                            <select name="t_severity" class="form-select" id="t_severity" class="mt-3">
                                                <option value="">Not set</option>
                                                @foreach($severities as $severity)
                                                    <option value="{{$severity->s_id}}">{{$severity->s_description}}</option>
                                                @endforeach
                                            </select>
                                            <button class="btn btn-sm btn-primary my-3">Set</button>
                                        </form>
                                        
                                        <hr>
                                    @endif
                                @endif
                            @endif

                            @if(Auth::user()->u_role == 1)
                                @if($ticket->t_status == 3)
                                    <form action="/acknowledge" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="t_id" value="{{$ticket->t_id}}">
                                        <button type="submit" class="btn btn-sm btn-primary">Acknowledge</button>
                                    </form>
                                @endif
                            @endif
                                
                            @if(Auth::user()->u_role == 1)
                                @if($ticket->t_status == 1 || $ticket->t_status == 2)
                                    <form action="/ticket/{{$ticket->t_id}}/assignto" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="t_id" value="{{$ticket->t_id}}">
                                        <label for="t_assignedto"><small>Assign to:</small></label>
                                        <select name="t_assignedto" id="t_assignedto" class="form-select">
                                            <option value="">--</option>
                                            @foreach($resolvers as $resolver)
                                                <option value="{{$resolver->id}}">{{$resolver->u_fname}} {{$resolver->u_lname}}</option>
                                            @endforeach
                                        </select>
                                        <button class="btn btn-sm btn-success my-3">Assign</button>
                                    </form>
                                @endif
                            @endif
                            

                            @if($ticket->t_status == 1 || $ticket->t_status == 2 || $ticket->t_status == 3 || $ticket->t_status == 4)
                                <button type="submit" class="btn btn-sm btn-danger my-3" data-bs-toggle="modal" data-bs-target="#cancellationReason">Cancel Ticket</button>
                            @endif

                        </div>

                        <hr>

                        @if(Auth::user()->u_role == 1 && $ticket->t_status == 4)
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

                        @if(($ticket->t_status == 5 || $ticket->t_status == 6))
                            <div class="mb-3">
                                <label for="t_title" class="form-label h2">Resolution</label>
                                <p>{{$ticket->t_resolution}}</p>
                                <p><strong>Resolved by: </strong>{{$resolvedby->u_fname}} {{$resolvedby->u_lname}}</p>
                                <p><strong>Date Resolved: </strong>{{$ticket->t_resolveddate}}</p>
                            </div>
                        @endif

                        @if(($ticket->t_status == 5))
                            <form action="/close" method="post">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="t_id" value="{{$ticket->t_id}}">
                                <div class="my-3">
                                    <button class="btn btn-sm btn-warning">Close Ticket</button>
                                </div>
                            </form>
                        @endif

                        @if(($ticket->t_status == 7))
                            <div class="mb-3">
                                <label for="t_cancellationreason" class="form-label h6"><strong>Cancellation Reason</strong></label>
                                <p>{{$ticket->t_cancelreason}}</p>
                                <p><strong>Cancelled by: </strong>{{$cancelledby->u_fname}} {{$cancelledby->u_lname}}</p>
                            </div>
                        @endif

                        <a href="/tickets" class="btn btn-sm btn-danger">Back</a>

                    @endforeach
                </div>

                <hr>

                <table class="table table-sm table-hover table-stripped">
                    <thead>
                        <tr>
                            <th colspan="4" class="text-center h3">History</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th><small>Name</small></th>
                            <th><small>Dates</small></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th><small>Created by</small></th>
                            <td><small>{{$createdby->u_fname}} {{$createdby->u_lname}}</small></td>
                            <td><small>{{$createdby->created_at}}</small></td>
                        </tr>
                        <tr>
                            <th><small>Viewed by</small></th>
                            <td><small>{{$openedby->u_fname}} {{$openedby->u_lname}}</small></td>
                            <td><small>{{$openedby->t_dateopened}}</small></td>
                        </tr>
                        <tr>
                            <th><small>Assigned to</small></th>
                            @if($assignedto)
                                <td><small>{{$assignedto->u_fname}} {{$assignedto->u_lname}}</small></td>
                                <td><small>{{$assignedto->created_at}}</small></td>
                            @endif
                        </tr>
                        <tr>
                            <th><small>Acknowledged by</small></th>
                            <td><small>{{$acknowledgedby->u_fname}} {{$acknowledgedby->u_lname}}</small></td>
                            <td><small>{{$acknowledgedby->t_acknowledgeddate}}</small></td>
                        </tr>
                        <tr>
                            <th><small>Resolved by</small></th>
                            <td><small>{{$resolvedby->u_fname}} {{$resolvedby->u_lname}}</small></td>
                            <td><small>{{$resolvedby->t_resolveddate}}</small></td>
                        </tr>
                        <tr>
                            <th><small>Closed by</small></th>
                            <td><small>{{$closedby->u_fname}} {{$closedby->u_lname}}</small></td>
                            <td><small>{{$closedby->t_closeddate}}</small></td>
                        </tr>
                        <tr>
                            <th><small>Cancelled by</small></th>
                            <td><small>{{$cancelledby->u_fname}} {{$cancelledby->u_lname}}</small></td>
                            <td><small>{{$cancelledby->t_cancelleddate}}</small></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- The Modal -->
    @foreach($tickets as $ticket)
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