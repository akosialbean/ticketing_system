<div class="row">
    <div class="col-sm-3">
        <form action="/tickets/addcomment" method="POST">
            @csrf
            @method('POST')
            <input type="hidden" name="comment_ticketid" class="form-control" value="{{$ticket->t_id}}">
            <textarea name="comment_message" id="" cols="30" rows="10" class="form-control my-3 w-100"></textarea>
            <button type="submit" class="btn btn-sm btn-primary w-100">Add Comment</button>
        </form>
    </div>
    <div class="col-sm-9">
        <table class="table table-sm table-hover table-striped">
            <tbody>
                @foreach($comments as $comment)
                <tr>
                    <td>{{$comment->u_fname}} {{$comment->u_lname}} : </td>
                    <td>{{$comment->comment_message}}</td>
                    <td>{{$comment->created_at}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>