<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Comment;
use App\Mail\CommentNotification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
{
    public $comment;

    public function __construct(Comment $comment){
        $this->comment = $comment;
    }
    public function addcomment(Request $request){
        $data = $request->validate([
            'comment_ticketid' => ['required'],
            'comment_message' => ['required'],
            'created_at',
            'comment_sender'
        ]);

        $data['created_at'] = now();
        $data['comment_sender'] = Auth::user()->id;

        $save = $this->comment->addComment($data);

        if($save){
            //SENDING EMAIL TO TICKET RESOLVER
            // $tosender = Comment::select('users.u_email')
            // ->join('users', 'comments.comment_sender', 'users.id')
            // ->join('tickets', 'comments.comment_ticketid', 'tickets.t_id')
            // ->where('tickets.t_id', $data['comment_ticketid'])
            // ->first();

            // $comment = Comment::select('comments.comment_ticketid', 'comments.comment_message', 'users.u_fname', 'users.u_lname', 'tickets.t_id', 'tickets.t_description')
            // ->join('tickets', 'comments.comment_ticketid', 'tickets.t_id')
            // ->join('users', 'comments.comment_sender', 'users.id')
            // ->where('tickets.t_id', $data['comment_ticketid'])
            // ->orderby('comment_id', 'desc')
            // ->first();

            // Mail::to($tosender->u_email)->send(new CommentNotification($comment));

            return redirect()->intended('/ticket/' . $data['comment_ticketid'])->with('success', 'Comment saved!');
        }else{
            return redirect()->intended('/ticket/' . $data['comment_ticketid'])->with('error', 'Failed to save comment!');
        }
    }
}


