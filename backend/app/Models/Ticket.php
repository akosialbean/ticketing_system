<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Department;
use App\Models\Category;
use App\Models\User;
use App\Models\Severity;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Ticket extends Model
{
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

    public function createTicket($newticket){
        return Ticket::create($newticket);
    }

    public function getAllTicketCount(){
        return Ticket::where('t_todepartment', Auth::user()->u_department)->count();
    }

    public function getTicketPerDepartmentCount($userdept, $userid){
        return Ticket::where('tickets.t_todepartment', $userdept)->orWhere('tickets.t_createdby', $userid)->count();
    }

    public function getMyTicketsCount($userid){
        return Ticket::where('t_createdby', $userid)->count();
    }

    public function getNewTicketsCount($userdept){
        return Ticket::where('t_status', 1)->where('t_todepartment', $userdept)->count();
    }

    public function getOpenTicketsCount($userdept){
        return Ticket::where('t_status', 2)->where('t_todepartment', $userdept)->count();
    }

    public function getAssignedTicketsCount($userdept){
        return Ticket::where('t_status', 3)->where('t_todepartment', $userdept)->count();
    }

    public function getAcknowledgedTicketsCount($userdept){
        return Ticket::where('t_status', 4)->where('t_todepartment', $userdept)->count();
    }

    public function getResolvedTicketsCount($userdept){
        return Ticket::where('t_status', 5)->where('t_todepartment', $userdept)->count();
    }

    public function getClosedTicketsCount($userdept){
        return Ticket::where('t_status', 6)->where('t_todepartment', $userdept)->count();
    }

    public function getcancelledTicketsCount($userdept){
        return Ticket::where('t_status', 7)->where('t_todepartment', $userdept)->count();
    }

    public function getOverduedTicketsCount($userdept){
        return Ticket::whereRaw("DATEDIFF(CURDATE(), tickets.created_at) > 7 AND tickets.t_severity = 0 AND tickets.t_status < 5")
            ->orWhereRaw("DATEDIFF(CURDATE(), tickets.created_at) > 7 AND tickets.t_severity = 1 AND tickets.t_status < 5")
            ->orWhereRaw("DATEDIFF(CURDATE(), tickets.created_at) > 5 AND tickets.t_severity = 2 AND tickets.t_status < 5")
            ->orWhereRaw("DATEDIFF(CURDATE(), tickets.created_at) > 3 AND tickets.t_severity = 3 AND tickets.t_status < 5")
            ->orWhereRaw("DATEDIFF(CURDATE(), tickets.created_at) > 1 AND tickets.t_severity = 4 AND tickets.t_status < 5")
            ->orWhereRaw("DATEDIFF(CURDATE(), tickets.created_at) > 1 AND tickets.t_severity = 5 AND tickets.t_status < 5")
            ->where('t_todepartment', $userdept)
            ->count();
    }

    public function getAllTickets($department, $myticket, $column, $order, $userid, $userdept){
        return Ticket::select('tickets.t_id as ticketid', 'tickets.t_title', 'departments.d_code', 'tickets.t_resolveddate',
            DB::raw("DATEDIFF(CURDATE(), tickets.created_at) as overdue"),
            DB::raw("(SELECT CONCAT(users.u_fname, ' ', users.u_lname) FROM users WHERE users.id = tickets.t_createdby) as creator"),
                'tickets.created_at', 'tickets.t_severity', 'tickets.t_cancelleddate', 'tickets.t_description',
            DB::raw("(SELECT CONCAT(users.u_fname, ' ', users.u_lname) FROM users WHERE users.id = tickets.t_assignedto) as assignedto"),
            DB::raw("CASE WHEN tickets.t_status = 1 THEN 'New'
                    WHEN tickets.t_status = 2 THEN 'Viewed'
                    WHEN tickets.t_status = 3 THEN 'Assigned'
                    WHEN tickets.t_status = 4 THEN 'Acknowledged'
                    WHEN tickets.t_status = 5 THEN 'Resolved'
                    WHEN tickets.t_status = 6 THEN 'Closed-Resolved'
                    WHEN tickets.t_status = 7 THEN 'Cancelled' END as ticketStatus"))
            ->join('users', 'tickets.t_createdby', '=', 'users.id')
            ->join('departments', 'users.u_department', '=', 'departments.d_id')
            ->where(function ($query) use ($myticket, $userdept, $userid) {
                switch ($myticket) {
                    case 'alltickets':
                        $query->where('tickets.t_todepartment', $userdept)->orWhere('tickets.t_createdby', $userid);
                        break;
                    case 'mytickets':
                        $query->where('tickets.t_createdby', $userid);
                        break;
                    case 'newtickets':
                        $query->where('tickets.t_status', 1)->where('tickets.t_todepartment', $userdept);
                        break;
                    case 'opentickets':
                        $query->where('tickets.t_status', 2)->where('tickets.t_todepartment', $userdept);
                        break;
                    case 'assignedtickets':
                        $query->where('tickets.t_status', 3)->where('tickets.t_todepartment', $userdept);
                        break;
                    case 'acknowledgedtickets':
                        $query->where('tickets.t_status', 4)->where('tickets.t_todepartment', $userdept);
                        break;
                    case 'resolvedtickets':
                        $query->where('tickets.t_status', 5)->where('tickets.t_todepartment', $userdept);
                        break;
                    case 'closedtickets':
                        $query->where('tickets.t_status', 6)->where('tickets.t_todepartment', $userdept);
                        break;
                    case 'cancelledtickets':
                        $query->where('tickets.t_status', 7)->where('tickets.t_todepartment', $userdept);
                        break;
                    case 'overduetickets':
                        $query->where('tickets.t_todepartment', $userdept)
                        ->whereRaw("DATEDIFF(CURDATE(), tickets.created_at) > 7 AND tickets.t_severity = 0 AND tickets.t_status < 5")
                        ->orWhereRaw("DATEDIFF(CURDATE(), tickets.created_at) > 7 AND tickets.t_severity = 1 AND tickets.t_status < 5")
                        ->orWhereRaw("DATEDIFF(CURDATE(), tickets.created_at) > 5 AND tickets.t_severity = 2 AND tickets.t_status < 5")
                        ->orWhereRaw("DATEDIFF(CURDATE(), tickets.created_at) > 3 AND tickets.t_severity = 3 AND tickets.t_status < 5")
                        ->orWhereRaw("DATEDIFF(CURDATE(), tickets.created_at) > 1 AND tickets.t_severity = 4 AND tickets.t_status < 5")
                        ->orWhereRaw("DATEDIFF(CURDATE(), tickets.created_at) > 1 AND tickets.t_severity = 5 AND tickets.t_status < 5")
                        ->where('tickets.t_todepartment', $userdept);
                        break;
                }
            })
            ->orderby($column, $order)
            ->paginate(10);
    }

    public function searchTicket($department, $myticket, $column, $order, $userid, $userdept, $searchitem){
        return DB::table('tickets')
        ->select('tickets.t_id as ticketid', 'tickets.t_title', 'departments.d_code', 'tickets.t_description',
            DB::raw("DATEDIFF(CURDATE(), tickets.created_at) as overdue"),
            DB::raw("(SELECT CONCAT(users.u_fname, ' ', users.u_lname) FROM users WHERE users.id = tickets.t_createdby) as creator"),
                'tickets.created_at', 'tickets.t_severity', 'tickets.t_resolveddate', 'tickets.t_cancelleddate',
            DB::raw("(SELECT CONCAT(users.u_fname, ' ', users.u_lname) FROM users WHERE users.id = tickets.t_assignedto) as assignedto"),
            DB::raw("CASE WHEN tickets.t_status = 1 THEN 'New'
                    WHEN tickets.t_status = 2 THEN 'Viewed'
                    WHEN tickets.t_status = 3 THEN 'Assigned'
                    WHEN tickets.t_status = 4 THEN 'Acknowledged'
                    WHEN tickets.t_status = 5 THEN 'Resolved'
                    WHEN tickets.t_status = 6 THEN 'Closed-Resolved'
                    WHEN tickets.t_status = 7 THEN 'Cancelled' END as ticketStatus"))
            ->join('users', 'tickets.t_createdby', '=', 'users.id')
            ->join('departments', 'users.u_department', '=', 'departments.d_id')
            ->where('tickets.t_todepartment', 1)
            ->where(function ($query) use ($myticket, $userdept, $userid) {
                switch ($myticket) {
                    case 'alltickets':
                        $query->where('tickets.t_todepartment', $userdept);
                        break;
                    case 'mytickets':
                        $query->where('tickets.t_createdby', $userid);
                        break;
                    case 'newtickets':
                        $query->where('tickets.t_status', 1);
                        break;
                    case 'opentickets':
                        $query->where('tickets.t_status', 2);
                        break;
                    case 'assignedtickets':
                        $query->where('tickets.t_status', 3);
                        break;
                    case 'acknowledgedtickets':
                        $query->where('tickets.t_status', 4);
                        break;
                    case 'resolvedtickets':
                        $query->where('tickets.t_status', 5);
                        break;
                    case 'closedtickets':
                        $query->where('tickets.t_status', 6);
                        break;
                    case 'cancelledtickets':
                        $query->where('tickets.t_status', 7);
                        break;
                }
            })
            ->where(function ($query) use ($searchitem) {
                $query->where('tickets.t_id', 'like', '%' . $searchitem['searchitem'] . '%')
                    ->orWhere('tickets.t_title', 'like', '%' . $searchitem['searchitem'] . '%')
                    ->orWhere('tickets.t_description', 'like', '%' . $searchitem['searchitem'] . '%')
                    ->orWhere('tickets.t_severity', 'like', '%' . $searchitem['searchitem'] . '%')
                    ->orWhere('users.u_fname', 'like', '%' . $searchitem['searchitem'] . '%')
                    ->orWhere('users.u_lname', 'like', '%' . $searchitem['searchitem'] . '%')
                    // ->orWhere('assignedto', 'like', '%' . $searchitem['searchitem'] . '%')
                    ->orWhere('tickets.t_status', 'like', '%' . $searchitem['searchitem'] . '%')
                    ->orWhere('departments.d_code', 'like', '%' . $searchitem['searchitem'] . '%')
                    ->orWhere('departments.d_description', 'like', '%' . $searchitem['searchitem'] . '%');
            })
            ->orderby($column, $order)
            ->paginate(10);
    }

    public function assignTicket($user, $assignedBy){
        return Ticket::where('t_id', $user['t_id'])
            ->update([
                't_assignedto' => $user['t_assignedto'],
                't_assignedby' => $assignedBy,
                't_assigneddate' => now(),
                'updated_at' => now(),
                't_status' => 3
            ]);
    }
}