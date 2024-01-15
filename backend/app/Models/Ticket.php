<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        't_title',
        't_description',
        't_category',
        't_todepartment',
        't_createdby',
        't_assignedby',
        't_assignedto',
        't_openedby',
        't_acknowledgedby',
        't_resolvedby',
        't_closedby',
        't_updatedby',
        't_resolution',
        't_cancellation',
        't_severity',
        't_status',
    ];
}
