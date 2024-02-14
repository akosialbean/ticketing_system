<div class="table-responsive">
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

        <tbody>
            @if($tickets)
                @foreach($tickets as $ticket)
                <tr>
                    <td class="small"><small>{{$ticket->ticketid}}</small></td>
                    <td class="small"><small>{{$ticket->t_title}}</small></td>
                    <td class="small"><small>{{$ticket->d_code}}</small></td>
                    <td class="small"><small>{{$ticket->creator}}</small></td>
                    <td class="small"><small>{{$ticket->created_at}}</small></td>
                    <td class="small"><small>{{$ticket->assignedto}}</small></td>
                    <td class="small"><small>{{$ticket->t_severity}}</small></td>
                    <td class="small"><small>{{$ticket->ticketStatus}}</small></td>
                    <td>
                        @if($ticket->ticketStatus == 'New' && Auth::user()->u_role == 1)
                            <form action="/openticket" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="t_id" value="{{$ticket->ticketid}}">
                                <button type="submit" class="btn btn-sm btn-info"><i class="bi bi-three-dots-vertical"></i></button>
                            </form>
                        @else
                            <a href="/ticket/{{$ticket->ticketid}}" class="btn btn-sm btn-primary"><i class="bi bi-three-dots-vertical"></i>
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

<div class="d-flex justify-content-center py-0 mt-3">
    {{$tickets->onEachSide(1)->links()}}
</div>