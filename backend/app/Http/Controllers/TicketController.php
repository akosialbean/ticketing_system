<?php

namespace App\Http\Controllers;
use App\Models\Department;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Severity;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Mail;
// use App\Mail\TicketCreated;
// use App\Mail\HelpdeskNotification;
// use App\Mail\ViewedTicket;
// use App\Mail\TicketAssigned;
// use App\Mail\TicketAcknowledged;
// use App\Mail\TicketResolved;
// use App\Mail\TicketClosed;
// use App\Mail\TicketCancelled;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Illuminate\Http\Request;

class TicketController extends Controller
{
    public $ticketModel;
    public $categoryModel;
    public $departmentModel;

    public function __construct(Ticket $ticketModel, Category $categoryModel, Department $departmentModel){
        $this->ticketModel = $ticketModel;
        $this->categoryModel = $categoryModel;
        $this->departmentModel = $departmentModel;
    }
    public function newticket(){
        $departments = $this->departmentModel->getDepartmentCode();
        $categories = $this->categoryModel->getCategoryCodes();
        return view('tickets.newticket', compact('departments', 'categories'));
    }

    public function add(Request $request){
        $newticket = $request->validate([
            't_title' => ['required'],
            't_description' => ['required'],
            't_category' => ['required'],
            't_fromdepartment',
            't_todepartment' => ['required'],
            't_createdby',
            't_status',
            'created_at',
        ]);

        $files = $request->validate([
            't_files.*' => ['file', 'max:10240'],
        ]);

        $newticket['t_fromdepartment'] = Auth::user()->u_department;
        $newticket['t_createdby'] = Auth::user()->id;
        $newticket['t_status'] = 1;
        $newticket['created_at'] = now();

        $save = $this->ticketModel->createTicket($newticket);

        $getticketid = Ticket::select('t_id')->orderby('t_id', 'desc')->first();

        if($files){
            foreach ($files['t_files'] as $file) {
                $fileName = $getticketid->t_id . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('uploads', $fileName);
            }
        }

        if($save){
            // $delay = now()->addMinutes(1);
            // $ticketReceipt = Ticket::select('tickets.t_id', 'tickets.t_title', 'tickets.t_description', 'departments.d_description')
            //     ->join('departments', 'tickets.t_todepartment', 'd_id')
            //     ->join('users', 'tickets.t_createdby', 'users.id')
            //     ->where('tickets.t_createdby', $newticket['t_createdby'])
            //     ->orderby('tickets.t_id', 'desc')
            //     ->first();

            // Mail::to(Auth::user()->u_email)->send(new TicketCreated($ticketReceipt));

            // // // //SENDING EMAIL TO TICKET RESOLVER
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

                // $ticketviewer = User::where('id', Auth::user()->id)
                // ->rightJoin('departments', 'users.u_department', 'departments.d_id')
                // ->first();

                // $todepartment = User::select('tickets.t_id', 'tickets.t_title', 'tickets.t_description', 'users.u_fname', 'users.u_lname', 'departments.d_description')
                // ->join('departments', 'users.u_department', 'departments.d_id')
                // ->join('tickets', 'users.id', 'tickets.t_createdby')
                // ->where('tickets.t_id', $ticket['t_id'])
                // ->orderby('tickets.t_id', 'desc')
                // ->first();

                // Mail::to($creator->u_email)->send(new ViewedTicket($todepartment, $ticketviewer));

                return redirect('/ticket/' . $ticket['t_id'])->with('success', 'Ticket ' . $ticket['t_id'] . ' opened!');
            }else{
                return redirect()->route('tickets')->with('error', 'Failed to open ticket ' . $ticket['t_id'] . '!');
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

        $files = Storage::files('uploads');
        $filtered = [];
        foreach($files as $file){
            if(Str::startsWith(basename($file), $ticket)){
                $filtered[] = basename($file);
            }
        }

        return view('tickets.ticket', compact('filtered', 'comments', 'tickets', 'openedby', 'acknowledgedby', 'resolvedby', 'closedby', 'cancelledby', 'createdby', 'severities', 'resolvers', 'assignedto', 'days', 'hours', 'minutes', 'seconds'));
    }

    public function downloadfile($file){
        return Storage::download("uploads/{$file}");
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
            // $ticketviewer = User::where('id', Auth::user()->id)
            //     ->rightJoin('departments', 'users.u_department', 'departments.d_id')
            //     ->first();
            // $todepartment = User::select('tickets.t_id', 'tickets.t_title', 'tickets.t_description', 'users.u_fname', 'users.u_lname', 'departments.d_description')
            // ->join('departments', 'users.u_department', 'departments.d_id')
            // ->join('tickets', 'users.id', 'tickets.t_acknowledgedby')
            // ->where('tickets.t_id', $ticket['t_id'])
            // ->orderby('tickets.t_id', 'desc')
            // ->first();
            // Mail::to($user2->u_email)->send(new TicketAcknowledged($todepartment, $ticketviewer));

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
            // $ticketviewer = User::where('id', Auth::user()->id)
            //     ->rightJoin('departments', 'users.u_department', 'departments.d_id')
            //     ->first();
            // $todepartment = User::select('tickets.t_id', 'tickets.t_title', 'tickets.t_description', 'tickets.t_cancelreason', 'users.u_fname', 'users.u_lname', 'departments.d_description')
            // ->join('departments', 'users.u_department', 'departments.d_id')
            // ->join('tickets', 'users.id', 'tickets.t_cancelledby')
            // ->where('tickets.t_id', $ticket['t_id'])
            // ->orderby('tickets.t_id', 'desc')
            // ->first();
            // Mail::to($user2->u_email)->send(new TicketCancelled($todepartment, $ticketviewer));

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

    public function setSeverity(Request $request){
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

    public function assignTo(Request $request){
        $user = $request->validate([
            't_id' => ['required'],
            't_assignedto' => ['required'],
            't_status' => ['nullable'],
        ]);

        $assignedBy = Auth::user()->id;

        $assign = $this->ticketModel->assignTicket($user, $assignedBy);
        
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
            // $ticketviewer = User::where('id', Auth::user()->id)
            //     ->rightJoin('departments', 'users.u_department', 'departments.d_id')
            //     ->first();
            // $todepartment = User::select('tickets.t_id', 'tickets.t_title', 'tickets.t_description', 'users.u_fname', 'users.u_lname', 'departments.d_description')
            // ->join('departments', 'users.u_department', 'departments.d_id')
            // ->join('tickets', 'users.id', 'tickets.t_assignedto')
            // ->where('tickets.t_id', $user['t_id'])
            // ->orderby('tickets.t_id', 'desc')
            // ->first();
            // Mail::to($user2->u_email)->send(new TicketAssigned($todepartment, $ticketviewer));

            return redirect('/ticket/' . $user['t_id'])->with('success', 'Ticket ' . $user['t_id'] . ' assigned!');
        }else{
            return redirect('/tickets/' . $user['t_id'])->with('error', 'Failed to assign ' . $user['t_id'] . '!');
        }
    }

    public function searchticket(Request $request, $department, $myticket, $column, $order){
        $userid = Auth::user()->id;
        $userdept = Auth::user()->u_department;

        $searchitem = $request->validate(['searchitem' => ['required']]);

        $tickets = $this->ticketModel->searchTicket($department, $myticket, $column, $order, $userid, $userdept, $searchitem);

        $overallTickets = $this->ticketModel->getAllTicketCount();
        $perDept = $this->ticketModel->getTicketPerDepartmentCount($userdept, $userid);
        $myTickets = $this->ticketModel->getMyTicketsCount($userid);
        $newTickets = $this->ticketModel->getNewTicketsCount($userdept);
        $openTickets = $this->ticketModel->getOpenTicketsCount($userdept);
        $assignedTickets = $this->ticketModel->getAssignedTicketsCount($userdept);
        $acknowledgedTickets = $this->ticketModel->getAcknowledgedTicketsCount($userdept);
        $resolvedTickets = $this->ticketModel->getResolvedTicketsCount($userdept);
        $closedTickets = $this->ticketModel->getClosedTicketsCount($userdept);
        $cancelledTickets = $this->ticketModel->getcancelledTicketsCount($userdept);
        $overdueTickets = $this->ticketModel->getOverduedTicketsCount($userdept);
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

    public function sort($department, $myticket, $column, $order){
        $userid = Auth::user()->id;
        $userdept = Auth::user()->u_department;

        $tickets = $this->ticketModel->getAllTickets($department, $myticket, $column, $order, $userid, $userdept);

        if($tickets->count() == 0){
            $tickets = false;
        }

        $overallTickets = $this->ticketModel->getAllTicketCount();
        $perDept = $this->ticketModel->getTicketPerDepartmentCount($userdept, $userid);
        $myTickets = $this->ticketModel->getMyTicketsCount($userid);
        $newTickets = $this->ticketModel->getNewTicketsCount($userdept);
        $openTickets = $this->ticketModel->getOpenTicketsCount($userdept);
        $assignedTickets = $this->ticketModel->getAssignedTicketsCount($userdept);
        $acknowledgedTickets = $this->ticketModel->getAcknowledgedTicketsCount($userdept);
        $resolvedTickets = $this->ticketModel->getResolvedTicketsCount($userdept);
        $closedTickets = $this->ticketModel->getClosedTicketsCount($userdept);
        $cancelledTickets = $this->ticketModel->getcancelledTicketsCount($userdept);
        $overdueTickets = $this->ticketModel->getOverduedTicketsCount($userdept);
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

        return view('tickets.tickets', compact('myticket', 'order', 'tickets', 'ticketcount'));
    }
}