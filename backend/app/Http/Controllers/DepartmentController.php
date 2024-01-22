<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
        $departments = Department::orderby('d_id', 'desc')->paginate(10);
        return view('departments.departments', compact('departments'));
    }

    public function department($d_id){
        $department = Department::where('d_id', $d_id)->first();
        return view('departments.department', compact('department'));
    }

    public function editdepartment(Request $request){
        $department = $request->validate([
            'd_id' => ['required'],
            'd_code' => ['required'],
            'd_description' => ['required'],
            'updated_at' => ['nullable'],
            'd_updatedby' => ['nullable'],
            'd_status' => ['nullable'],
        ]);

        $update = Department::where('d_id', $department['d_id'])
            ->update([
                'd_code' => $department['d_code'],
                'd_description' => $department['d_description'],
                'updated_at' => now(),
                'd_updatedby' => Auth::user()->id,
                'd_status' => $department['d_status'],
            ]);
        
        if($update){
            return redirect('/department/' . $department['d_id'])->with('success',  $department['d_description'] .  ' ' . 'Department updated!');
        }else{
            return redirect('/department/' . $department['d_id'])->with('error', 'Failed to update '. $department['d_description'] . ' department!');
        }
    }
}
