<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class RegisterController extends Controller
{
    public function newuser(){
        return view('registration.registration');
    }

    public function adduser(Request $request){

        // dd($request);

        $newuser = $request->validate([
            'u_fname' => ['required'],
            'u_lname' => ['required'],
            'u_mname',
            'u_username' => ['required'],
            'u_department' => ['required'],
            'u_role' => ['required'],
            'u_email',
            'u_password',
            'u_status',
            'created_at',
        ]);

        // dd($newuser);

        $newuser['u_password'] = Hash::make('abcd_123');
        $newuser['u_status'] = 1;
        $newuser['created_at'] = now();

        $adduser = User::insert($newuser);

        if($adduser){
            return redirect('/register')->with('message', 'New user created!');
        }else{
            return redirect('/register')->with('message', 'Failed to create!');
        }
    }
}
