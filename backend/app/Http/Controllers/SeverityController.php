<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SeverityController extends Controller
{
    public function newseverity(){
        return view('severities.newseverity');
    }
}
