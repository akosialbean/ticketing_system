<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ResolversChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\LineChart
    {
        $resolvers = User::select('users.u_fname', 'users.u_lname',
        DB::raw("(SELECT COUNT('*') FROM tickets WHERE tickets.t_status = 6 AND tickets.t_resolvedby = users.id AND MONTH(tickets.t_closeddate) = 01 AND YEAR(tickets.t_closeddate) = YEAR(CURRENT_DATE())) as janresolved"),
        DB::raw("(SELECT COUNT('*') FROM tickets WHERE tickets.t_status = 6 AND tickets.t_resolvedby = users.id AND MONTH(tickets.t_closeddate) = 02 AND YEAR(tickets.t_closeddate) = YEAR(CURRENT_DATE())) as febresolved"),
        DB::raw("(SELECT COUNT('*') FROM tickets WHERE tickets.t_status = 6 AND tickets.t_resolvedby = users.id AND MONTH(tickets.t_closeddate) = 03 AND YEAR(tickets.t_closeddate) = YEAR(CURRENT_DATE())) as marresolved"),
        DB::raw("(SELECT COUNT('*') FROM tickets WHERE tickets.t_status = 6 AND tickets.t_resolvedby = users.id AND MONTH(tickets.t_closeddate) = 04 AND YEAR(tickets.t_closeddate) = YEAR(CURRENT_DATE())) as aprresolved"),
        DB::raw("(SELECT COUNT('*') FROM tickets WHERE tickets.t_status = 6 AND tickets.t_resolvedby = users.id AND MONTH(tickets.t_closeddate) = 05 AND YEAR(tickets.t_closeddate) = YEAR(CURRENT_DATE())) as mayresolved"),
        DB::raw("(SELECT COUNT('*') FROM tickets WHERE tickets.t_status = 6 AND tickets.t_resolvedby = users.id AND MONTH(tickets.t_closeddate) = 06 AND YEAR(tickets.t_closeddate) = YEAR(CURRENT_DATE())) as junresolved"),
        DB::raw("(SELECT COUNT('*') FROM tickets WHERE tickets.t_status = 6 AND tickets.t_resolvedby = users.id AND MONTH(tickets.t_closeddate) = 07 AND YEAR(tickets.t_closeddate) = YEAR(CURRENT_DATE())) as julresolved"),
        DB::raw("(SELECT COUNT('*') FROM tickets WHERE tickets.t_status = 6 AND tickets.t_resolvedby = users.id AND MONTH(tickets.t_closeddate) = 08 AND YEAR(tickets.t_closeddate) = YEAR(CURRENT_DATE())) as augresolved"),
        DB::raw("(SELECT COUNT('*') FROM tickets WHERE tickets.t_status = 6 AND tickets.t_resolvedby = users.id AND MONTH(tickets.t_closeddate) = 09 AND YEAR(tickets.t_closeddate) = YEAR(CURRENT_DATE())) as sepresolved"),
        DB::raw("(SELECT COUNT('*') FROM tickets WHERE tickets.t_status = 6 AND tickets.t_resolvedby = users.id AND MONTH(tickets.t_closeddate) = 10 AND YEAR(tickets.t_closeddate) = YEAR(CURRENT_DATE())) as octresolved"),
        DB::raw("(SELECT COUNT('*') FROM tickets WHERE tickets.t_status = 6 AND tickets.t_resolvedby = users.id AND MONTH(tickets.t_closeddate) = 11 AND YEAR(tickets.t_closeddate) = YEAR(CURRENT_DATE())) as novresolved"),
        DB::raw("(SELECT COUNT('*') FROM tickets WHERE tickets.t_status = 6 AND tickets.t_resolvedby = users.id AND MONTH(tickets.t_closeddate) = 12 AND YEAR(tickets.t_closeddate) = YEAR(CURRENT_DATE())) as decresolved"),
        )
        ->where('users.u_department', Auth::user()->u_department)
        ->where('users.u_fname', '!=', 'WMC')
        -orWwhere('users.u_lname', '!=', 'Admin')
        ->groupBy('users.id', 'users.u_fname', 'users.u_lname')
        ->get();
        $chart = $this->chart->lineChart();

        foreach($resolvers as $resolver){
            $chart->addData(($resolver->u_fname . ' ' . $resolver->u_lname), [$resolver->janresolved, $resolver->febresolved, $resolver->marresolved, $resolver->aprresolved, $resolver->mayresolved, $resolver->junresolved, $resolver->julresolved, $resolver->augresolved, $resolver->sepresolved, $resolver->octresolved, $resolver->novresolved, $resolver->decresolved]);
        }

        return $chart->setXAxis(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);
    }
}
