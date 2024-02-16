@if($comments)
    <div class="card">
        <div class="card-header">Comments</div>
        <div class="card-body" style="max-height:300px;">
            <div class="row">
                <div class="col-sm-12" style="max-height: 180px; overflow-y:auto;">
                    <table class="table table-sm table-hover table-striped">
                        <tbody>
                            @foreach($comments as $comment)
                            <tr>
                                <td class="small"><small>{{$comment->u_fname}} {{$comment->u_lname}} : </small></td>
                                <td class="small"><small>{{$comment->comment_message}}</small></td>
                                <td class="small"><small>{{$comment->created_at}}</small></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-12">
                    <form action="/tickets/addcomment" method="POST">
                        @csrf
                        @method('POST')
                        @if($ticket->t_status <= 5)
                            <input type="hidden" name="comment_ticketid" class="form-control" value="{{$ticket->t_id}}">
                            <textarea name="comment_message" id="" cols="30" rows="1" class="form-control mb-3 w-100"></textarea>
                            <button type="submit" class="btn btn-sm btn-primary w-100">
                                Add Comment
                            </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif