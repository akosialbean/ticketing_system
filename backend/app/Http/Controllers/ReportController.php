<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Report;
use Illuminate\Support\Str;

class ReportController extends Controller
{
    public $reportModel;
    public function __construct(Report $reportModel){
        $this->reportModel = $reportModel;
    }
    public function report(){
        $reports = false;
        return view('reports.ticketreport', compact('reports'));
    }

    public function generate(Request $request){
        $userdept = Auth::user()->u_department;
        $selection = $request->validate([
            'datefrom' => ['required'],
            'dateto' => ['required']
        ]);
    
        $reports = $this->reportModel->generateReport($userdept, $selection);
    
        session(['reports' => $reports]);

        return view('reports.ticketreport', compact('reports'));
    }

    public function export(){
        $curdate = now();
        $reports = session('reports');
        return Excel::download(new ExportReportController($reports), $curdate . '_tickets_report.xlsx');
    }
  
}
