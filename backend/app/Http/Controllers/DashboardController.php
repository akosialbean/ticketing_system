<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\TicketChart;
use App\Charts\ResolvedChart;
use App\Charts\CreatedTicketChart;

class DashboardController extends Controller
{
    public function dashboard(TicketChart $tickets, ResolvedChart $resolved, CreatedTicketChart $createdticket){
        return view('dashboard.dashboard', ['tickets' => $tickets->build(), 'resolved' => $resolved->build(), 'createdticket' => $createdticket->build()]);
    }
}
