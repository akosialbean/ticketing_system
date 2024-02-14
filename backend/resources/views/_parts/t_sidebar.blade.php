
    <ul class="nav flex-column bg-dark pt-5" style="height: 100vh;">
        @if(Auth::user()->u_role == 1)
            <li class="nav-item mt-5">
                <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/alltickets/ticketid/desc">
                    <small class="small">All Tickets</small>
                    <span class="badge rounded-pill bg-primary">{{$ticketcount['perDept']}}</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/newtickets/ticketid/desc">
                    <small>New Tickets</small>
                    <span class="badge rounded-pill bg-primary">{{$ticketcount['newTickets']}}</span>
                </a>
            </li>
        @endif

        <li class="nav-item">
            <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/mytickets/ticketid/desc">
                <small>My Tickets</small>
                <span class="badge rounded-pill bg-primary">{{$ticketcount['myTickets']}}</span>
            </a>
        </li>

        @if(Auth::user()->u_role == 1)
            <li class="nav-item">
                <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/assignedtickets/ticketid/desc">
                    <small>Assigned Tickets</small>
                    <span class="badge rounded-pill bg-primary">{{$ticketcount['assignedTickets']}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/opentickets/ticketid/desc">
                    <small>Open Tickets</small>
                    <span class="badge rounded-pill bg-primary">{{$ticketcount['openTickets']}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/acknowledgedtickets/ticketid/desc">
                    <small>Acknowledged Tickets</small>
                    <span class="badge rounded-pill bg-primary">{{$ticketcount['acknowledgedTickets']}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/resolvedtickets/ticketid/desc">
                    <small>Resolved Tickets</small>
                    <span class="badge rounded-pill bg-primary">{{$ticketcount['resolvedTickets']}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/closedtickets/ticketid/desc">
                    <small>Closed Tickets</small>
                    <span class="badge rounded-pill bg-primary">{{$ticketcount['closedTickets']}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/cancelledtickets/ticketid/desc">
                    <small>Cancelled Tickets</small>
                    <span class="badge rounded-pill bg-primary">{{$ticketcount['cancelledTickets']}}</span>
                </a>
            </li>
        @endif
    </ul>