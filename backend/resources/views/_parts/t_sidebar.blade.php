<ul class="nav flex-column bg-dark pt-5" style="height: 100vh;">
    @if(Auth::user()->u_role == 1)
        <li class="nav-item mt-5">
            <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/alltickets/t_id/desc">
                <small class="small">All Tickets</small>
                <span class="badge rounded-pill bg-primary">{{$allticketcount}}</span>
            </a>
        </li>
    @endif

    <li class="nav-item">
        <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/mytickets/t_id/desc">
            <small>My Tickets</small>
            <span class="badge rounded-pill bg-primary">{{$myticketcount}}</span>
        </a>
    </li>

    @if(Auth::user()->u_role == 1)
        <li class="nav-item">
            <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/assignedtickets/t_id/desc">
                <small>Assigned Tickets</small>
                <span class="badge rounded-pill bg-primary">{{$assignedticketcount}}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/opentickets/t_id/desc">
                <small>Open Tickets</small>
                <span class="badge rounded-pill bg-primary">{{$openticketcount}}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/acknowledgedtickets/t_id/desc">
                <small>Acknowledged Tickets</small>
                <span class="badge rounded-pill bg-primary">{{$acknowledgedticketcount}}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/resolvedtickets/t_id/desc">
                <small>Resolved Tickets</small>
                <span class="badge rounded-pill bg-primary">{{$resolvedticketcount}}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/closedtickets/t_id/desc">
                <small>Closed Tickets</small>
                <span class="badge rounded-pill bg-primary">{{$closedticketcount}}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/cancelledtickets/t_id/desc">
                <small>Cancelled Tickets</small>
                <span class="badge rounded-pill bg-primary">{{$cancelledticketcount}}</span>
            </a>
        </li>
    @endif
</ul>