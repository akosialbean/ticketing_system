<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\TicketChart;
use App\Charts\ResolvedChart;
use App\Charts\CreatedTicketChart;
use App\Charts\CancelledTicketChart;
use Illuminate\Support\Facades\Auth;
use App\Models\Department;
use App\Models\Ticket;
use App\Models\User;

class DashboardController extends Controller
{
    public function dashboard(TicketChart $tickets, ResolvedChart $resolved, CreatedTicketChart $createdticket, CancelledTicketChart $cancelled){
        $userdept = Department::where('d_id', Auth::user()->u_department)->first();
        return view('dashboard.dashboard', [
            'tickets' => $tickets->build(),
            'resolved' => $resolved->build(),
            'createdticket' => $createdticket->build(),
            'cancelled' => $cancelled->build(),
        ],
        compact('userdept')
        );
    }
}
