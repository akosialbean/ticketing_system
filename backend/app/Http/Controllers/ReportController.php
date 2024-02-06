<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Severity;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function report(){
        return view('reports.ticketreport');
    }

    public function generate(Request $request){
        $selection = $request->validate([
            'table' => ['required'],
            'datefrom' => ['required'],
            'dateto' => ['required']
        ]);

        $reports = DB::table($selection['table'])
        ->whereBetween('created_at', [$selection['datefrom'], $selection['dateto']])
        ->get();

        return view('reports.ticketreport', compact('reports'));
    }
}
