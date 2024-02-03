<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;
use App\Models\Ticket;

class CreatedTicketChart
{
    protected $createdticket;

    public function __construct(LarapexChart $createdticket)
    {
        $this->createdticket = $createdticket;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $jan = Ticket::where('created_at', 'LIKE',  now()->year . '-' . '01' . '%')->count();
        $feb = Ticket::where('created_at', 'LIKE',  now()->year . '-' . '02' . '%')->count();
        $mar = Ticket::where('created_at', 'LIKE',  now()->year . '-' . '03' . '%')->count();
        $apr = Ticket::where('created_at', 'LIKE',  now()->year . '-' . '04' . '%')->count();
        $may = Ticket::where('created_at', 'LIKE',  now()->year . '-' . '05' . '%')->count();
        $jun = Ticket::where('created_at', 'LIKE',  now()->year . '-' . '06' . '%')->count();
        $jul = Ticket::where('created_at', 'LIKE',  now()->year . '-' . '07' . '%')->count();
        $aug = Ticket::where('created_at', 'LIKE',  now()->year . '-' . '08' . '%')->count();
        $sep = Ticket::where('created_at', 'LIKE',  now()->year . '-' . '09' . '%')->count();
        $oct = Ticket::where('created_at', 'LIKE',  now()->year . '-' . '10' . '%')->count();
        $nov = Ticket::where('created_at', 'LIKE',  now()->year . '-' . '11' . '%')->count();
        $dec = Ticket::where('created_at', 'LIKE',  now()->year . '-' . '12' . '%')->count();
        return $this->createdticket->barChart()
            ->setTitle(now()->year . ' Tickets Created (Monthly)')
            ->addData('Tickets', [$jan, $feb, $mar, $apr, $may, $jun, $jul, $aug, $sep, $oct, $nov, $dec])
            ->setXAxis(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);
    }
}
