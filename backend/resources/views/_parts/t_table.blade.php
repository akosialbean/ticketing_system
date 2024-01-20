<div class="table-responsive">
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
            @if($tickets)
                @foreach($tickets as $ticket)
                <tr>
                    <td><small>{{$ticket->t_id}}</small></td>
                    <td><small>{{$ticket->t_title}}</small></td>
                    <td><small>{{$ticket->d_description}}</small></td>
                    <td><small>{{$ticket->u_fname}} {{$ticket->u_lname}}</small></td>
                    <td><small>{{$ticket->created_at}}</small></td>
                    <td><small>{{$ticket->t_severity}}</small></td>
                    <td><small>
                        @if($ticket->t_status == 1)
                            New
                        @elseif($ticket->t_status == 2)
                            Opened
                        @elseif($ticket->t_status == 3)
                            Acknowledged
                        @elseif($ticket->t_status == 4)
                            Resolved
                        @elseif($ticket->t_status == 5)
                            Closed
                        @else
                            Cancelled
                        @endif
                    </small></td>
                    <td>
                        @if($ticket->t_status == 1)
                            <form action="/openticket" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="t_id" value="{{$ticket->t_id}}">
                                <button type="submit" class="btn btn-sm btn-info"><i class="bi bi-three-dots-vertical"></i></button>
                            </form>
                        @else
                            <a href="/ticket/{{$ticket->t_id}}" class="btn btn-sm btn-primary"><i class="bi bi-three-dots-vertical"></i>
                            </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8"><small>No data...</small></td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-center">
    {{$tickets->links()}}
</div>