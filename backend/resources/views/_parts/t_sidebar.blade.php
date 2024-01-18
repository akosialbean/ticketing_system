<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link" href="/tickets"><small>All Tickets ({{$allticketcount}})</small></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/tickets/mytickets"><small>My Tickets ({{$myticketcount}})</small></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/tickets/opentickets"><small>Open Tickets ({{$openticketcount}})</small></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/tickets/acknowledgedtickets"><small>Acknowledged Tickets ({{$acknowledgedticketcount}})</small></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/tickets/resolvedtickets"><small>Resolved Tickets ({{$resolvedticketcount}})</small></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/tickets/closedtickets"><small>Closed Tickets ({{$closedticketcount}})</small></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/tickets/cancelledtickets"><small>Cancelled Tickets ({{$cancelledticketcount}})</small></a>
    </li>
</ul>