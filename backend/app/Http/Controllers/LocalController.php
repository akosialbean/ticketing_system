<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\User;
use App\Models\Local;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LocalController extends Controller
{
    public function locals(){
        $locals = Local::select('locals.l_level', 'departments.d_code', 'locals.l_number',
        DB::raw("(SELECT CONCAT(users.u_fname, ' ', users.u_lname) FROM users WHERE users.id = locals.l_user) AS fullname")
        )
        ->join('departments', 'locals.l_department', 'departments.d_id')
        ->orderby('locals.l_level', 'asc')
        ->paginate(10);
        return view('locals.locals', compact('locals'));
    }

    public function newlocal(){
        $departments = Department::orderby('d_code', 'asc')->get();
        $users = User::orderby('users.u_fname', 'asc')->get();
        return view('locals.newlocal', compact('departments', 'users'));
    }

    public function addlocal(Request $request){
        // dd($request);
        $local = $request->validate([
            'l_level' => ['required'],
            'l_department' => ['required'],
            'l_user' => ['required'],
            'l_number' => ['required']
        ]);

        $local['created_at'] = now();
        $local['l_createdby'] = Auth::user()->id;
        $local['l_status'] = 1;

        $save = Local::insert($local);

        if($save){
            return redirect('/locals')->with('success',  $local['l_number'] .  ' ' . 'added!');
        }else{
            return redirect('/locals')->with('error', 'Failed to create '. $local['l_number'] . ' local!');
        }
    }

    public function searchlocal(Request $request){
        $searchitem = $request->searchitem;
    
        $locals = Local::select('locals.l_level', 'departments.d_code', 'locals.l_number',
        DB::raw("(SELECT users.u_fname,  users.u_lname FROM users WHERE users.id = locals.l_user)e")
        )
        ->join('departments', 'locals.l_department', 'departments.d_id')
        ->where('l_level', 'like', '%' . $searchitem . '%')
        ->orWhere('l_department', 'like', '%' . $searchitem . '%')
        ->orWhere('l_number', 'like', '%' . $searchitem . '%')
        ->orderby('locals.l_level', 'asc')
        ->paginate(10);
    
        return view('locals.locals', compact('locals'));
    }
    
    
}
