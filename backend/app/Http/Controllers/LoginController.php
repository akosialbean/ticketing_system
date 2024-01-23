<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(){
        $checkadmin = User::where('u_username', 'wmcadmin')->count();
        if($checkadmin < 1){
            //creates an admin account
            $admin = [
                'u_fname' => 'WMC',
                'u_lname' => 'Admin',
                'u_username' => 'wmcadmin',
                'u_department' => 1,
                'u_role' => 1,
                'u_email' => 'ithelpdesk@wetlakemed.com.ph',
                'password' => Hash::make('abcd_123'),
                'u_status' => 1,
                'created_at' => now()
            ];
            $createadmin = User::insert($admin);

            $checkdepartment = Department::count();
            if($checkdepartment < 1){
                $department = [
                    'd_code' => 'ICT',
                    'd_description' => 'Information and Communications Technology',
                    'created_at' => now(),
                ];
                $createdepartment = Department::insert($department);
            }
            return view('welcome');
        }else{
            return view('welcome');
        }
    }

    public function log(Request $request)
    {
        $credentials = $request->validate([
            'u_username' => ['required'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            if(Auth::user()->u_status == 1){
                $request->session()->regenerate();
                if(Auth::user()->u_role == 1){
                    if(Auth::user()->u_firstlogin == 2)
                        return redirect()->intended('/tickets')->with('success', 'Login Successful!');
                    else{
                        return redirect()->intended('/user/firstlogin')->with('success', 'Please change your password!');
                    }
                }else{
                    if(Auth::user()->u_firstlogin == 2)
                        return redirect()->intended('/tickets/mytickets')->with('success', 'Login Successful!');
                    else{
                        return redirect()->intended('/user/firstlogin')->with('success', 'Please change your password!');
                    }
                }
            }else{
                $request->session()->invalidate();
                $request->session()->regenerate();
                return redirect()->intended('/')->with('error', 'User account is disabled!');
            }
        } else {
            return redirect()->intended('/')->with('error', 'Incorrect username / password!');
        }

        
    }

    public function firstlogin(){
        return view('users.firstlogin');
    }

    public function changepassword(Request $request){
        $user = $request->validate([
            'id' => ['required'],
            'u_password' =>  ['required'],
            'u_password2' => ['required']
        ]);

        $password1 = $user['u_password'];
        $password2 = $user['u_password2'];

        if($password1 === $password2){
            $hash = Hash::make($password1);
            $updatepassword = User::where('id', $user['id'])->update([
                'password' => $hash,
                'u_firstlogin' => 2,
                'updated_at' => now()
        ]);
            if($updatepassword){
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerate();
                return redirect('/')->with('success', 'Please login');
            }
        }else{
            return redirect('/user/firstlogin')->with('error', 'Password1 and Password2 matched');
        }
    }

    public function logout(Request $request){
        if(!Auth::user()){
            return redirect('/')->with('error', 'Please login!');
        }
        
        $request->session()->invalidate();
        $request->session()->regenerate();

        return redirect('/')->with('success', 'Logged out');
    }
}
