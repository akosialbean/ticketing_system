<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class ResolvedChart
{
    protected $resolved;

    public function __construct(LarapexChart $resolved)
    {
        $this->resolved = $resolved;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $userdept = Auth::user()->u_department;
        $cancelled = Ticket::where('t_status', 7)->where('tickets.t_todepartment', $userdept)->count();
        $resolved = Ticket::where('t_status', 5)->where('tickets.t_todepartment', $userdept)->count();
        $closedresolved = Ticket::where('t_status', 6)->where('tickets.t_todepartment', $userdept)->count();
        $unresolved = Ticket::where('t_status', '!=', 5)->where('t_status', '!=', 6)->where('t_status', '!=', 7)->where('tickets.t_todepartment', $userdept)->count();
        return $this->resolved->pieChart()
            ->addData([$cancelled, $closedresolved, $unresolved, $resolved])
            ->setFontColor('inherit')
            ->setLabels(['Cancelled', 'Closed-Resolved', 'Unresolved', 'Resolved']);
    }
}
