<ul class="nav flex-column bg-dark pt-5" style="height: 100vh;">
    @if(Auth::user()->u_role == 1)
        <li class="nav-item mt-5">
            <a class="nav-link text-light" href="/tickets"><small class="small">All Tickets ({{$allticketcount}})</small></a>
        </li>
    @endif

    <li class="nav-item">
        <a class="nav-link text-light" href="/tickets/mytickets"><small>My Tickets ({{$myticketcount}})</small></a>
    </li>

    @if(Auth::user()->u_role == 1)
        <li class="nav-item">
            <a class="nav-link text-light" href="/tickets/assignedtickets"><small>Assigned Tickets ({{$assignedticketcount}})</small></a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="/tickets/opentickets"><small>Open Tickets ({{$openticketcount}})</small></a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="/tickets/acknowledgedtickets"><small>Acknowledged Tickets ({{$acknowledgedticketcount}})</small></a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="/tickets/resolvedtickets"><small>Resolved Tickets ({{$resolvedticketcount}})</small></a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="/tickets/closedtickets"><small>Closed Tickets ({{$closedticketcount}})</small></a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="/tickets/cancelledtickets"><small>Cancelled Tickets ({{$cancelledticketcount}})</small></a>
        </li>
    @endif
</ul>