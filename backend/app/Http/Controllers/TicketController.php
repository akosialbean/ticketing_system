<?php

namespace App\Http\Controllers;
use App\Models\Department;
use App\Models\Category;
use App\Models\Ticket;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function newticket(){
        $getDepartments = Department::orderby('d_description', 'asc')->get();
        $getCategories = Category::orderby('c_description', 'asc')->get();
        return view('tickets.newticket', ['departments' => $getDepartments, 'categories' => $getCategories]);
    }

    public function add(Request $request){
        // dd($request);
        $newticket = $request->validate([
            't_title' => ['required'],
            't_description' => ['required'],
            't_category' => ['required'],
            't_todepartment' => ['required'],
            't_createdby',
            't_status',
        ]);


        $newticket['t_createdby'] = 1;
        $newticket['t_status'] = 1;

        $save = Ticket::insert($newticket);

        if($save){
            return redirect('/newticket')->with('success', 'New ticket created!');
        }else{
            return redirect('/newticket')->with('error', 'Failed to create!');
        }
    }
}