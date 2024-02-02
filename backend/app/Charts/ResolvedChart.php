<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Ticket;

class ResolvedChart
{
    protected $resolved;

    public function __construct(LarapexChart $resolved)
    {
        $this->resolved = $resolved;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $resolved = Ticket::where('t_status', 5)->count();
        $closedresolved = Ticket::where('t_status', 6)->count();
        $unresolved = Ticket::where('t_status', '!=', 6)->orwhere('t_status', '!=', 7)->count();
        return $this->resolved->pieChart()
            ->setTitle('Closed vs Unresolved Tickets')
            ->addData([$resolved, $closedresolved, $unresolved])
            ->setLabels(['Resolved', 'Closed-Resolved', 'Unresolved']);
    }
}
