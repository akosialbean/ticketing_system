<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    public $departmentModel;
    public function __construct(Department $departmentModel){
        $this->departmentModel = $departmentModel;
    }
    public function newdepartment(){
        return view('departments.newDepartment');
    }

    public function adddepartment(Request $request){
        $department = $request->validate([
            'd_code' => ['required'],
            'd_description' => ['required'],
            'd_email' => ['required'],
            'created_at'
        ]);

        $code = strtoupper($department['d_code']);
        $department['d_code'] = $code;

        $description = ucwords(strtolower($department['d_description']));
        $department['d_description'] = $description;

        $department['created_at'] = now();

        $checkduplicate = $this->departmentModel->checkDuplicateDepartment($department);

        if($checkduplicate >= 1){
            return redirect('/newdepartment')->with('error', ' Department already exists!');
        }

        $save = $this->departmentModel->addDepartment($department);

        if($save){
            return redirect('/newdepartment')->with('success',  $department['d_description'] .  ' ' . 'Department added!');
        }else{
            return redirect('/newdepartment')->with('error', 'Failed to add department!');
        }
    }

    public function departments(){
        $departments = $this->departmentModel->getDepartmentList()->paginate(10);
        return view('departments.departments', compact('departments'));
    }

    public function department($d_id){
        $department = $this->departmentModel->viewDepartment($d_id);
        return view('departments.department', compact('department'));
    }

    public function editdepartment(Request $request){
        $department = $request->validate([
            'd_id' => ['required'],
            'd_code' => ['required'],
            'd_description' => ['required'],
            'd_email' => ['required'],
            'updated_at' => ['nullable'],
            'd_updatedby' => ['nullable'],
            'd_status' => ['nullable'],
        ]);

        $update = $this->departmentModel->updateDepartment($department);
        
        if($update){
            return redirect('/departments')->with('success',  $department['d_description'] .  ' ' . 'Department updated!');
        }else{
            return redirect('/departments')->with('error', 'Failed to update '. $department['d_description'] . ' department!');
        }
    }
}
