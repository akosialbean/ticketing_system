<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Comment;
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
            return redirect()->intended('/ticket/' . $comment['comment_ticketid'])->with('success', 'Comment saved!');
        }else{
            return redirect()->intended('/ticket/' . $comment['comment_ticketid'])->with('error', 'Failed to save comment!');
        }
    }
}
