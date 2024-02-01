<div class="table-responsive">
    <table class="table table-sm table-hover table-striped table-bordered">
        <thead>
            <tr>
                <th class="small">
                    @switch($pageid)
                        @case(2)
                            <a href="/tickets" class="btn btn-sm small w-100"><strong># <i class="bi bi-sort-numeric-down"></i></strong></a>  
                        @break
                        @default
                            <a href="/tickets/id/asc" class="btn btn-sm small w-100"><strong># <i class="bi bi-sort-numeric-up"></i></strong></a>                        
                    @endswitch
                </th>
                <th class="small">
                    @switch($pageid)
                        @case(3)
                            <a href="/tickets/title/desc" class="btn btn-sm small w-100"><strong>Title <i class="bi bi-sort-alpha-down"></i></strong></a>
                        @break
                        @default
                            <a href="/tickets/title/asc" class="btn btn-sm small w-100"><strong>Title <i class="bi bi-sort-alpha-up"></i></strong></a>
                    @endswitch
                </th>
                <th class="small">
                    @switch($pageid)
                        @case(5)
                            <a href="/tickets/dept/desc" class="btn btn-sm small w-100"><strong>Department <i class="bi bi-sort-alpha-down"></i></strong></a>
                        @break
                        @default
                            <a href="/tickets/dept/asc" class="btn btn-sm small w-100"><strong>Department <i class="bi bi-sort-alpha-up"></i></strong></a>
                    @endswitch
                </th>
                <th class="small">
                    @switch($pageid)
                        @case(7)
                            <a href="/tickets/createdby/desc" class="btn btn-sm small w-100"><strong>Created By <i class="bi bi-sort-alpha-down"></i></strong></a>
                        @break
                        @default
                            <a href="/tickets/createdby/asc" class="btn btn-sm small w-100"><strong>Created By <i class="bi bi-sort-alpha-up"></i></strong></a>
                    @endswitch
                </th>
                <th class="small">
                    @switch($pageid)
                        @case(9)
                            <a href="/tickets/date/desc" class="btn btn-sm small w-100"><strong>Date <i class="bi bi-sort-numeric-down"></i></strong></a>
                        @break
                        @default
                            <a href="/tickets/date/asc" class="btn btn-sm small w-100"><strong>Date <i class="bi bi-sort-numeric-up"></i></strong></a>
                    @endswitch
                </th>
                <th class="small"><button class="btn btn-sm small w-100"><strong>Assigned To <i class="bi bi-sort-alpha-up"></i></strong></button></th>
                <th class="small">
                    @switch($pageid)
                        @case(11)
                            <a href="/tickets/sev/desc" class="btn btn-sm small w-100"><strong>Severity <i class="bi bi-sort-numeric-down"></i></strong></a>
                        @break
                        @default
                            <a href="/tickets/sev/asc" class="btn btn-sm small w-100"><strong>Severity <i class="bi bi-sort-numeric-up"></i></strong></a>
                    @endswitch
                </th>
                <th class="small">
                    @switch($pageid)
                        @case(13)
                            <a href="/tickets/status/desc" class="btn btn-sm small w-100"><strong>Status <i class="bi bi-sort-alpha-down"></i></strong></a>
                        @break
                        @default
                            <a href="/tickets/status/asc" class="btn btn-sm small w-100"><strong>Status <i class="bi bi-sort-alpha-up"></i></strong></a>
                    @endswitch
                </th>
                <th class="small"></th>
            </tr>
        </thead>

        <tbody>
            @if($tickets)
                @foreach($tickets as $ticket)
                <tr>
                    <td class="small"><small>{{$ticket->t_id}}</small></td>
                    <td class="small"><small>{{$ticket->t_title}}</small></td>
                    <td class="small"><small>{{$ticket->d_code}}</small></td>
                    <td class="small"><small>{{$ticket->u_fname}} {{$ticket->u_lname}}</small></td>
                    <td class="small"><small>{{$ticket->created_at}}</small></td>
                    <td class="small"><small>{{$ticket->t_assignedto}}</small></td>
                    <td class="small"><small>{{$ticket->t_severity}}</small></td>
                    <td class="small"><small>
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
                                Acknowledged
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