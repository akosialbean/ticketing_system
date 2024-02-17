<?php

namespace App\Http\Controllers;
use App\Models\Department;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Severity;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketCreated;
use App\Mail\HelpdeskNotification;
use App\Mail\ViewedTicket;
use App\Mail\TicketAssigned;
use App\Mail\TicketAcknowledged;
use App\Mail\TicketResolved;
use App\Mail\TicketClosed;
use App\Mail\TicketCancelled;
use Carbon\Carbon;

use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function newticket(){
        $departments = Department::where('d_status', 1)->orderby('d_code', 'asc')->get();
        $categories = Category::where('c_status', 1)->orderby('c_code', 'asc')->get();
        return view('tickets.newticket', compact('departments', 'categories'));
    }

    public function add(Request $request){
        $newticket = $request->validate([
            't_title' => ['required'],
            't_description' => ['required'],
            't_category' => ['required'],
            't_todepartment' => ['required'],
            't_createdby',
            't_status',
            'created_at'
        ]);


        $newticket['t_createdby'] = Auth::user()->id;
        $newticket['t_status'] = 1;
        $newticket['created_at'] = now();

        $save = Ticket::insert($newticket);

        if($save){
            // $todepartment = $ticket = Ticket::select('tickets.t_id', 'tickets.t_title', 'tickets.t_description', 'departments.d_description')
            // ->join('departments', 't_todepartment', 'd_id')
            // ->join('users', 'tickets.t_createdby', 'users.id')
            // ->where('tickets.t_createdby', Auth::user()->id)
            // ->orderby('tickets.t_id', 'desc')
            // ->first();
            // Mail::to(Auth::user()->u_email)->send(new TicketCreated($todepartment));

            // //SENDING EMAIL TO TICKET RESOLVER
            // $department2 = Department::select('d_email')
            // ->where('d_id', $newticket['t_todepartment'])
            // ->first();
            // $fromdepartment = User::select('users.u_fname', 'users.u_lname', 'departments.d_description', 'tickets.t_id', 'tickets.t_title', 'tickets.t_description')
            // ->join('tickets', 'users.id', 'tickets.t_createdby')
            // ->join('departments', 'users.u_department', 'departments.d_id')
            // ->where('tickets.t_createdby', Auth::user()->id)
            // ->where('users.u_department', Auth::user()->u_department)
            // ->orderby('t_id', 'desc')
            // ->first();
            // Mail::to($department2->d_email)->send(new HelpdeskNotification($fromdepartment));

            if(Auth::user()->u_role == 1){
                return redirect(Auth::user()->u_department . '/tickets/alltickets/t_id/desc')->with('success', 'New ticket created!');
            }else{
                return redirect(Auth::user()->u_department . '/tickets/mytickets/t_id/desc')->with('success', 'New ticket created!');
            }
        }else{
            return redirect('/tickets')->with('error', 'Failed to create!');
        }
    }

    public function openticket(Request $request){
        $ticket = $request->validate([
            't_id' => ['required'],
            't_updatedby',
            't_status',
            'updated_at',
        ]);

        if(Auth::user()->u_role == 1){
            
            $user = Auth::user()->id;
    
            $update = Ticket::where('t_id', $ticket['t_id'])
            ->update([
                'updated_at' => now(),
                't_updatedby' => $user,
                't_status' => 2,
                't_openedby' => $user,
                't_dateopened' => now(),
            ]);
    
            if($update){
                //SENDING EMAIL TO TICKET CREATOR
                // $ticketcreator = User::select('users.id')
                // ->join('tickets', 'users.id', 'tickets.t_createdby')
                // ->where('tickets.t_id', $ticket['t_id'])
                // ->first();

                // $creator = Ticket::select('users.u_email')
                // ->join('users', 'tickets.t_createdby', 'users.id')
                // ->where('tickets.t_createdby', $ticketcreator->id)
                // ->first();

                // $todepartment = User::select('tickets.t_id', 'tickets.t_title', 'tickets.t_description', 'users.u_fname', 'users.u_lname', 'departments.d_description')
                // ->join('departments', 'users.u_department', 'departments.d_id')
                // ->join('tickets', 'users.id', 'tickets.t_createdby')
                // ->where('tickets.t_id', $ticket['t_id'])
                // ->orderby('tickets.t_id', 'desc')
                // ->first();

                // Mail::to($creator->u_email)->send(new ViewedTicket($todepartment));

                return redirect('/ticket/' . $ticket['t_id'])->with('success', 'Ticket ' . $ticket['t_id'] . ' opened!');
            }else{
                return redirect('/tickets')->with('error', 'Failed to open ticket ' . $ticket['t_id'] . '!');
            }
        }else{
            return redirect('/ticket/' . $ticket['t_id']);
        }
        
    }

    public function ticket($ticket){
        $tickets = Ticket::rightJoin('categories', 'categories.c_id', 'tickets.t_category')
            ->rightJoin('users', 'users.id', 'tickets.t_createdby')
            ->where('tickets.t_id', $ticket)
            ->get();

        $createdby = DB::table('tickets')
            ->leftJoin('users', 'tickets.t_createdby', 'users.id')
            ->where('tickets.t_id', $ticket)
            ->first();

        $assignedto = DB::table('tickets')
            ->leftJoin('users', 'tickets.t_assignedto', 'users.id')
            ->where('tickets.t_id', $ticket)
            ->first();

        $openedby = DB::table('tickets')
            ->leftJoin('users', 'tickets.t_openedby', 'users.id')
            ->where('tickets.t_id', $ticket)
            ->first();

        $acknowledgedby = DB::table('tickets')
            ->leftJoin('users', 'tickets.t_acknowledgedby', 'users.id')
            ->where('tickets.t_id', $ticket)
            ->first();

        $resolvedby = DB::table('tickets')
            ->leftJoin('users', 'tickets.t_resolvedby', 'users.id')
            ->where('tickets.t_id', $ticket)
            ->first();

        $closedby = DB::table('tickets')
            ->leftJoin('users', 'tickets.t_closedby', 'users.id')
            ->where('tickets.t_id', $ticket)
            ->first();

        $cancelledby = DB::table('tickets')
            ->leftJoin('users', 'tickets.t_cancelledby', 'users.id')
            ->where('tickets.t_id', $ticket)
            ->first();

        $severities = Severity::where('s_status', 1)->orderby('s_id', 'asc')->get();

        $resolvers = User::orderby('u_fname', 'asc')
        ->where('users.u_role', '1')
        ->where('users.u_department', Auth::user()->u_department)
        ->get();

        $assignedto = DB::table('tickets')
            ->join('users', 'tickets.t_assignedto', 'users.id')
            ->where('tickets.t_id', $ticket)
            ->first();

        $getCreatedDate = Ticket::select('created_at')
        ->where('tickets.t_id', $ticket)
        ->first();

        $getResolvedDate = Ticket::select('tickets.t_resolveddate', 'tickets.t_cancelleddate')
        ->where('tickets.t_id', $ticket)
        ->first();

        $date1 = Carbon::parse($getCreatedDate->created_at);
        if($getResolvedDate->t_resolveddate == NULL){
            $date2 = Carbon::parse($getResolvedDate->t_cancelleddate);
        }else{
            $date2 = Carbon::parse($getResolvedDate->t_resolveddate);
        }

        $total = $date1->diff($date2);
        $days = $total->format('%a');
        $hours = $total->format('%h');
        $minutes = $total->format('%i');
        $seconds = $total->format('%s');

        $comments = Comment::select('users.u_fname', 'users.u_lname', 'comments.comment_id', 'comments.comment_sender', 'comments.comment_message', 'comments.created_at')
        ->where('comments.comment_ticketid', $ticket)
        ->join('users', 'comments.comment_sender', 'users.id')
        ->orderby('comments.comment_id', 'desc')
        ->get();

        return view('tickets.ticket', compact('comments', 'tickets', 'openedby', 'acknowledgedby', 'resolvedby', 'closedby', 'cancelledby', 'createdby', 'severities', 'resolvers', 'assignedto', 'days', 'hours', 'minutes', 'seconds'));
    }

    public function acknowledge(Request $request){
        $ticket = $request->validate([
            't_id' => ['required'],
            't_updatedby',
            't_status',
            'updated_at'
        ]);

        $user = Auth::user()->id;

        $update = Ticket::where('t_id', $ticket['t_id'])
        ->update([
            'updated_at' => now(),
            't_updatedby' => $user,
            't_status' => 4,
            't_acknowledgedby' => $user,
            't_acknowledgeddate' => now(),
        ]);

        if($update){
            //SENDING EMAIL TO TICKET CREATOR
            // $ticketcreator = User::select('id')
            // ->join('tickets', 'users.id', 'tickets.t_createdby')
            // ->where('tickets.t_id', $ticket['t_id'])
            // ->first();
            // $user2 = Ticket::select('users.id', 'users.u_email')
            // ->join('users', 'tickets.t_createdby', 'users.id')
            // ->where('tickets.t_createdby', $ticketcreator->id)
            // ->first();
            // $todepartment = User::select('tickets.t_id', 'tickets.t_title', 'tickets.t_description', 'users.u_fname', 'users.u_lname', 'departments.d_description')
            // ->join('departments', 'users.u_department', 'departments.d_id')
            // ->join('tickets', 'users.id', 'tickets.t_acknowledgedby')
            // ->where('tickets.t_id', $ticket['t_id'])
            // ->orderby('tickets.t_id', 'desc')
            // ->first();
            // Mail::to($user2->u_email)->send(new TicketAcknowledged($todepartment));

            return redirect('/ticket/' . $ticket['t_id'])->with('success', 'Ticket ' . $ticket['t_id'] . ' acknowledged!');
        }else{
            return redirect('/tickets')->with('error', 'Failed to acknowledge ' . $ticket['t_id'] . '!');
        }
    }

    public function resolve(Request $request){
        // dd($request);
        $ticket = $request->validate([
            't_id' => ['required'],
            't_resolution' => ['required'],
            't_updatedby',
            'updated_at',
            't_status',
        ]);

        $user = Auth::user()->id;

        $resolve = Ticket::where('t_id', $ticket['t_id'])
        ->update([
            'updated_at' => now(),
            't_updatedby' => $user,
            't_status' => 5,
            't_resolvedby' => $user,
            't_resolution' => $ticket['t_resolution'],
            't_resolveddate' => now(),
        ]);

        if($resolve){
            //SENDING EMAIL TO TICKET CREATOR
            // $ticketcreator = User::select('id')
            // ->join('tickets', 'users.id', 'tickets.t_createdby')
            // ->where('tickets.t_id', $ticket['t_id'])
            // ->first();
            // $user2 = Ticket::select('users.id', 'users.u_email')
            // ->join('users', 'tickets.t_createdby', 'users.id')
            // ->where('tickets.t_createdby', $ticketcreator->id)
            // ->first();
            // $todepartment = User::select('tickets.t_id', 'tickets.t_title', 'tickets.t_description', 'tickets.t_resolution', 'users.u_fname', 'users.u_lname', 'departments.d_description')
            // ->join('departments', 'users.u_department', 'departments.d_id')
            // ->join('tickets', 'users.id', 'tickets.t_acknowledgedby')
            // ->where('tickets.t_id', $ticket['t_id'])
            // ->orderby('tickets.t_id', 'desc')
            // ->first();
            // Mail::to($user2->u_email)->send(new TicketResolved($todepartment));

            return redirect('/ticket/' . $ticket['t_id'])->with('success', 'Ticket ' . $ticket['t_id'] . ' resolved!');
        }else{
            return redirect('/tickets')->with('error', 'Failed to resolve ' . $ticket['t_id'] . '!');
        }
    }

    public function close(Request $request){
        $ticket = $request->validate([
            't_id' => ['required'],
            't_updatedby',
            'updated_at',
            't_status',
            't_closedby',
        ]);

        $user = Auth::user()->id;

        $resolve = Ticket::where('t_id', $ticket['t_id'])
        ->update([
            'updated_at' => now(),
            't_updatedby' => $user,
            't_status' => 6,
            't_closedby' => $user,
            't_closeddate' => now(),
        ]);

        if($resolve){
            // $ticketcreator = User::select('id')
            // ->join('tickets', 'users.id', 'tickets.t_createdby')
            // ->where('tickets.t_id', $ticket['t_id'])
            // ->first();
            // $user2 = Ticket::select('users.id', 'users.u_email')
            // ->join('users', 'tickets.t_createdby', 'users.id')
            // ->where('tickets.t_createdby', $ticketcreator->id)
            // ->first();
            // $todepartment = User::select('tickets.t_id', 'tickets.t_title', 'tickets.t_description', 'tickets.t_resolution', 'users.u_fname', 'users.u_lname', 'departments.d_description')
            // ->join('departments', 'users.u_department', 'departments.d_id')
            // ->join('tickets', 'users.id', 'tickets.t_resolvedby')
            // ->where('tickets.t_id', $ticket['t_id'])
            // ->orderby('tickets.t_id', 'desc')
            // ->first();
            // Mail::to($user2->u_email)->send(new TicketClosed($todepartment));

            return redirect('/ticket/' . $ticket['t_id'])->with('success', 'Ticket ' . $ticket['t_id'] . ' closed!');
        }else{
            return redirect('/tickets')->with('error', 'Failed to close ' . $ticket['t_id'] . '!');
        }
    }

    public function cancel(Request $request){
        $ticket = $request->validate([
            't_cancelreason' => ['required'],
            't_id' => ['required'],
            't_updatedby',
            't_status',
            't_cancelledby',
            'updated_at'
        ]);

        $user = Auth::user()->id;

        $cancel = Ticket::where('t_id', $ticket['t_id'])
        ->update([
            't_cancelreason' => $ticket['t_cancelreason'],
            't_updatedby' => $user,
            't_status' => 7,
            't_cancelledby' => $user,
            'updated_at' => now(),
            't_cancelleddate' => now(),
        ]);

        if($cancel){
            //SENDING EMAIL TO TICKET CREATOR
            // $ticketcreator = User::select('id')
            // ->join('tickets', 'users.id', 'tickets.t_createdby')
            // ->where('tickets.t_id', $ticket['t_id'])
            // ->first();
            // $user2 = Ticket::select('users.id', 'users.u_email')
            // ->join('users', 'tickets.t_createdby', 'users.id')
            // ->where('tickets.t_createdby', $ticketcreator->id)
            // ->first();
            // $todepartment = User::select('tickets.t_id', 'tickets.t_title', 'tickets.t_description', 'tickets.t_cancelreason', 'users.u_fname', 'users.u_lname', 'departments.d_description')
            // ->join('departments', 'users.u_department', 'departments.d_id')
            // ->join('tickets', 'users.id', 'tickets.t_cancelledby')
            // ->where('tickets.t_id', $ticket['t_id'])
            // ->orderby('tickets.t_id', 'desc')
            // ->first();
            // Mail::to($user2->u_email)->send(new TicketCancelled($todepartment));

            return redirect('/ticket/' . $ticket['t_id'])->with('success', 'Ticket ' . $ticket['t_id'] . ' cancelled!');
        }else{
            return redirect('/tickets')->with('error', 'Failed to cancel ' . $ticket['t_id'] . '!');
        }
    }


    public function editticket($ticket){
        $categories = Category::orderby('c_description', 'asc')->get();
        $departments = Department::orderby('d_description', 'asc')->get();

        $ticket = DB::table('tickets')
        ->where('tickets.t_id', $ticket)
        ->join('departments', 'tickets.t_todepartment', 'departments.d_id')
        ->join('categories', 'tickets.t_category', 'categories.c_id')
        ->first();

        return view('tickets.editticket', compact('ticket', 'categories', 'departments'));
    }

    public function edit(Request $request){
        $ticket = $request->validate([
            't_id' => ['required'],
            't_title' => ['required'],
            't_description' => ['required'],
            't_category' => ['required'],
            'updated_at'
        ]);

        $ticket['updated_at'] = now();

        $update = Ticket::where('t_id', $ticket['t_id'])
        ->update([
            't_title' => $ticket['t_title'],
            't_description' => $ticket['t_description'],
            't_category' => $ticket['t_category'],
            'updated_at' => now(),
        ]);

        if($update){
            return redirect('/ticket/' . $ticket['t_id'])->with('success', 'Ticket ' . $ticket['t_id'] . ' updated!');
        }else{
            return redirect('/tickets/' . $ticket['t_id'])->with('error', 'Failed to close ' . $ticket['t_id'] . '!');
        }
    }

    public function setseverity(Request $request){
        $ticket = $request->validate([
            't_id' => ['required'],
            't_severity' => ['required'],
            'updated_at'
        ]);

        $update = Ticket::where('t_id', $ticket['t_id'])
        ->update([
            't_severity' => $ticket['t_severity'],
            'updated_at' => now()
        ]);

        if($update){
            return redirect('/ticket/' . $ticket['t_id'])->with('success', 'Ticket ' . $ticket['t_id'] . ' updated!');
        }else{
            return redirect('/tickets/' . $ticket['t_id'])->with('error', 'Failed to close ' . $ticket['t_id'] . '!');
        }
    }

    public function assignto(Request $request){
        $user = $request->validate([
            't_id' => ['required'],
            't_assignedto' => ['required'],
            't_status' => ['nullable'],
        ]);

        $assign = Ticket::where('t_id', $user['t_id'])
        ->update([
            't_assignedto' => $user['t_assignedto'],
            't_assignedby' => Auth::user()->id,
            't_assigneddate' => now(),
            'updated_at' => now(),
            't_status' => 3
        ]);
        
        if($assign){
            //SENDING EMAIL TO TICKET CREATOR
            // $ticketcreator = User::select('id')
            // ->join('tickets', 'users.id', 'tickets.t_createdby')
            // ->where('tickets.t_id', $user['t_id'])
            // ->first();
            // $user2 = Ticket::select('users.id', 'users.u_email')
            // ->join('users', 'tickets.t_createdby', 'users.id')
            // ->where('tickets.t_createdby', $ticketcreator->id)
            // ->first();
            // $todepartment = User::select('tickets.t_id', 'tickets.t_title', 'tickets.t_description', 'users.u_fname', 'users.u_lname', 'departments.d_description')
            // ->join('departments', 'users.u_department', 'departments.d_id')
            // ->join('tickets', 'users.id', 'tickets.t_assignedto')
            // ->where('tickets.t_id', $user['t_id'])
            // ->orderby('tickets.t_id', 'desc')
            // ->first();
            // Mail::to($user2->u_email)->send(new TicketAssigned($todepartment));

            return redirect('/ticket/' . $user['t_id'])->with('success', 'Ticket ' . $user['t_id'] . ' assigned!');
        }else{
            return redirect('/tickets/' . $user['t_id'])->with('error', 'Failed to assign ' . $user['t_id'] . '!');
        }
    }

    public function searchticket(Request $request, $department, $myticket, $column, $order){
        $userid = Auth::user()->id;
$userdept = Auth::user()->u_department;

$searchitem = $request->validate(['searchitem' => ['required']]);
$userid = Auth::user()->id;
        $userdept = Auth::user()->u_department;

        $tickets = DB::table('tickets')
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

        // $ticketcount = DB::select("CALL ticketcount(?)", [$userdept]);

        $overallTickets = DB::table('tickets')->count();
            $perDept = DB::table('tickets')->where('t_todepartment', $userdept)->count();
            $myTickets = DB::table('tickets')->where('t_createdby', Auth::user()->id)->count();
            $newTickets = DB::table('tickets')->where('t_status', 1)->where('t_todepartment', $userdept)->count();
            $openTickets = DB::table('tickets')->where('t_status', 2)->where('t_todepartment', $userdept)->count();
            $assignedTickets = DB::table('tickets')->where('t_status', 3)->where('t_todepartment', $userdept)->count();
            $acknowledgedTickets = DB::table('tickets')->where('t_status', 4)->where('t_todepartment', $userdept)->count();
            $resolvedTickets = DB::table('tickets')->where('t_status', 5)->where('t_todepartment', $userdept)->count();
            $closedTickets = DB::table('tickets')->where('t_status', 6)->where('t_todepartment', $userdept)->count();
            $cancelledTickets = DB::table('tickets')->where('t_status', 7)->where('t_todepartment', $userdept)->count();
            $overdueTickets = DB::table('tickets')
            ->whereRaw("DATEDIFF(CURDATE(), tickets.created_at) > 7 AND tickets.t_severity = 0 AND tickets.t_status < 5")
            ->orWhereRaw("DATEDIFF(CURDATE(), tickets.created_at) > 7 AND tickets.t_severity = 1 AND tickets.t_status < 5")
            ->orWhereRaw("DATEDIFF(CURDATE(), tickets.created_at) > 5 AND tickets.t_severity = 2 AND tickets.t_status < 5")
            ->orWhereRaw("DATEDIFF(CURDATE(), tickets.created_at) > 3 AND tickets.t_severity = 3 AND tickets.t_status < 5")
            ->orWhereRaw("DATEDIFF(CURDATE(), tickets.created_at) > 1 AND tickets.t_severity = 4 AND tickets.t_status < 5")
            ->orWhereRaw("DATEDIFF(CURDATE(), tickets.created_at) > 1 AND tickets.t_severity = 5 AND tickets.t_status < 5")
            ->where('t_todepartment', $userdept)
            ->count();
            $ticketcount = [
            'overallTickets' => $overallTickets,
            'perDept' => $perDept,
            'myTickets' => $myTickets,
            'newTickets' => $newTickets,
            'openTickets' => $openTickets,
            'assignedTickets' => $assignedTickets,
            'acknowledgedTickets' => $acknowledgedTickets,
            'resolvedTickets' => $resolvedTickets,
            'closedTickets' => $closedTickets,
            'cancelledTickets' => $cancelledTickets,
            'overdueTickets' => $overdueTickets
            ];


        return view('tickets.tickets', compact('myticket', 'order', 'tickets', 'ticketcount'));
    }


    // SORTING
    public function sort($department, $myticket, $column, $order){
        $userid = Auth::user()->id;
        $userdept = Auth::user()->u_department;

        $tickets = DB::table('tickets')
        ->select('tickets.t_id as ticketid', 'tickets.t_title', 'departments.d_code', 'tickets.t_resolveddate',
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

            $overallTickets = DB::table('tickets')->count();
            $perDept = DB::table('tickets')->where('tickets.t_todepartment', $userdept)->orWhere('tickets.t_createdby', $userid)->count();
            $myTickets = DB::table('tickets')->where('t_createdby', $userid)->count();
            $newTickets = DB::table('tickets')->where('t_status', 1)->where('t_todepartment', $userdept)->count();
            $openTickets = DB::table('tickets')->where('t_status', 2)->where('t_todepartment', $userdept)->count();
            $assignedTickets = DB::table('tickets')->where('t_status', 3)->where('t_todepartment', $userdept)->count();
            $acknowledgedTickets = DB::table('tickets')->where('t_status', 4)->where('t_todepartment', $userdept)->count();
            $resolvedTickets = DB::table('tickets')->where('t_status', 5)->where('t_todepartment', $userdept)->count();
            $closedTickets = DB::table('tickets')->where('t_status', 6)->where('t_todepartment', $userdept)->count();
            $cancelledTickets = DB::table('tickets')->where('t_status', 7)->where('t_todepartment', $userdept)->count();
            $overdueTickets = DB::table('tickets')
            ->whereRaw("DATEDIFF(CURDATE(), tickets.created_at) > 7 AND tickets.t_severity = 0 AND tickets.t_status < 5")
            ->orWhereRaw("DATEDIFF(CURDATE(), tickets.created_at) > 7 AND tickets.t_severity = 1 AND tickets.t_status < 5")
            ->orWhereRaw("DATEDIFF(CURDATE(), tickets.created_at) > 5 AND tickets.t_severity = 2 AND tickets.t_status < 5")
            ->orWhereRaw("DATEDIFF(CURDATE(), tickets.created_at) > 3 AND tickets.t_severity = 3 AND tickets.t_status < 5")
            ->orWhereRaw("DATEDIFF(CURDATE(), tickets.created_at) > 1 AND tickets.t_severity = 4 AND tickets.t_status < 5")
            ->orWhereRaw("DATEDIFF(CURDATE(), tickets.created_at) > 1 AND tickets.t_severity = 5 AND tickets.t_status < 5")
            ->where('t_todepartment', $userdept)
            ->count();
            $ticketcount = [
            'overallTickets' => $overallTickets,
            'perDept' => $perDept,
            'myTickets' => $myTickets,
            'newTickets' => $newTickets,
            'openTickets' => $openTickets,
            'assignedTickets' => $assignedTickets,
            'acknowledgedTickets' => $acknowledgedTickets,
            'resolvedTickets' => $resolvedTickets,
            'closedTickets' => $closedTickets,
            'cancelledTickets' => $cancelledTickets,
            'overdueTickets' => $overdueTickets,
            ];

        // $ticketcount = DB::select("CALL ticketcount(?)", [$userdept]);        

        return view('tickets.tickets', compact('myticket', 'order', 'tickets', 'ticketcount'));
    }

}


