<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Ticket;

class CancelledTicketChart
{
    protected $cancelled;

    public function __construct(LarapexChart $cancelled)
    {
        $this->cancelled = $cancelled;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $closed = Ticket::where('t_status', 6)->count();
        $cancelled = Ticket::where('t_status', 7)->count();

        return $this->cancelled->pieChart()
            ->setTitle('Cancelled vs Closed-Resolved Tickets')
            ->addData([$closed, $cancelled])
            ->setLabels(['Closed-Resolved', 'Cancelled']);
    }
}
