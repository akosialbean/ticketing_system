<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\TicketChart;
use App\Charts\ResolvedChart;

class DashboardController extends Controller
{
    public function dashboard(TicketChart $tickets, ResolvedChart $resolved){
        return view('dashboard.dashboard', ['tickets' => $tickets->build(), 'resolved' => $resolved->build()]);
    }
}
