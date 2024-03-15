<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class CreatedTicketChart
{
    protected $createdticket;

    public function __construct(LarapexChart $createdticket)
    {
        $this->createdticket = $createdticket;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $userdept = Auth::user()->u_department;
        $jan = Ticket::where('created_at', 'LIKE',  now()->year . '-' . '01' . '%')->where('tickets.t_todepartment', $userdept)->count();
        $feb = Ticket::where('created_at', 'LIKE',  now()->year . '-' . '02' . '%')->where('tickets.t_todepartment', $userdept)->count();
        $mar = Ticket::where('created_at', 'LIKE',  now()->year . '-' . '03' . '%')->where('tickets.t_todepartment', $userdept)->count();
        $apr = Ticket::where('created_at', 'LIKE',  now()->year . '-' . '04' . '%')->where('tickets.t_todepartment', $userdept)->count();
        $may = Ticket::where('created_at', 'LIKE',  now()->year . '-' . '05' . '%')->where('tickets.t_todepartment', $userdept)->count();
        $jun = Ticket::where('created_at', 'LIKE',  now()->year . '-' . '06' . '%')->where('tickets.t_todepartment', $userdept)->count();
        $jul = Ticket::where('created_at', 'LIKE',  now()->year . '-' . '07' . '%')->where('tickets.t_todepartment', $userdept)->count();
        $aug = Ticket::where('created_at', 'LIKE',  now()->year . '-' . '08' . '%')->where('tickets.t_todepartment', $userdept)->count();
        $sep = Ticket::where('created_at', 'LIKE',  now()->year . '-' . '09' . '%')->where('tickets.t_todepartment', $userdept)->count();
        $oct = Ticket::where('created_at', 'LIKE',  now()->year . '-' . '10' . '%')->where('tickets.t_todepartment', $userdept)->count();
        $nov = Ticket::where('created_at', 'LIKE',  now()->year . '-' . '11' . '%')->where('tickets.t_todepartment', $userdept)->count();
        $dec = Ticket::where('created_at', 'LIKE',  now()->year . '-' . '12' . '%')->where('tickets.t_todepartment', $userdept)->count();
        return $this->createdticket->barChart()
            ->addData('Tickets', [$jan, $feb, $mar, $apr, $may, $jun, $jul, $aug, $sep, $oct, $nov, $dec])
            ->setFontColor('inherit')
            ->setXAxis(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);
    }
}
