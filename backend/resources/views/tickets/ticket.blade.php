@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')
    <div class="container mt-5 pt-5">
        <div class="card">
            @foreach($tickets as $ticket)
                <div class="card-header bg-dark text-light">
                    <strong>Ticket #{{$ticket->t_id}}</strong> 
                    @if($days > 3 && $ticket->t_resolveddate == NULL)
                        <strong>  (TICKET IS OVERDUE)</strong>
                    @endif
                </div>
            @endforeach
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
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header"><strong>Ticket Details</strong></div>
                                <div class="card-body">
                                    @foreach($tickets as $ticket)
                                        <div class="mb-3">
                                            <label for="t_title" class="form-label">
                                                <strong>{{$ticket->t_title}}</strong>
                                            </label>
                                        </div>

                                        <div class="mb-0">
                                            <p>{{$ticket->t_description}}</p>
                                        </div>

                                        <hr>

                                        <div class="mb-0">
                                            <strong>Category:</strong> {{$ticket->c_description}}
                                        </div>

                                        <div class="mb-1">
                                            <strong>Requested by:</strong> {{$ticket->u_fname}} {{$ticket->u_lname}}
                                        </div>

                                        <div class="mb-1">
                                            <strong>Severity:</strong> {{$ticket->t_severity}}
                                        </div>

                                        <div class="mb-1">
                                            <strong>Assigned to:</strong> @if($assignedto){{$assignedto->u_fname}} {{$assignedto->u_lname}}@endif
                                        </div>

                                        <div class="mb-0">
                                            <strong>Resolution Time:</strong> {{$days}}:{{$hours}}:{{$minutes}}:{{$seconds}}
                                        </div>

                                        @if($ticket->t_createdby == Auth::user()->id)
                                            @if($ticket->t_status == 1 || $ticket->t_status == 2)
                                                <a href="/ticket/{{$ticket->t_id}}/editticket" class="btn btn-sm btn-primary my-1">Edit</a>
                                            @endif
                                        @endif

                                        @if($ticket->t_status == 1 || $ticket->t_status == 2 || $ticket->t_status == 3 || $ticket->t_status == 4)
                                            <button type="submit" class="btn btn-sm btn-danger my-3" data-bs-toggle="modal" data-bs-target="#cancellationReason" onclick="disablebtn()">Cancel Ticket</button>
                                        @endif

                                        @if($ticket->t_severity != NULL)
                                            @if(Auth::user()->u_role == 1)
                                                @if($ticket->t_status == 3)
                                                    <form action="/acknowledge" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="t_id" value="{{$ticket->t_id}}">
                                                        <button type="submit" class="btn btn-sm btn-primary" onclick="disablebtn()">Acknowledge</button>
                                                    </form>
                                                @endif
                                            @endif
                                        @endif

                                        @foreach($tickets as $ticket)
                                            @if(($ticket->t_status == 5))
                                                <form action="/close" method="post">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="t_id" value="{{$ticket->t_id}}">
                                                    <div class="my-3">
                                                        <button class="btn btn-sm btn-warning" onclick="disablebtn()">Close Ticket</button>
                                                    </div>
                                                </form>
                                            @endif
                                        @endforeach
                                        
                                    @endforeach
                                </div>
                            </div>
                            
                        </div>

                        <div class="col-md-8">
                            @foreach($tickets as $ticket)
                                @if(Auth::user()->u_role == 1)
                                    @if($ticket->t_status == 1 || $ticket->t_status == 2 || $ticket->t_status == 3)
                                        @if($ticket->t_severity < 1)
                                            <form action="/ticket/{{$ticket->t_id}}/setseverity" method="post">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="t_id" class="form-control" value="{{$ticket->t_id}}">
                                                <label for="t_severity"><small>Severity</small></label>
                                                <select name="t_severity" class="form-select" id="t_severity" class="mt-3">
                                                    <option value="">Not set</option>
                                                    @foreach($severities as $severity)
                                                        <option value="{{$severity->s_id}}">{{$severity->s_title}} {{$severity->s_description}}</option>
                                                    @endforeach
                                                </select>
                                                <button class="btn btn-sm btn-primary my-3" onclick="disablebtn()">Set</button>
                                            </form>
                                        @endif
                                    @endif
                                @endif

                                @if($ticket->t_severity != NULL)                                        
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
                                                <button class="btn btn-sm btn-success my-3" onclick="disablebtn()">Assign</button>
                                            </form>
                                        @endif
                                    @endif
                                @endif

                                @foreach($tickets as $ticket)
                                    @if(($ticket->t_status == 7))
                                        <div class="card mb-3">
                                            <div class="card-header">Cancelled</div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label for="t_cancellationreason" class="form-label h6"><strong>Cancellation Reason</strong></label>
                                                    <p>{{$ticket->t_cancelreason}}</p>
                                                    <p><strong>Cancelled by: </strong>{{$cancelledby->u_fname}} {{$cancelledby->u_lname}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endforeach

                            @foreach($tickets as $ticket)
                                @if(Auth::user()->u_role == 1 && $ticket->t_status == 4 && $ticket->t_todepartment == Auth::user()->u_department)
                                    @include('_parts.t_resolution')
                                @endif
                            @endforeach

                            @if(($ticket->t_status == 5 || $ticket->t_status == 6))
                                <div class="card mb-3">
                                    <div class="card-header">Resolution</div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <div class="card mb-3">
                                                <div class="card-body">
                                                    <small class="small">{{$ticket->t_resolution}}</small>
                                                </div>
                                            </div>
                                            <p><strong>Resolved by: </strong>{{$resolvedby->u_fname}} {{$resolvedby->u_lname}}</p>
                                            <p><strong>Date Resolved: </strong>{{$ticket->t_resolveddate}}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            @include('_parts.t_comments')
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="card">
                                <div class="card-header"><strong>Files</strong></div>
                                <div class="card-body">
                                    @foreach($filtered as $file)
                                        <a href="/download/{{$file}}" class="btn btn-sm btn-secondary mb-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to download file">{{$file}}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-footer">
                @foreach($tickets as $ticket)
                    <div class="progress" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Testing">
                        <div
                            @switch($ticket->t_status)
                                @case('1')
                                    class="progress-bar bg-dark progress-bar-striped progress-bar-animated" 
                                    style="width: 10%"
                                    @break
                                @case('2')
                                    class="progress-bar bg-primary progress-bar-striped progress-bar-animated" 
                                    style="width: 20%"
                                    @break
                                @case('3')
                                    class="progress-bar bg-info progress-bar-striped progress-bar-animated" 
                                    style="width: 40%"
                                    @break
                                @case('4')
                                    class="progress-bar bg-warning progress-bar-striped progress-bar-animated" 
                                    style="width: 60%"
                                    @break
                                @case('5')
                                    class="progress-bar bg-success progress-bar-striped progress-bar-animated" 
                                    style="width: 80%"
                                    @break
                                @case('6')
                                    class="progress-bar bg-dark progress-bar progress-bar" 
                                    style="width: 100%"
                                    @break
                                @case('7')
                                    class="progress-bar bg-danger progress-bar progress-bar"
                                    style="width: 100%"
                                    @break
                                @default
                                    class="progress-bar bg-secondary progress-bar progress-bar"
                                    style="width: 0%"
                            @endswitch
                        >
                            <strong>
                                @switch($ticket->t_status)
                                    @case('1')
                                        New
                                        @break
                                    @case('2')
                                        Viewed
                                        @break
                                    @case('3')
                                        Assigned
                                        @break
                                    @case('4')
                                        Resolving
                                        @break
                                    @case('5')
                                        Resolved
                                        @break
                                    @case('6')
                                        Closed-Resolved
                                        @break
                                    @case('7')
                                        Cancelled
                                        @break
                                    @default
                                        Unknown
                                @endswitch
                            </strong>
                        </div>
                    </div>
                @endforeach
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
                        <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="disablebtn()"></button>
                    </div>
            
                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="/cancel" method="post">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="t_id" value="{{$ticket->t_id}}" class="form-control">
                            <label for="t_cancelreason" class="form-label h6">Reason: </label>
                            <textarea name="t_cancelreason" id="t_cancelreason" class="form-control" required></textarea>
                            <button type="submit" class="btn btn-sm btn-danger my-3 float-end" onclick="disablebtn()">Cancel Ticket</button>
                        </form>
                    </div>
            
                </div>
            </div>
        </div>
    @endforeach

    <script>
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
          return new bootstrap.Popover(popoverTriggerEl)
        })
    </script>
@endsection