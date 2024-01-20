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

    public function disable(Request $request){
        $user = $request->validate([
            'id' => ['required'],
        ]);

        $disable = User::where('id', $user['id'])
        ->update([
            'u_status' => 2,
            'updated_at' => now(),
        ]);

        if($disable){
            return redirect('/user/' . $user['id'])->with('success', 'User disabled!');
        }else{
            return redirect('/user/' . $user['id'])->with('success', 'Failed to disable user!');
        }
    }

    public function reactivate(Request $request){
        $user = $request->validate([
            'id' => ['required'],
        ]);

        $disable = User::where('id', $user['id'])
        ->update([
            'u_status' => 1,
            'updated_at' => now(),
        ]);

        if($disable){
            return redirect('/user/' . $user['id'])->with('success', 'User re-activated!');
        }else{
            return redirect('/user/' . $user['id'])->with('success', 'Failed to re-activate user!');
        }
    }

    public function resetpassword(Request $request){
        $user = $request->validate([
            'id' => ['required'],
        ]);

        $hashed = Hash::make('abcd_123');

        $disable = User::where('id', $user['id'])
        ->update([
            'password' => $hashed,
            'u_firstlogin' => 1,
            'updated_at' => now(),
        ]);

        if($disable){
            return redirect('/user/' . $user['id'])->with('success', 'Password reset successful!');
        }else{
            return redirect('/user/' . $user['id'])->with('success', 'Failed to reset password!');
        }
    }

    public function updateuserprofile(Request $request){
        $user = $request->validate([
            'id' => ['required'],
            'u_fname' => ['required'],
            'u_lname' => ['required'],
            'u_mname' => ['nullable'],
            'u_email' => ['nullable'],
            'u_role' => ['required'],
            'u_department' => ['required'],
            'u_username',
        ]);

        $fname = strtolower($user['u_fname']);
        $lname = strtolower($user['u_lname']);
        $user['u_username'] = strtolower(lcfirst($fname[0]) . $lname);

        $checkusername = User::where('u_username', 'LIKE', '%' . $user['u_username'] . '%')->count();
        if($checkusername > 0){
            $user['u_username'] = ($user['u_username'] . $checkusername);
        }

        $updateuserprofile = User::where('id', $user['id'])
        ->update([
            'u_fname' => $user['u_fname'],
            'u_lname' => $user['u_lname'],
            'u_mname' => $user['u_mname'],
            'u_email' => $user['u_email'],
            'u_role' => $user['u_role'],
            'u_department' => $user['u_department'],
            'updated_at' => now(),
        ]);

        if($updateuserprofile){
            return redirect('/user/' . $user['id'])->with('success', 'User profile update successful!');
        }else{
            return redirect('/user/' . $user['id'])->with('success', 'Failed to update user profile!');
        }
    }
}
