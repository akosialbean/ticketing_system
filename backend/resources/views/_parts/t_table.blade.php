<div class="table-responsive-sm">
    <table class="table table-sm table-hover table-striped table-bordered my-0">
        <thead>
            <tr>
                <th class="small">
                    @switch($order)
                        @case("asc")
                            <a href="/{{Auth::user()->u_department}}/tickets/{{$myticket}}/ticketid/desc" class="btn btn-sm small w-100"><strong># <i class="bi bi-sort-numeric-down"></i></strong></a>  
                        @break
                        @default
                            <a href="/{{Auth::user()->u_department}}/tickets/{{$myticket}}/ticketid/asc" class="btn btn-sm small w-100"><strong># <i class="bi bi-sort-numeric-up"></i></strong></a>                        
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
                            <a href="/{{Auth::user()->u_department}}/tickets/{{$myticket}}/d_code/desc" class="btn btn-sm small w-100"><strong>From <i class="bi bi-sort-alpha-down"></i></strong></a>
                        @break
                        @default
                            <a href="/{{Auth::user()->u_department}}/tickets/{{$myticket}}/d_code/asc" class="btn btn-sm small w-100"><strong>From <i class="bi bi-sort-alpha-up"></i></strong></a>
                    @endswitch
                </th>
                <th class="small">
                    @switch($order)
                        @case("asc")
                            <a href="/{{Auth::user()->u_department}}/tickets/{{$myticket}}/creator/desc" class="btn btn-sm small w-100"><strong>Created By <i class="bi bi-sort-alpha-down"></i></strong></a>
                        @break
                        @default
                            <a href="/{{Auth::user()->u_department}}/tickets/{{$myticket}}/creator/asc" class="btn btn-sm small w-100"><strong>Created By <i class="bi bi-sort-alpha-up"></i></strong></a>
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
                <th class="small">
                    @switch($order)
                        @case("asc")
                            <a href="/{{Auth::user()->u_department}}/tickets/{{$myticket}}/assignedto/desc" class="btn btn-sm small w-100"><strong>Assigned To <i class="bi bi-sort-numeric-down"></i></strong></a>
                        @break
                        @default
                            <a href="/{{Auth::user()->u_department}}/tickets/{{$myticket}}/assignedto/asc" class="btn btn-sm small w-100"><strong>Assigned To <i class="bi bi-sort-numeric-up"></i></strong></a>
                    @endswitch
                </th>
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
                            <a href="/{{Auth::user()->u_department}}/tickets/{{$myticket}}/ticketStatus/desc" class="btn btn-sm small w-100"><strong>Status <i class="bi bi-sort-alpha-down"></i></strong></a>
                        @break
                        @default
                            <a href="/{{Auth::user()->u_department}}/tickets/{{$myticket}}/ticketStatus/asc" class="btn btn-sm small w-100"><strong>Status <i class="bi bi-sort-alpha-up"></i></strong></a>
                    @endswitch
                </th>
                <th class="small"></th>
            </tr>
        </thead>

        <tbody class="table-group-divider">
            @if($tickets)
                @foreach($tickets as $ticket)
                    <tr
                        @if($ticket->overdue > 5 && $ticket->t_severity == 1 && $ticket->t_resolveddate == NULL && $ticket->t_cancelleddate == NULL)
                            class="table-danger"
                        @elseif($ticket->overdue > 5 && $ticket->t_severity == 2 && $ticket->t_resolveddate == NULL && $ticket->t_cancelleddate == NULL)
                            class="table-danger"
                        @elseif($ticket->overdue > 3 && $ticket->t_severity == 3 && $ticket->t_resolveddate == NULL && $ticket->t_cancelleddate == NULL)
                            class="table-danger"
                        @elseif($ticket->overdue > 1 && $ticket->t_severity == 4 && $ticket->t_resolveddate == NULL && $ticket->t_cancelleddate == NULL)
                            class="table-danger"
                        @elseif($ticket->overdue > 1 && $ticket->t_severity == 5 && $ticket->t_resolveddate == NULL && $ticket->t_cancelleddate == NULL)
                            class="table-danger"
                        @elseif($ticket->overdue > 7 && $ticket->t_severity == 0 && $ticket->t_resolveddate == NULL && $ticket->t_cancelleddate == NULL)
                            class="table-danger"
                        @endif
                        data-bs-toggle="tooltip" data-bs-placement="top" title="{{$ticket->t_description}}"
                    >
                        <td class="small text-center"><small>{{$ticket->ticketid}}</small></td>
                        <td class="small"><small>{{$ticket->t_title}}</small></td>
                        <td class="small text-center"><small>{{$ticket->d_code}}</small></td>
                        <td class="small text-center"><small>{{$ticket->creator}}</small></td>
                        <td class="small text-center"><small>{{$ticket->created_at}}</small></td>
                        <td class="small text-center"><small>{{$ticket->assignedto}}</small></td>
                        <td class="small text-center"><small>{{$ticket->t_severity}}</small></td>
                        <td class="small text-center"><small>{{$ticket->ticketStatus}}</small></td>
                        <td class="small text-center">
                            @if($ticket->ticketStatus == 'New' && Auth::user()->u_role == 1)
                                <form action="/openticket" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="t_id" value="{{$ticket->ticketid}}">
                                    <button type="submit" class="btn btn-sm btn-info" onclick="disablebtn()"><i class="bi bi-three-dots-vertical"></i></button>
                                </form>
                            @else
                                <a href="/ticket/{{$ticket->ticketid}}" class="btn btn-sm" onclick="disablebtn()"><i class="bi bi-three-dots-vertical"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="9" class="text-center">
                        <strong>
                            @switch($myticket)
                                @case('newtickets')
                                    You don't have a new Ticket...
                                    @break
                                @case('overduetickets')
                                    You don't have any verdued Tickets...
                                    @break
                                @case('mytickets')
                                    You don't have any ticket...
                                    @break
                                @case('assignedtickets')
                                    You don't have any assigned tickets...
                                    @break
                                @case('opentickets')
                                    You don't have any open tickets...
                                    @break
                                @case('acknowledgedtickets')
                                    You don't have any acknowledged tickets...
                                    @break
                                @case('resolvedtickets')
                                    You don't have any resolved tickets...
                                    @break
                                @case('closedtickets')
                                    You don't have any closed tickets...
                                    @break
                                @case('cancelledtickets')
                                    You don't have any cancelled tickets...
                                    @break
                                @default
                                    Something is wrong here...
                                    @break
                            @endswitch
                        </strong>
                    </td>
                </tr>
            @endif
        </tbody>

        <tfoot class="table-group-divider">
            <tr>
                <th class="small">
                    @switch($order)
                        @case("asc")
                            <a href="/{{Auth::user()->u_department}}/tickets/{{$myticket}}/ticketid/desc" class="btn btn-sm small w-100"><strong># <i class="bi bi-sort-numeric-down"></i></strong></a>  
                        @break
                        @default
                            <a href="/{{Auth::user()->u_department}}/tickets/{{$myticket}}/ticketid/asc" class="btn btn-sm small w-100"><strong># <i class="bi bi-sort-numeric-up"></i></strong></a>                        
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
                            <a href="/{{Auth::user()->u_department}}/tickets/{{$myticket}}/d_code/desc" class="btn btn-sm small w-100"><strong>From <i class="bi bi-sort-alpha-down"></i></strong></a>
                        @break
                        @default
                            <a href="/{{Auth::user()->u_department}}/tickets/{{$myticket}}/d_code/asc" class="btn btn-sm small w-100"><strong>From <i class="bi bi-sort-alpha-up"></i></strong></a>
                    @endswitch
                </th>
                <th class="small">
                    @switch($order)
                        @case("asc")
                            <a href="/{{Auth::user()->u_department}}/tickets/{{$myticket}}/creator/desc" class="btn btn-sm small w-100"><strong>Created By <i class="bi bi-sort-alpha-down"></i></strong></a>
                        @break
                        @default
                            <a href="/{{Auth::user()->u_department}}/tickets/{{$myticket}}/creator/asc" class="btn btn-sm small w-100"><strong>Created By <i class="bi bi-sort-alpha-up"></i></strong></a>
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
                <th class="small">
                    @switch($order)
                        @case("asc")
                            <a href="/{{Auth::user()->u_department}}/tickets/{{$myticket}}/assignedto/desc" class="btn btn-sm small w-100"><strong>Assigned To <i class="bi bi-sort-numeric-down"></i></strong></a>
                        @break
                        @default
                            <a href="/{{Auth::user()->u_department}}/tickets/{{$myticket}}/assignedto/asc" class="btn btn-sm small w-100"><strong>Assigned To <i class="bi bi-sort-numeric-up"></i></strong></a>
                    @endswitch
                </th>
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
                            <a href="/{{Auth::user()->u_department}}/tickets/{{$myticket}}/ticketStatus/desc" class="btn btn-sm small w-100"><strong>Status <i class="bi bi-sort-alpha-down"></i></strong></a>
                        @break
                        @default
                            <a href="/{{Auth::user()->u_department}}/tickets/{{$myticket}}/ticketStatus/asc" class="btn btn-sm small w-100"><strong>Status <i class="bi bi-sort-alpha-up"></i></strong></a>
                    @endswitch
                </th>
                <th class="small"></th>
            </tr>
        </tfoot>
    </table>
</div>

<div class="d-flex justify-content-center py-0 mt-3">
    @if($tickets)
        {{$tickets->onEachSide(1)->links()}}
    @endif
</div>