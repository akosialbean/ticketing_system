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
    This is to inform you that <strong>{{$comment->u_fname}} {{$comment->u_lname}}</strong> commented on ticket number {{$comment->t_id}}.
    <br><br>
    <strong>Ticket #: #{{$comment->t_id}}#</strong><br>
    <i>{{$comment->t_description}}</i>
    <br><br><br>

    Best regards,<br><br>

    IT Helpdesk<br>
    Westlake Medical Center
</body>
</html>