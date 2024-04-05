<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DepartmentTicketChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\LineChart
    {
        $userDept = Auth::user()->u_department;
        $departments = Ticket::select('departments.d_code',
            DB::raw("(SELECT COUNT('*') FROM tickets WHERE tickets.t_todepartment=$userDept AND MONTH(tickets.created_at) = 01 AND YEAR(tickets.created_at) = YEAR(CURRENT_DATE())) as jancreated"),
            DB::raw("(SELECT COUNT('*') FROM tickets WHERE tickets.t_todepartment=$userDept AND MONTH(tickets.created_at) = 02 AND YEAR(tickets.created_at) = YEAR(CURRENT_DATE())) as febcreated"),
            DB::raw("(SELECT COUNT('*') FROM tickets WHERE tickets.t_todepartment=$userDept AND MONTH(tickets.created_at) = 02 AND YEAR(tickets.created_at) = YEAR(CURRENT_DATE())) as marcreated"),
            DB::raw("(SELECT COUNT('*') FROM tickets WHERE tickets.t_todepartment=$userDept AND MONTH(tickets.created_at) = 02 AND YEAR(tickets.created_at) = YEAR(CURRENT_DATE())) as aprcreated"),
        )
        ->join('users', 'tickets.t_createdby', 'users.id')
        ->join('departments', 'users.id', 'departments.d_id')
        ->groupBy('departments.d_code', 'jancreated')
        ->get();
        
        $chart = $this->chart->lineChart();

        foreach($departments as $department){
            $chart->addData($department->d_code, [$department->jancreated, $department->febcreated, $department->marcreated, $department->aprcreated]);
        }

        return $chart->setXAxis(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
    }
}
