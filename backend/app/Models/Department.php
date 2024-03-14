<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Department extends Model
{

    protected $fillable = [
        'd_code',
        'd_description',
        'd_email',
        'd_createdby',
        'd_updatedby',
        'd_status',
    ];

    public function getDepartmentList(){
        return Department::orderby('d_id', 'desc');
    }

    public function viewDepartment($d_id){
        return Department::where('d_id', $d_id)->first();
    }

    public function addDepartment($department){
        return Department::insert($department);
    }

    public function updateDepartment($department){
        return Department::where('d_id', $department['d_id'])
            ->update([
                'd_code' => $department['d_code'],
                'd_description' => $department['d_description'],
                'd_email' => $department['d_email'],
                'updated_at' => now(),
                'd_updatedby' => Auth::user()->id,
                'd_status' => $department['d_status'],
            ]);
    }

    public function checkDuplicateDepartment($department){
        return Department::where('d_description', 'LIKE', '%' . $department['d_description'] . '%')->count();
    }

    public function getUserDepartment($department ){
        return Department::where('d_id', $department )->first();
    }

    public function getDepartmentCode(){
        return Department::where('d_status', 1)->orderby('d_code', 'asc')->get();
    }

    public function checkITDepartment(){
        return Department::count();
    }

    public function createITDepartment($department){
        return Department::insert($department);
    }
}
