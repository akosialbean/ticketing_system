<ul class="nav flex-column bg-dark pt-5" style="height: 100vh;">
    @if(Auth::user()->u_role == 1)
        <li class="nav-item mt-5">
            <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/alltickets/t_id/desc"><small class="small">All Tickets ({{$allticketcount}})</small></a>
        </li>
    @endif

    <li class="nav-item">
        <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/mytickets/t_id/desc"><small>My Tickets ({{$myticketcount}})</small></a>
    </li>

    @if(Auth::user()->u_role == 1)
        <li class="nav-item">
            <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/assignedtickets/t_id/desc"><small>Assigned Tickets ({{$assignedticketcount}})</small></a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/opentickets/t_id/desc"><small>Open Tickets ({{$openticketcount}})</small></a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/acknowledgedtickets/t_id/desc"><small>Acknowledged Tickets ({{$acknowledgedticketcount}})</small></a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/resolvedtickets/t_id/desc"><small>Resolved Tickets ({{$resolvedticketcount}})</small></a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/closedtickets/t_id/desc"><small>Closed Tickets ({{$closedticketcount}})</small></a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/cancelledtickets/t_id/desc"><small>Cancelled Tickets ({{$cancelledticketcount}})</small></a>
        </li>
    @endif
</ul>