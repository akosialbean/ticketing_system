<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\DB;

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
}
