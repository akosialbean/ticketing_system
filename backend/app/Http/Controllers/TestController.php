<?php

namespace App\Http\Controllers;
use App\Mail\SampleMail;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function sendEmail(){
        $data = [
            'name' => 'IT Helpdesk',
            'message' => 'This is a test email 2.'
        ];

        Mail::to('ithelpdesk@westlakemed.com.ph')->send(new SampleMail($data));

        return 'Email sent successfully!';
    }
}
