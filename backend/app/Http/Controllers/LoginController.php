<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(){
        return view('welcome');
    }

    public function log(Request $request): RedirectResponse{
        $userattempt = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        if(auth()->attempt($userattempt)){
            $request->session()->regenerate();
            return true;
        }else{
            $request->session()->invalidate();
            return false;
        }
    }
}
