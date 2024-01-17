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

    public function log(Request $request)
    {
        $credentials = $request->validate([
            'u_username' => ['required'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if(Auth::user()->u_role == 1){
                return redirect()->intended('/alltickets')->with('success', 'Login Successful!');
            }else{
                return redirect()->intended('/mytickets')->with('success', 'Login Successful!');
            }
            
        } else {
            return redirect()->intended('/')->with('error', 'Failed to login!');
        }
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();

        return redirect('/')->with('success', 'Logged out');
    }
}
