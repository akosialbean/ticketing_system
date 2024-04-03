<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket Notification</title>
</head>
<body>
    Good day!
    <br><br>
    This is to inform you that your ticket was cancelled by <strong>{{$ticket->u_fname}} {{$ticket->u_lname}}</strong> from {{$ticketviewer->d_code}} Department.
    <br><br>
    <strong>Ticket #: #{{$ticket->t_id}}#</strong><br>
    <i>{{$ticket->t_description}}</i>
    <br><br>
    <strong>Reason:</strong><br>
    <i>{{$ticket->t_cancelreason}}</i>
    <br><br><br>

    Best regards,<br><br>

    IT Helpdesk<br>
    Westlake Medical Center
</body>
</html>