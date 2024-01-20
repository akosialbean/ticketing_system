<?php

namespace App\Http\Controllers;
use App\Models\Department;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Severity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function newticket(){
        $getDepartments = Department::where('d_status', 1)->orderby('d_description', 'asc')->get();
        $getCategories = Category::where('c_status', 1)->orderby('c_description', 'asc')->get();
        return view('tickets.newticket', ['departments' => $getDepartments, 'categories' => $getCategories]);
    }

    public function add(Request $request){
        // dd($request);
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
            if(Auth::user()->u_role == 1){
                return redirect('/tickets')->with('success', 'New ticket created!');
            }else{
                return redirect('/tickets/mytickets')->with('success', 'New ticket created!');
            }
        }else{
            return redirect('/tickets')->with('error', 'Failed to create!');
        }
    }

    public function alltickets(){
        if(Auth::user()->u_role == 2){
            return redirect()->intended('/tickets/mytickets');
        }else{
            $tickets = Ticket::select('tickets.*', 'tickets.t_createdby', 'departments.d_id', 'departments.d_description', 'users.id', 'users.u_fname', 'users.u_lname')
            ->where('tickets.t_todepartment', Auth::user()->u_department)
            ->join('users', 'tickets.t_createdby', '=', 'users.id')
            ->join('departments', 'users.u_department', '=', 'departments.d_id')
            ->orderby('t_id', 'desc')->paginate(10);

            $allticketcount = Ticket::where('t_todepartment', Auth::user()->u_department)->count();
            $myticketcount = Ticket::where('t_createdby', Auth::user()->id)->count();
            $openticketcount = Ticket::where('t_status', 2)->count();
            $assignedticketcount = Ticket::where('t_status', 3)->where('t_assignedto', Auth::user()->id)->count();
            $acknowledgedticketcount = Ticket::where('t_status', 4)->count();
            $resolvedticketcount = Ticket::where('t_status', 5)->count();
            $closedticketcount = Ticket::where('t_status', 6)->count();
            $cancelledticketcount = Ticket::where('t_status', 7)->count();

            return view('tickets.alltickets', compact('tickets', 'allticketcount', 'openticketcount', 'myticketcount', 'acknowledgedticketcount', 'resolvedticketcount', 'closedticketcount', 'cancelledticketcount', 'assignedticketcount'));
        }
    }

    public function assignedtickets(){
        if(Auth::user()->u_role == 2){
            return redirect()->intended('/tickets/mytickets');
        }else{
            $tickets = Ticket::select('tickets.*', 'tickets.t_createdby', 'departments.d_id', 'departments.d_description', 'users.id', 'users.u_fname', 'users.u_lname')
            ->join('users', 'tickets.t_createdby', '=', 'users.id')
            ->join('departments', 'users.u_department', '=', 'departments.d_id')
            ->where('tickets.t_todepartment', Auth::user()->u_department)
            ->where('tickets.t_assignedto', Auth::user()->id)
            ->orderby('t_id', 'desc')->paginate(10);

            $allticketcount = Ticket::where('t_todepartment', Auth::user()->u_department)->count();
            $myticketcount = Ticket::where('t_createdby', Auth::user()->id)->count();
            $openticketcount = Ticket::where('t_status', 2)->count();
            $assignedticketcount = Ticket::where('t_status', 3)->where('t_assignedto', Auth::user()->id)->count();
            $acknowledgedticketcount = Ticket::where('t_status', 4)->count();
            $resolvedticketcount = Ticket::where('t_status', 5)->count();
            $closedticketcount = Ticket::where('t_status', 6)->count();
            $cancelledticketcount = Ticket::where('t_status', 7)->count();

            return view('tickets.assignedtickets', compact('tickets', 'allticketcount', 'openticketcount', 'myticketcount', 'acknowledgedticketcount', 'resolvedticketcount', 'closedticketcount', 'cancelledticketcount', 'assignedticketcount'));
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
                return redirect('/ticket/' . $ticket['t_id'])->with('success', 'Ticket ' . $ticket['t_id'] . ' opened!');
            }else{
                return redirect('/tickets')->with('error', 'Failed to open ticket ' . $ticket['t_id'] . '!');
            }
        }else{
            return redirect('/ticket/' . $ticket['t_id']);
        }
        
    }

    public function ticket($ticket){
        $tickets = DB::table('tickets')
            ->rightJoin('categories', 'categories.c_id', 'tickets.t_category')
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
        ->where('users.u_role', '1')->get();

        $assignedto = DB::table('tickets')
            ->join('users', 'tickets.t_assignedto', 'users.id')
            ->where('tickets.t_id', $ticket)
            ->first();

        return view('tickets.ticket', compact('tickets', 'openedby', 'acknowledgedby', 'resolvedby', 'closedby', 'cancelledby', 'createdby', 'severities', 'resolvers', 'assignedto'));
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
            return redirect('/ticket/' . $ticket['t_id'])->with('success', 'Ticket ' . $ticket['t_id'] . ' cancelled!');
        }else{
            return redirect('/tickets')->with('error', 'Failed to cancel ' . $ticket['t_id'] . '!');
        }
    }

    public function mytickets(){
        $tickets = Ticket::select('tickets.*', 'tickets.t_createdby', 'departments.d_id', 'departments.d_description', 'users.id', 'users.u_fname', 'users.u_lname')
        ->where('t_createdby', Auth::user()->id)
        ->join('users', 'tickets.t_createdby', '=', 'users.id')
        ->join('departments', 'users.u_department', '=', 'departments.d_id')
        ->orderby('t_id', 'desc')->paginate(10);

        $allticketcount = Ticket::where('t_todepartment', Auth::user()->u_department)->count();
        $myticketcount = Ticket::where('t_createdby', Auth::user()->id)->count();
        $openticketcount = Ticket::where('t_status', 2)->count();
        $assignedticketcount = Ticket::where('t_status', 3)->where('t_assignedto', Auth::user()->id)->count();
        $acknowledgedticketcount = Ticket::where('t_status', 4)->count();
        $resolvedticketcount = Ticket::where('t_status', 5)->count();
        $closedticketcount = Ticket::where('t_status', 6)->count();
        $cancelledticketcount = Ticket::where('t_status', 7)->count();

        return view('tickets.mytickets', compact('tickets', 'allticketcount', 'openticketcount', 'myticketcount', 'acknowledgedticketcount', 'resolvedticketcount', 'closedticketcount', 'cancelledticketcount', 'assignedticketcount'));
    }

    public function opentickets(){
        if(Auth::user()->u_role == 2){
            return redirect()->intended('/tickets/mytickets');
        }else{
            $tickets = Ticket::select('tickets.*', 'tickets.t_createdby', 'departments.d_id', 'departments.d_description', 'users.id', 'users.u_fname', 'users.u_lname')
            ->where('tickets.t_status', 2)
            ->join('users', 'tickets.t_createdby', '=', 'users.id')
            ->join('departments', 'users.u_department', '=', 'departments.d_id')
            ->orderby('t_id', 'desc')->paginate(10);

            $allticketcount = Ticket::where('t_todepartment', Auth::user()->u_department)->count();
            $myticketcount = Ticket::where('t_createdby', Auth::user()->id)->count();
            $openticketcount = Ticket::where('t_status', 2)->count();
            $assignedticketcount = Ticket::where('t_status', 3)->where('t_assignedto', Auth::user()->id)->count();
            $acknowledgedticketcount = Ticket::where('t_status', 4)->count();
            $resolvedticketcount = Ticket::where('t_status', 5)->count();
            $closedticketcount = Ticket::where('t_status', 6)->count();
            $cancelledticketcount = Ticket::where('t_status', 7)->count();

            return view('tickets.opentickets', compact('tickets', 'allticketcount', 'openticketcount', 'myticketcount', 'acknowledgedticketcount', 'resolvedticketcount', 'closedticketcount', 'cancelledticketcount', 'assignedticketcount'));
        }
    }

    public function acknowledgedtickets(){
        if(Auth::user()->u_role == 2){
            return redirect()->intended('/tickets/mytickets');
        }else{
            $tickets = Ticket::select('tickets.*', 'tickets.t_createdby', 'departments.d_id', 'departments.d_description', 'users.id', 'users.u_fname', 'users.u_lname')
            ->where('tickets.t_status', 4)
            ->join('users', 'tickets.t_createdby', '=', 'users.id')
            ->join('departments', 'users.u_department', '=', 'departments.d_id')
            ->orderby('t_id', 'desc')->paginate(10);

            $allticketcount = Ticket::where('t_todepartment', Auth::user()->u_department)->count();
            $myticketcount = Ticket::where('t_createdby', Auth::user()->id)->count();
            $openticketcount = Ticket::where('t_status', 2)->count();
            $assignedticketcount = Ticket::where('t_status', 3)->where('t_assignedto', Auth::user()->id)->count();
            $acknowledgedticketcount = Ticket::where('t_status', 4)->count();
            $resolvedticketcount = Ticket::where('t_status', 5)->count();
            $closedticketcount = Ticket::where('t_status', 6)->count();
            $cancelledticketcount = Ticket::where('t_status', 7)->count();

            return view('tickets.acknowledgedtickets', compact('tickets', 'allticketcount', 'openticketcount', 'myticketcount', 'acknowledgedticketcount', 'resolvedticketcount', 'closedticketcount', 'cancelledticketcount', 'assignedticketcount'));
        }
    }

    public function resolvedtickets(){
        if(Auth::user()->u_role == 2){
            return redirect()->intended('/tickets/mytickets');
        }else{
            $tickets = Ticket::select('tickets.*', 'tickets.t_createdby', 'departments.d_id', 'departments.d_description', 'users.id', 'users.u_fname', 'users.u_lname')
            ->where('tickets.t_status', 5)
            ->join('users', 'tickets.t_createdby', '=', 'users.id')
            ->join('departments', 'users.u_department', '=', 'departments.d_id')
            ->orderby('t_id', 'desc')->paginate(10);

            $allticketcount = Ticket::where('t_todepartment', Auth::user()->u_department)->count();
            $myticketcount = Ticket::where('t_createdby', Auth::user()->id)->count();
            $openticketcount = Ticket::where('t_status', 2)->count();
            $assignedticketcount = Ticket::where('t_status', 3)->where('t_assignedto', Auth::user()->id)->count();
            $acknowledgedticketcount = Ticket::where('t_status', 4)->count();
            $resolvedticketcount = Ticket::where('t_status', 5)->count();
            $closedticketcount = Ticket::where('t_status', 6)->count();
            $cancelledticketcount = Ticket::where('t_status', 7)->count();

            return view('tickets.resolvedtickets', compact('tickets', 'allticketcount', 'openticketcount', 'myticketcount', 'acknowledgedticketcount', 'resolvedticketcount', 'closedticketcount', 'cancelledticketcount', 'assignedticketcount'));
        }
    }

    public function closedtickets(){
        if(Auth::user()->u_role == 2){
            return redirect()->intended('/tickets/mytickets');
        }else{
            $tickets = DB::table('tickets')
            ->where('tickets.t_status', 6)
            ->join('users', 'tickets.t_createdby', '=', 'users.id')
            ->join('departments', 'users.u_department', '=', 'departments.d_id')
            ->orderby('t_id', 'desc')->paginate(10);

            $allticketcount = Ticket::where('t_todepartment', Auth::user()->u_department)->count();
            $myticketcount = Ticket::where('t_createdby', Auth::user()->id)->count();
            $openticketcount = Ticket::where('t_status', 2)->count();
            $assignedticketcount = Ticket::where('t_status', 3)->where('t_assignedto', Auth::user()->id)->count();
            $acknowledgedticketcount = Ticket::where('t_status', 4)->count();
            $resolvedticketcount = Ticket::where('t_status', 5)->count();
            $closedticketcount = Ticket::where('t_status', 6)->count();
            $cancelledticketcount = Ticket::where('t_status', 7)->count();

            return view('tickets.closedtickets', compact('tickets', 'allticketcount', 'openticketcount', 'myticketcount', 'acknowledgedticketcount', 'resolvedticketcount', 'closedticketcount', 'cancelledticketcount', 'assignedticketcount'));
        }
    }

    public function cancelledtickets(){
        if(Auth::user()->u_role == 2){
            return redirect()->intended('/tickets/mytickets');
        }else{
            $tickets = DB::table('tickets')
            ->where('tickets.t_status', 7)
            ->join('users', 'tickets.t_createdby', '=', 'users.id')
            ->join('departments', 'users.u_department', '=', 'departments.d_id')
            ->orderby('t_id', 'desc')->paginate(10);

            $allticketcount = Ticket::where('t_todepartment', Auth::user()->u_department)->count();
            $myticketcount = Ticket::where('t_createdby', Auth::user()->id)->count();
            $openticketcount = Ticket::where('t_status', 2)->count();
            $assignedticketcount = Ticket::where('t_status', 3)->where('t_assignedto', Auth::user()->id)->count();
            $acknowledgedticketcount = Ticket::where('t_status', 4)->count();
            $resolvedticketcount = Ticket::where('t_status', 5)->count();
            $closedticketcount = Ticket::where('t_status', 6)->count();
            $cancelledticketcount = Ticket::where('t_status', 7)->count();

            return view('tickets.cancelledtickets', compact('tickets', 'allticketcount', 'openticketcount', 'myticketcount', 'acknowledgedticketcount', 'resolvedticketcount', 'closedticketcount', 'cancelledticketcount', 'assignedticketcount'));
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
            return redirect('/ticket/' . $user['t_id'])->with('success', 'Ticket ' . $user['t_id'] . ' assigned!');
        }else{
            return redirect('/tickets/' . $user['t_id'])->with('error', 'Failed to assign ' . $user['t_id'] . '!');
        }
    }
}