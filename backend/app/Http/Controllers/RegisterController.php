<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Department;

class RegisterController extends Controller
{
    public $departmentModel;
    public $userModel;
    public function __construct(Department $departmentModel, User $userModel){
        $this->departmentModel = $departmentModel;
        $this->userModel = $userModel;
    }
    public function newuser(){
        $getDepartments = $this->departmentModel->getDepartmentList()->orderby('d_code', 'asc')->get();
        return view('registration.registration', ['departments' => $getDepartments]);
    }

    public function adduser(Request $request){
        $newuser = $request->validate([
            'u_fname' => ['required'],
            'u_lname' => ['required'],
            'u_mname' => ['nullable'],
            'u_username',
            'u_department' => ['required'],
            'u_role' => ['required'],
            'u_email' => ['nullable'],
            'password',
            'u_status',
            'created_at',
        ]);

        $newuser['password'] = Hash::make('abcd_123');
        $newuser['u_status'] = 1;
        $newuser['created_at'] = now();

        $fname = strtolower($newuser['u_fname']);
        $lname = str_replace(' ', '', strtolower($newuser['u_lname']));
        $newuser['u_username'] = strtolower(lcfirst($fname[0]) . $lname);

        // $checkemail = User::where('u_email', $newuser['u_email'])->first();
        // if($checkemail){
        //     return redirect('/register')->with('error', 'Email already exists!');
        // }

        $checkusername = $this->userModel->checkUsername($newuser);
        if($checkusername > 0){
            $newuser['u_username'] = ($newuser['u_username'] . $checkusername);
        }

        $adduser = $this->userModel->addUser($newuser);

        if($adduser){
            return redirect('/users')->with('success', 'New user created!');
        }else{
            return redirect('/users')->with('error', 'Failed to create!');
        }
    }
}
