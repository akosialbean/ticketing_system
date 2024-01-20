<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function users(){
        $get = DB::table('users')
        ->join('departments', 'users.u_department', '=', 'departments.d_id')
        ->orderby('users.id', 'desc')->get();
        return view('users.users', ['users' => $get]);
    }

    public function user($userid){
        $user = DB::table('users')
        ->where('id', $userid)
        ->join('departments', 'users.u_department', 'departments.d_id')
        ->first();

        $departments = Department::orderby('d_description', 'asc')->get();

        return view('users.user', compact('user', 'departments'));
    }

    public function changepassword(Request $request){
        $user = $request->validate([
            'id' => ['required'],
            'old_password' => ['required'],
            'u_password' => ['required'],
            'u_password2' => ['required'],
        ]);


        $checkoldpassword = Auth::attempt([
            'id' => $user['id'],
            'password' => $user['old_password'],
        ]);

        if($checkoldpassword){
            $newpassword = $user['u_password'];
            $newpassword2 = $user['u_password2'];

            if($newpassword === $newpassword2){
                $hashed = Hash::make($newpassword);
                if($hashed){
                    $updatepassword = User::where('id', $user['id'])
                    ->update([
                        'password' => $hashed,
                        'updated_at' => now()
                    ]);

                    if($updatepassword){
                        return redirect('/user/' . Auth::user()->id)->with('success', 'Password updated!');
                    }else{
                        return redirect('/user/' . Auth::user()->id)->with('error', 'Failed to change password!');
                    }
                }else{
                    return redirect('/user/' . Auth::user()->id)->with('error', 'Failed to hash new password ' . $newpassword . '!');
                }
            }else{
                return redirect('/user/' . Auth::user()->id)->with('error', 'New Password and Password2 doesn\'t match!');
            }

            // return redirect('/user/' . Auth::user()->id)->with('success', 'Password matched!');
        }else{
            return redirect('/user/' . Auth::user()->id)->with('error', 'Password doesn\'t match!');
        }
    }
}
