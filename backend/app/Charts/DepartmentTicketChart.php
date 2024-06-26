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
            DB::raw("(SELECT COUNT('*') FROM tickets WHERE tickets.t_fromdepartment=departments.d_id AND MONTH(tickets.created_at) = 01 AND YEAR(tickets.created_at) = YEAR(CURRENT_DATE())) as jancreated"),
            DB::raw("(SELECT COUNT('*') FROM tickets WHERE tickets.t_fromdepartment=departments.d_id AND MONTH(tickets.created_at) = 02 AND YEAR(tickets.created_at) = YEAR(CURRENT_DATE())) as febcreated"),
            DB::raw("(SELECT COUNT('*') FROM tickets WHERE tickets.t_fromdepartment=departments.d_id AND MONTH(tickets.created_at) = 03 AND YEAR(tickets.created_at) = YEAR(CURRENT_DATE())) as marcreated"),
            DB::raw("(SELECT COUNT('*') FROM tickets WHERE tickets.t_fromdepartment=departments.d_id AND MONTH(tickets.created_at) = 04 AND YEAR(tickets.created_at) = YEAR(CURRENT_DATE())) as aprcreated"),
            DB::raw("(SELECT COUNT('*') FROM tickets WHERE tickets.t_fromdepartment=departments.d_id AND MONTH(tickets.created_at) = 05 AND YEAR(tickets.created_at) = YEAR(CURRENT_DATE())) as maycreated"),
            DB::raw("(SELECT COUNT('*') FROM tickets WHERE tickets.t_fromdepartment=departments.d_id AND MONTH(tickets.created_at) = 06 AND YEAR(tickets.created_at) = YEAR(CURRENT_DATE())) as juncreated"),
            DB::raw("(SELECT COUNT('*') FROM tickets WHERE tickets.t_fromdepartment=departments.d_id AND MONTH(tickets.created_at) = 07 AND YEAR(tickets.created_at) = YEAR(CURRENT_DATE())) as julcreated"),
            DB::raw("(SELECT COUNT('*') FROM tickets WHERE tickets.t_fromdepartment=departments.d_id AND MONTH(tickets.created_at) = 08 AND YEAR(tickets.created_at) = YEAR(CURRENT_DATE())) as augcreated"),
            DB::raw("(SELECT COUNT('*') FROM tickets WHERE tickets.t_fromdepartment=departments.d_id AND MONTH(tickets.created_at) = 09 AND YEAR(tickets.created_at) = YEAR(CURRENT_DATE())) as sepcreated"),
            DB::raw("(SELECT COUNT('*') FROM tickets WHERE tickets.t_fromdepartment=departments.d_id AND MONTH(tickets.created_at) = 10 AND YEAR(tickets.created_at) = YEAR(CURRENT_DATE())) as octcreated"),
            DB::raw("(SELECT COUNT('*') FROM tickets WHERE tickets.t_fromdepartment=departments.d_id AND MONTH(tickets.created_at) = 11 AND YEAR(tickets.created_at) = YEAR(CURRENT_DATE())) as novcreated"),
            DB::raw("(SELECT COUNT('*') FROM tickets WHERE tickets.t_fromdepartment=departments.d_id AND MONTH(tickets.created_at) = 12 AND YEAR(tickets.created_at) = YEAR(CURRENT_DATE())) as deccreated"),
        )
        ->join('departments', 'tickets.t_fromdepartment', 'departments.d_id')
        ->where('tickets.t_todepartment', $userDept)
        ->groupBy('tickets.t_fromdepartment', 'departments.d_id', 'departments.d_code', 'jancreated', 'febcreated', 'marcreated', 'aprcreated', 'maycreated', 'juncreated', 'julcreated', 'augcreated','sepcreated', 'octcreated', 'novcreated', 'deccreated')
        // ->groupBy('departments.d_id', 'departments.d_code', 'jancreated', 'febcreated', 'marcreated', 'aprcreated', 'maycreated')
        ->get();

        $chart = $this->chart->lineChart();

        foreach($departments as $department){
            $chart->addData($department->d_code, [
                $department->jancreated,
                $department->febcreated,
                $department->marcreated,
                $department->aprcreated,
                $department->maycreated,
                $department->juncreated,
                $department->julcreated,
                $department->augcreated,
                $department->sepcreated,
                $department->octcreated,
                $department->novcreated,
                $department->deccreated,
            ]);
        }

        return $chart->setXAxis(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);

    }
}
