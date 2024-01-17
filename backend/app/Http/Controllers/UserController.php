<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function users(){
        $get = DB::table('users')
        ->join('departments', 'users.u_department', '=', 'departments.d_id')
        ->orderby('users.id', 'desc')->get();
        return view('users.users', ['users' => $get]);
    }
}
