<?php

namespace App\Http\Controllers;

use App\Charts\TicketChart;
use App\Charts\ResolvedChart;
use App\Charts\CreatedTicketChart;
use App\Charts\CancelledTicketChart;
use App\Charts\ResolversChart;
use Illuminate\Support\Facades\Auth;
use App\Models\Department;
use App\Models\Ticket;

class DashboardController extends Controller
{
    public $departmentCode;
    public $totalTickets;

    public function __construct(Department $departmentCode, Ticket $totalTickets){
        $this->departmentCode = $departmentCode;
        $this->totalTickets = $totalTickets;
    }
    public function dashboard(TicketChart $tickets, ResolvedChart $resolved, CreatedTicketChart $createdticket, CancelledTicketChart $cancelled, ResolversChart $resolvers){
        $department = Auth::user()->u_department;
        $filter = 'mytickets';
        $sortBy = 'ticketid';
        $sortOrder = 'desc';
        if(Auth::user()->u_role === 2){
            return redirect()->intended('/' . $department . '/tickets/' . $filter . '/' . $sortBy . '/' . $sortOrder)->with('success', 'Welcome back ' . Auth::user()->u_fname . '!');
        }

        $userdept = $this->departmentCode->getUserDepartment($department);

        $totalTickets = $this->totalTickets->getAllTicketCount();


        return view('dashboard.dashboard',
            [
                'tickets' => $tickets->build(),
                'resolved' => $resolved->build(),
                'createdticket' => $createdticket->build(),
                'cancelled' => $cancelled->build(),
                'resolvers' => $resolvers->build(),
            ],
            compact('userdept', 'totalTickets')
        );
    }
}
