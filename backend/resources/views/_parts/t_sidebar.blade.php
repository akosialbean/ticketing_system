
    <ul class="nav flex-column bg-dark pt-5" style="height: 100vh;">
        @if(Auth::user()->u_role == 1)
            <li class="nav-item mt-5">
                <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/alltickets/ticketid/desc">
                    <small class="small"><i class="bi bi-ticket-detailed-fill"></i> All</small>
                    <span class="badge rounded-pill bg-primary">{{$ticketcount['perDept']}}</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/newtickets/ticketid/desc">
                    <small><i class="bi bi-node-plus-fill"></i> New</small>
                    <span class="badge rounded-pill bg-primary">{{$ticketcount['newTickets']}}</span>
                </a>
            </li>
        @endif

        <li class="nav-item">
            <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/mytickets/ticketid/desc">
                <small><i class="bi bi-file-earmark-person"></i> My</small>
                <span class="badge rounded-pill bg-primary">{{$ticketcount['myTickets']}}</span>
            </a>
        </li>

        @if(Auth::user()->u_role == 1)
            <li class="nav-item">
                <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/assignedtickets/ticketid/desc">
                    <small><i class="bi bi-tags"></i> Assigned</small>
                    <span class="badge rounded-pill bg-primary">{{$ticketcount['assignedTickets']}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/opentickets/ticketid/desc">
                    <small><i class="bi bi-envelope-open"></i> Open</small>
                    <span class="badge rounded-pill bg-primary">{{$ticketcount['openTickets']}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/acknowledgedtickets/ticketid/desc">
                    <small><i class="bi bi-bullseye"></i> Acknowledged</small>
                    <span class="badge rounded-pill bg-primary">{{$ticketcount['acknowledgedTickets']}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/resolvedtickets/ticketid/desc">
                    <small><i class="bi bi-check2-circle"></i> Resolved</small>
                    <span class="badge rounded-pill bg-primary">{{$ticketcount['resolvedTickets']}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/closedtickets/ticketid/desc">
                    <small><i class="bi bi-envelope"></i> Closed</small>
                    <span class="badge rounded-pill bg-primary">{{$ticketcount['closedTickets']}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/cancelledtickets/ticketid/desc">
                    <small><i class="bi bi-x-octagon"></i> Cancelled</small>
                    <span class="badge rounded-pill bg-primary">{{$ticketcount['cancelledTickets']}}</span>
                </a>
            </li>
        @endif
    </ul>