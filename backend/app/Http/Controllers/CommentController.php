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
    public function addcomment(Request $request){
        $comment = $request->validate([
            'comment_ticketid' => ['required'],
            'comment_message' => ['required'],
            'created_at',
            'comment_sender'
        ]);

        $comment['created_at'] = now();
        $comment['comment_sender'] = Auth::user()->id;

        $save = Comment::insert($comment);

        if($save){
            //SENDING EMAIL TO TICKET RESOLVER
            $tosender = Comment::select('users.u_email')
            ->join('users', 'comments.comment_sender', 'users.id')
            ->join('tickets', 'comments.comment_ticketid', 'tickets.t_id')
            ->where('tickets.t_id', $comment['comment_ticketid'])
            ->first();

            $comment = Comment::select('comments.comment_ticketid', 'comments.comment_message', 'users.u_fname', 'users.u_lname', 'tickets.t_id', 'tickets.t_description')
            ->join('tickets', 'comments.comment_ticketid', 'tickets.t_id')
            ->join('users', 'comments.comment_sender', 'users.id')
            ->first();

            Mail::to($tosender->u_email)->send(new CommentNotification($comment));

            return redirect()->intended('/ticket/' . $comment['comment_ticketid'])->with('success', 'Comment saved!');
        }else{
            return redirect()->intended('/ticket/' . $comment['comment_ticketid'])->with('error', 'Failed to save comment!');
        }
    }
}
