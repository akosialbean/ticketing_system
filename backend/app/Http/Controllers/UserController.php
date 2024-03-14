<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public $userModel;
    public $departmentModel;
    public function __construct(User $userModel, Department $departmentModel){
        $this->userModel = $userModel;
        $this->departmentModel = $departmentModel;
    }
    public function users(){
        $users = $this->userModel->getUsersList()->paginate(10);
        return view('users.users', compact('users'));
    }

    public function user($userid){
        $user = $this->userModel->viewUser($userid);
        $departments = $this->departmentModel->getDepartmentList()->get();
        return view('users.user', compact('user', 'departments'));
    }

    public function changepassword(Request $request){
        $user = $request->validate([
            'id' => ['required'],
            'old_password' => ['required'],
            'u_password' => ['required'],
            'u_password2' => ['required'],
        ]);


        $checkoldpassword = $this->userModel->checkOldPassword($user);
        if($checkoldpassword){
            $newpassword = $user['u_password'];
            $newpassword2 = $user['u_password2'];
            if($newpassword === $newpassword2){
                $hashed = Hash::make($newpassword);
                if($hashed){
                    $updatepassword = $this->userModel->updatePassword($user, $hashed);
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
        }else{
            return redirect('/user/' . Auth::user()->id)->with('error', 'Password doesn\'t match!');
        }
    }

    public function disable(Request $request){
        $user = $request->validate(['id' => ['required']]);
        $disable = $this->userModel->disableUser($user);
        if($disable){
            return redirect('/user/' . $user['id'])->with('success', 'User disabled!');
        }else{
            return redirect('/user/' . $user['id'])->with('success', 'Failed to disable user!');
        }
    }

    public function reactivate(Request $request){
        $user = $request->validate(['id' => ['required']]);
        $reactivate = $this->userModel->reactivateUser($user);
        if($reactivate){
            return redirect('/user/' . $user['id'])->with('success', 'User re-activated!');
        }else{
            return redirect('/user/' . $user['id'])->with('success', 'Failed to re-activate user!');
        }
    }

    public function resetpassword(Request $request){
        $user = $request->validate(['id' => ['required']]);
        $hashed = Hash::make('abcd_123');
        $resetPassword = $this->userModel->resetPassword($user, $hashed);

        if($resetPassword){
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
        ]);

        // $fname = strtolower($user['u_fname']);
        // $lname = strtolower($user['u_lname']);
        // $user['u_username'] = strtolower(lcfirst($fname[0]) . $lname);

        // $checkusername = User::where('u_username', 'LIKE', $user['u_username'] . '%')->count();
        // if($checkusername > 0){
        //     $user['u_username'] = ($user['u_username'] . $checkusername);
        // }

        $updateuserprofile = $this->userModel->updateUserProfile($user);

        if($updateuserprofile){
            return redirect('/user/' . $user['id'])->with('success', 'User profile update successful!');
        }else{
            return redirect('/user/' . $user['id'])->with('success', 'Failed to update user profile!');
        }
    }

    public function searchuser(Request $request){
        $searchitem = $request->validate(['searchitem' => ['required']]);
        $users = $this->userModel->searchUser($searchitem);
        return view('users.searchuser', compact('users'));
    }

    public function changeusername(Request $request, $id){
        $user = $request->validate(['u_username' => ['required']]);
        $checkUsername = $this->userModel->checkUsername($user);
        if($checkUsername >= 1){
            return redirect()->intended('/user/' . $user['id'])->with('error', 'Username already exists!');
        }

        $update = $this->userModel->updateUsername($id, $user);
        if($update){
            return redirect('/user/' . $id)->with('success', 'Username change successful!');
        }else{
            return redirect('/user/' . $id)->with('success', 'Failed to change username!');
        }
    }
}