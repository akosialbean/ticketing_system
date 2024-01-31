<?php

namespace App\Http\Controllers;
use App\Mail\SampleMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

use Illuminate\Http\Request;

class TestController extends Controller
{
    // public function sendEmail(){
    //     $data = [
    //         'name' => 'IT Helpdesk',
    //         'message' => 'This is a test email 2.'
    //     ];

    //     Mail::to('ithelpdesk@westlakemed.com.ph')->send(new SampleMail($data));

    //     return 'Email sent successfully!';
    // }

    public function dateTimeDiff(){
        $date1 = Carbon::parse("2024-01-31 11:22:17");
        $date2 = Carbon::parse(now());

        $total = $date1->diff($date2);
        $days = $total->format('%a');
        $hours = $total->format('%h');
        $minutes = $total->format('%i');
        $seconds = $total->format('%s');

        return view('test.testview', compact('days', 'hours', 'minutes', 'seconds'));
    }
}
