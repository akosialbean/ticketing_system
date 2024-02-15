<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class TicketChart
{
    protected $tickets;

    public function __construct(LarapexChart $tickets)
    {
        $this->tickets = $tickets;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $userdept = Auth::user()->u_department;
        $newTicket = Ticket::where('tickets.t_status', 1)->where('tickets.t_todepartment', $userdept)->count();
        $viewedTicket = Ticket::where('tickets.t_status', 2)->where('tickets.t_todepartment', $userdept)->count();
        $assignedTicket = Ticket::where('tickets.t_status', 3)->where('tickets.t_todepartment', $userdept)->count();
        $acknowledgedTicket = Ticket::where('tickets.t_status', 4)->where('tickets.t_todepartment', $userdept)->count();

        return $this->tickets->pieChart()
            ->setTitle('WMC Tickets')
            ->addData([$newTicket, $viewedTicket, $assignedTicket, $acknowledgedTicket])
            ->setLabels(['New', 'Viewed', 'Assigned', 'Acknowledged']);
    }
}
