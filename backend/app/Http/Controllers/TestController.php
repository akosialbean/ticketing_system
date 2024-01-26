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
            'message' => 'This is a test email.'
        ];

        Mail::to('alvincastor30@gmail.com')->send(new SampleMail($data));

        return 'Email sent successfully!';
    }
}
