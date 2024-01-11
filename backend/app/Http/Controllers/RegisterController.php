<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function newuser(){
        return view('registration.registration');
    }

    public function registeruser(Request $request){
        
    }
}
