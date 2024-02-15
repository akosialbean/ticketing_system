<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class CancelledTicketChart
{
    protected $cancelled;

    public function __construct(LarapexChart $cancelled)
    {
        $this->cancelled = $cancelled;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $userdept = Auth::user()->u_department;
        $closed = Ticket::where('t_status', 6)->where('tickets.t_todepartment', $userdept)->count();
        $cancelled = Ticket::where('t_status', 7)->where('tickets.t_todepartment', $userdept)->count();

        return $this->cancelled->pieChart()
            ->addData([$closed, $cancelled])
            ->setLabels(['Closed-Resolved', 'Cancelled']);
    }
}
