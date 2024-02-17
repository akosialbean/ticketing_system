<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Severity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SeverityController extends Controller
{
    public function newseverity(){
        return view('severities.newseverity');
    }

    public function add(Request $request){
        $severity = $request->validate([
            's_title' => ['required'],
            's_description' => ['required'],
            's_responsetime' => ['required'],
            's_resolutiontime' => ['required'],
            's_escalationtime' => ['required'],
            's_createdby',
            'created_at',
            's_status'
        ]);

        $severity['s_createdby'] = 1;
        $severity['created_at'] = now();
        $severity['s_status'] = 1;

        $save = Severity::insert($severity);

        if($save){
            return redirect('/severities')->with('success', 'New severity created!');
        }else{
            return redirect('/severities')->with('error', 'Failed to create!');
        }
    }

    public function severities(){
        $get = Severity::orderby('s_id', 'desc')->get();
        return view('severities.severities', compact('get'));
    }

    public function severity($s_id){
        $severity = Severity::where('s_id', $s_id)->first();
        return view('severities.severity', compact('severity'));
    }

    public function editseverity(Request $request){
        $severity = $request->validate([
            's_id' => ['required'],
            's_title' => ['required'],
            's_description' => ['required'],
            's_responsetime' => ['required'],
            's_resolutiontime' => ['required'],
            's_escalationtime' => ['required'],
            'updated_at' => ['nullable'],
            's_updatedby' => ['nullable'],
            's_status' => ['nullable'],
        ]);

        $update = Severity::where('s_id', $severity['s_id'])
            ->update([
                's_title' => $severity['s_title'],
                's_description' => $severity['s_description'],
                's_responsetime' => $severity['s_responsetime'],
                's_resolutiontime' => $severity['s_resolutiontime'],
                's_escalationtime' => $severity['s_escalationtime'],
                'updated_at' => now(),
                's_updatedby' => Auth::user()->id,
                's_status' => $severity['s_status'],
            ]);
        
        if($update){
            return redirect('/severity/' . $severity['s_id'])->with('success',  $severity['s_description'] .  ' ' . 'Department updated!');
        }else{
            return redirect('/severity/' . $severity['s_id'])->with('error', 'Failed to update '. $severity['s_description'] . ' severity!');
        }
    }
}
