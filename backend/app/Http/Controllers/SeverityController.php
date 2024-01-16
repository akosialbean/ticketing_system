<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Severity;

class SeverityController extends Controller
{
    public function newseverity(){
        return view('severities.newseverity');
    }

    public function add(Request $request){
        $severity = $request->validate([
            's_title' => ['required'],
            's_description' => ['required'],
            's_createdby',
            'created_at',
            's_status'
        ]);

        $severity['s_createdby'] = 1;
        $severity['created_at'] = now();
        $severity['s_status'] = 1;

        $save = Severity::insert($severity);

        if($save){
            return redirect('/newseverity')->with('success', 'New severity created!');
        }else{
            return redirect('/newseverity')->with('error', 'Failed to create!');
        }
    }

    public function severities(){
        $get = Severity::orderby('s_id', 'desc')->get();
        return view('severities.severities', compact('get'));
    }
}
