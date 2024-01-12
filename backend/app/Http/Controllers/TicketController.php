<?php

namespace App\Http\Controllers;
use App\Models\Department;
use App\Models\Category;

use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function newticket(){
        $getDepartments = Department::orderby('d_description', 'asc')->get();
        $getCategories = Category::orderby('c_description', 'asc')->get();
        return view('tickets.newticket', ['departments' => $getDepartments, 'categories' => $getCategories]);
    }

    public function add(Request $request){
        $ticket = $request->validate([
            't_title' => ['required'],
            't_description' => ['required'],
            't_todepartment'
        ]);
    }
}