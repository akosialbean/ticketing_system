@foreach($ticketcount as $count)
    <ul class="nav flex-column bg-dark pt-5" style="height: 100vh;">
        @if(Auth::user()->u_role == 1)
            <li class="nav-item mt-5">
                <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/alltickets/ticketid/desc">
                    <small class="small">All Tickets</small>
                    <span class="badge rounded-pill bg-primary">{{$count->perDept}}</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/newtickets/ticketid/desc">
                    <small>New Tickets</small>
                    <span class="badge rounded-pill bg-primary">{{$count->newTickets}}</span>
                </a>
            </li>
        @endif

        <li class="nav-item">
            <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/mytickets/ticketid/desc">
                <small>My Tickets</small>
                <span class="badge rounded-pill bg-primary">{{$count->myTickets}}</span>
            </a>
        </li>

        @if(Auth::user()->u_role == 1)
            <li class="nav-item">
                <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/assignedtickets/ticketid/desc">
                    <small>Assigned Tickets</small>
                    <span class="badge rounded-pill bg-primary">{{$count->assignedTickets}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/opentickets/ticketid/desc">
                    <small>Open Tickets</small>
                    <span class="badge rounded-pill bg-primary">{{$count->openTickets}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/acknowledgedtickets/ticketid/desc">
                    <small>Acknowledged Tickets</small>
                    <span class="badge rounded-pill bg-primary">{{$count->acknowledgedTickets}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/resolvedtickets/ticketid/desc">
                    <small>Resolved Tickets</small>
                    <span class="badge rounded-pill bg-primary">{{$count->resolvedTickets}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/closedtickets/ticketid/desc">
                    <small>Closed Tickets</small>
                    <span class="badge rounded-pill bg-primary">{{$count->closedTickets}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="/{{Auth::user()->u_department}}/tickets/cancelledtickets/ticketid/desc">
                    <small>Cancelled Tickets</small>
                    <span class="badge rounded-pill bg-primary">{{$count->cancelledTickets}}</span>
                </a>
            </li>
        @endif
    </ul>
@endforeach