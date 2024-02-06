<div class="table-responsive">
    <table class="table table-sm table-hover table-striped table-bordered my-0">
        <thead>
            <tr>
                <th class="small">
                    @switch($order)
                        @case("asc")
                            <a href="/{{Auth::user()->u_department}}/tickets/{{$myticket}}/t_id/desc" class="btn btn-sm small w-100"><strong># <i class="bi bi-sort-numeric-down"></i></strong></a>  
                        @break
                        @default
                            <a href="/{{Auth::user()->u_department}}/tickets/{{$myticket}}/t_id/asc" class="btn btn-sm small w-100"><strong># <i class="bi bi-sort-numeric-up"></i></strong></a>                        
                    @endswitch
                </th>
                <th class="small">
                    @switch($order)
                        @case("asc")
                            <a href="/{{Auth::user()->u_department}}/tickets/{{$myticket}}/t_title/desc" class="btn btn-sm small w-100"><strong>Title <i class="bi bi-sort-alpha-down"></i></strong></a>
                        @break
                        @default
                            <a href="/{{Auth::user()->u_department}}/tickets/{{$myticket}}/t_title/asc" class="btn btn-sm small w-100"><strong>Title <i class="bi bi-sort-alpha-up"></i></strong></a>
                    @endswitch
                </th>
                <th class="small">
                    @switch($order)
                        @case("asc")
                            <a href="/{{Auth::user()->u_department}}/tickets/{{$myticket}}/d_code/desc" class="btn btn-sm small w-100"><strong>Department <i class="bi bi-sort-alpha-down"></i></strong></a>
                        @break
                        @default
                            <a href="/{{Auth::user()->u_department}}/tickets/{{$myticket}}/d_code/asc" class="btn btn-sm small w-100"><strong>Department <i class="bi bi-sort-alpha-up"></i></strong></a>
                    @endswitch
                </th>
                <th class="small">
                    @switch($order)
                        @case("asc")
                            <a href="/{{Auth::user()->u_department}}/tickets/{{$myticket}}/t_createdby/desc" class="btn btn-sm small w-100"><strong>Created By <i class="bi bi-sort-alpha-down"></i></strong></a>
                        @break
                        @default
                            <a href="/{{Auth::user()->u_department}}/tickets/{{$myticket}}/t_createdby/asc" class="btn btn-sm small w-100"><strong>Created By <i class="bi bi-sort-alpha-up"></i></strong></a>
                    @endswitch
                </th>
                <th class="small">
                    @switch($order)
                        @case("asc")
                            <a href="/{{Auth::user()->u_department}}/tickets/{{$myticket}}/created_at/desc" class="btn btn-sm small w-100"><strong>Date <i class="bi bi-sort-numeric-down"></i></strong></a>
                        @break
                        @default
                            <a href="/{{Auth::user()->u_department}}/tickets/{{$myticket}}/created_at/asc" class="btn btn-sm small w-100"><strong>Date <i class="bi bi-sort-numeric-up"></i></strong></a>
                    @endswitch
                </th>
                {{-- <th class="small">
                    <a class="btn btn-sm small w-100"><strong>Assigned To <i class="bi bi-sort-alpha-up"></i></strong></a>
                </th> --}}
                <th class="small">
                    @switch($order)
                        @case("asc")
                            <a href="/{{Auth::user()->u_department}}/tickets/{{$myticket}}/t_severity/desc" class="btn btn-sm small w-100"><strong>Severity <i class="bi bi-sort-numeric-down"></i></strong></a>
                        @break
                        @default
                            <a href="/{{Auth::user()->u_department}}/tickets/{{$myticket}}/t_severity/asc" class="btn btn-sm small w-100"><strong>Severity <i class="bi bi-sort-numeric-up"></i></strong></a>
                    @endswitch
                </th>
                <th class="small">
                    @switch($order)
                        @case("asc")
                            <a href="/{{Auth::user()->u_department}}/tickets/{{$myticket}}/t_status/desc" class="btn btn-sm small w-100"><strong>Status <i class="bi bi-sort-alpha-down"></i></strong></a>
                        @break
                        @default
                            <a href="/{{Auth::user()->u_department}}/tickets/{{$myticket}}/t_status/asc" class="btn btn-sm small w-100"><strong>Status <i class="bi bi-sort-alpha-up"></i></strong></a>
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
                    {{-- <td class="small"><small>{{$ticket->t_assignedto}}</small></td> --}}
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

<div class="d-flex justify-content-center py-0">
    {{$tickets->links()}}
</div>