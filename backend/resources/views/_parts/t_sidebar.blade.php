{{-- 
    <ul class="nav nav-pills nav-fill flex-column nav-light pt-5" style="height: 100vh;">
        @if(Auth::user()->u_role == 1)
            <li class="nav-item mt-5">
                <a class="nav-link active focus-ring focus-ring-warning" role="link" data-bs-toggle="nav-link"  href="/{{Auth::user()->u_department}}/tickets/alltickets/ticketid/desc">
                    <strong><i class="bi bi-ticket-detailed-fill"></i> All</strong>
                    <span class="badge rounded-pill bg-primary">{{$ticketcount['perDept']}}</span>
                </a>
            </li>

            
            <li class="nav-item">
                <a class="nav-link text-light focus-ring focus-ring-light" href="/{{Auth::user()->u_department}}/tickets/newtickets/ticketid/desc">
                    <small><i class="bi bi-node-plus-fill"></i> New</small>
                    <span class="badge rounded-pill bg-primary">{{$ticketcount['newTickets']}}</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-light focus-ring focus-ring-light" href="/{{Auth::user()->u_department}}/tickets/overduetickets/ticketid/desc">
                    <small><i class="bi bi-exclamation-circle"></i> Overdue</small>
                    <span class="badge rounded-pill bg-primary">{{$ticketcount['overdueTickets']}}</span>
                </a>
            </li>
        @endif

        <li class="nav-item">
            <a class="nav-link text-light focus-ring focus-ring-light" href="/{{Auth::user()->u_department}}/tickets/mytickets/ticketid/desc">
                <small><i class="bi bi-file-earmark-person"></i> My</small>
                <span class="badge rounded-pill bg-primary">{{$ticketcount['myTickets']}}</span>
            </a>
        </li>

        @if(Auth::user()->u_role == 1)
            <li class="nav-item">
                <a class="nav-link text-light focus-ring focus-ring-light" href="/{{Auth::user()->u_department}}/tickets/assignedtickets/ticketid/desc">
                    <small><i class="bi bi-tags"></i> Assigned</small>
                    <span class="badge rounded-pill bg-primary">{{$ticketcount['assignedTickets']}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light focus-ring focus-ring-light" href="/{{Auth::user()->u_department}}/tickets/opentickets/ticketid/desc">
                    <small><i class="bi bi-envelope-open"></i> Open</small>
                    <span class="badge rounded-pill bg-primary">{{$ticketcount['openTickets']}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light focus-ring focus-ring-light" href="/{{Auth::user()->u_department}}/tickets/acknowledgedtickets/ticketid/desc">
                    <small><i class="bi bi-bullseye"></i> Acknowledged</small>
                    <span class="badge rounded-pill bg-primary">{{$ticketcount['acknowledgedTickets']}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light focus-ring focus-ring-light" href="/{{Auth::user()->u_department}}/tickets/resolvedtickets/ticketid/desc">
                    <small><i class="bi bi-check2-circle"></i> Resolved</small>
                    <span class="badge rounded-pill bg-primary">{{$ticketcount['resolvedTickets']}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light focus-ring focus-ring-light" href="/{{Auth::user()->u_department}}/tickets/closedtickets/ticketid/desc">
                    <small><i class="bi bi-envelope"></i> Closed</small>
                    <span class="badge rounded-pill bg-primary">{{$ticketcount['closedTickets']}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light focus-ring focus-ring-light" href="/{{Auth::user()->u_department}}/tickets/cancelledtickets/ticketid/desc">
                    <small><i class="bi bi-x-octagon"></i> Cancelled</small>
                    <span class="badge rounded-pill bg-primary">{{$ticketcount['cancelledTickets']}}</span>
                </a>
            </li>
        @endif
    </ul> --}}

    <ul class="list-group mt-5">
        <li class="list-group-item list-group-item-action list-group-item-dark mt-5 {{$myticket == 'alltickets' ? 'active' : 'null'}}">
            <a class="nav-link"  href="/{{Auth::user()->u_department}}/tickets/alltickets/ticketid/desc">
                <strong><i class="bi bi-ticket-detailed-fill"></i> All</strong>
                <div class="vr"></div>
                <span class="badge rounded-pill bg-primary">{{$ticketcount['perDept']}}</span>
            </a>
        </li>
        <li class="list-group-item list-group-item-action list-group-item-dark {{$myticket == 'newtickets' ? 'active' : 'null'}}">
            <a class="nav-link" href="/{{Auth::user()->u_department}}/tickets/newtickets/ticketid/desc">
                <strong><i class="bi bi-node-plus-fill"></i> New</strong>
                <div class="vr"></div>
                <span class="badge rounded-pill bg-primary">{{$ticketcount['newTickets']}}</span>
            </a>
        </li>
        <li class="list-group-item list-group-item-action list-group-item-dark {{$myticket == 'overduetickets' ? 'active' : 'null'}}">
            <a class="nav-link" href="/{{Auth::user()->u_department}}/tickets/overduetickets/ticketid/desc">
                <strong><i class="bi bi-exclamation-circle"></i> Overdue</strong>
                <div class="vr"></div>
                <span class="badge rounded-pill bg-primary">{{$ticketcount['overdueTickets']}}</span>
            </a>
        </li>
        <li class="list-group-item list-group-item-action list-group-item-dark {{$myticket == 'mytickets' ? 'active' : 'null'}}">
            <a class="nav-link" href="/{{Auth::user()->u_department}}/tickets/mytickets/ticketid/desc">
                <strong><i class="bi bi-file-earmark-person"></i> My</strong>
                <div class="vr"></div>
                <span class="badge rounded-pill bg-primary">{{$ticketcount['myTickets']}}</span>
            </a>
        </li>
        <li class="list-group-item list-group-item-action list-group-item-dark {{$myticket == 'assignedtickets' ? 'active' : 'null'}}">
            <a class="nav-link" href="/{{Auth::user()->u_department}}/tickets/assignedtickets/ticketid/desc">
                <strong><i class="bi bi-tags"></i> Assigned</strong>
                <div class="vr"></div>
                <span class="badge rounded-pill bg-primary">{{$ticketcount['assignedTickets']}}</span>
            </a>
        </li>
        <li class="list-group-item list-group-item-action list-group-item-dark {{$myticket == 'opentickets' ? 'active' : 'null'}}">
            <a class="nav-link" href="/{{Auth::user()->u_department}}/tickets/opentickets/ticketid/desc">
                <strong><i class="bi bi-envelope-open"></i> Open</strong>
                <div class="vr"></div>
                <span class="badge rounded-pill bg-primary">{{$ticketcount['openTickets']}}</span>
            </a>
        </li>
        <li class="list-group-item list-group-item-action list-group-item-dark {{$myticket == 'acknowledgedtickets' ? 'active' : 'null'}}">
            <a class="nav-link" href="/{{Auth::user()->u_department}}/tickets/acknowledgedtickets/ticketid/desc">
                <strong><i class="bi bi-bullseye"></i> Acknowledged</strong>
                <div class="vr"></div>
                <span class="badge rounded-pill bg-primary">{{$ticketcount['acknowledgedTickets']}}</span>
            </a>
        </li>
        <li class="list-group-item list-group-item-action list-group-item-dark {{$myticket == 'resolvedtickets' ? 'active' : 'null'}}">
            <a class="nav-link" href="/{{Auth::user()->u_department}}/tickets/resolvedtickets/ticketid/desc">
                <strong><i class="bi bi-check2-circle"></i> Resolved</strong>
                <div class="vr"></div>
                <span class="badge rounded-pill bg-primary">{{$ticketcount['resolvedTickets']}}</span>
            </a>
        </li>
        <li class="list-group-item list-group-item-action list-group-item-dark {{$myticket == 'closedtickets' ? 'active' : 'null'}}">
            <a class="nav-link" href="/{{Auth::user()->u_department}}/tickets/closedtickets/ticketid/desc">
                <strong><i class="bi bi-envelope"></i> Closed</strong>
                <div class="vr"></div>
                <span class="badge rounded-pill bg-primary">{{$ticketcount['closedTickets']}}</span>
            </a>
        </li>
        <li class="list-group-item list-group-item-action list-group-item-dark {{$myticket == 'cancelledtickets' ? 'active' : 'null'}}">
            <a class="nav-link" href="/{{Auth::user()->u_department}}/tickets/cancelledtickets/ticketid/desc">
                <strong><i class="bi bi-x-octagon"></i> Cancelled</strong>
                <div class="vr"></div>
                <span class="badge rounded-pill bg-primary">{{$ticketcount['cancelledTickets']}}</span>
            </a>
        </li>
    </ul>