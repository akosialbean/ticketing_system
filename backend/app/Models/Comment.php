<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable =[
        'comment_ticketid',
        'comment_sender',
        'comment_message',
        'comment_createdby',
        'comment_updatedby'
    ];

    public function addComment($data){
        return Comment::create($data);
    }
}
