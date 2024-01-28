<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket Created</title>
</head>
<body>
    Good day {{Auth::user()->u_fname}}!
    <br><br>
    This is to inform you that your ticket <strong>#{{$ticket->t_id}}#</strong> has been submitted to <strong>{{$ticket->d_description}} Department</strong>!
    <br><br>
    <strong>Ticket details:</strong><br>
    <i>{{$ticket->t_description}}</i>
    <br><br><br>

    Best regards,<br><br>

    IT Helpdesk<br>
    Westlake Medical Center
</body>
</html>