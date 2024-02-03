<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Ticket;

class TicketChart
{
    protected $tickets;

    public function __construct(LarapexChart $tickets)
    {
        $this->tickets = $tickets;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $newTicket = Ticket::where('tickets.t_status', 1)->count();
        $viewedTicket = Ticket::where('tickets.t_status', 2)->count();
        $assignedTicket = Ticket::where('tickets.t_status', 3)->count();
        $acknowledgedTicket = Ticket::where('tickets.t_status', 4)->count();

        return $this->tickets->pieChart()
            ->setTitle('WMC Tickets')
            ->addData([$newTicket, $viewedTicket, $assignedTicket, $acknowledgedTicket])
            ->setLabels(['New', 'Viewed', 'Assigned', 'Acknowledged']);
    }
}