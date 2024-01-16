<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function newdepartment(){
        return view('departments.newDepartment');
    }

    public function adddepartment(Request $request){
        $department = $request->validate([
            'd_code' => ['required'],
            'd_description' => ['required'],
            'created_at'
        ]);

        $code = strtoupper($department['d_code']);
        $department['d_code'] = $code;

        $description = ucwords(strtolower($department['d_description']));
        $department['d_description'] = $description;

        $department['created_at'] = now();

        $checkduplicate = Department::where('d_description', 'LIKE', '%' . $department['d_description'] . '%')->count();

        if($checkduplicate >= 1){
            return redirect('/newdepartment')->with('error', ' Department already exists!');
        }

        $save = Department::insert($department);

        if($save){
            return redirect('/newdepartment')->with('success',  $department['d_description'] .  ' ' . 'Department added!');
        }else{
            return redirect('/newdepartment')->with('error', 'Failed to add department!');
        }
    }

    public function departments(){
        $get = Department::orderby('d_id', 'desc')->get();
        return view('departments.departments', ['departments' => $get]);
    }
}
