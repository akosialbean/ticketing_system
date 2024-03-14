<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Severity;
use Illuminate\Support\Facades\Auth;

class SeverityController extends Controller
{
    public $severityModel;
    public function __construct(Severity $severityModel){
        $this->severityModel = $severityModel;
    }
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

        $save = $this->severityModel->addSeverity($severity);

        if($save){
            return redirect()->route('severities')->with('success', 'New severity created!');
        }else{
            return redirect()->route('severities')->with('error', 'Failed to create!');
        }
    }

    public function severities(){
        $get = $this->severityModel->getSeverities();
        return view('severities.severities', compact('get'));
    }

    public function severity($s_id){
        $severity = $this->severityModel->viewSeverity($s_id);
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

        $update = $this->severityModel->updateSeverity($severity);
        
        if($update){
            return redirect()->route('severities')->with('success',  $severity['s_description'] .  ' ' . 'Department updated!');
        }else{
            return redirect()->route('severities')->with('error', 'Failed to update '. $severity['s_description'] . ' severity!');
        }
    }
}
