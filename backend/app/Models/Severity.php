<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Severity extends Model
{
    protected $fillable = [
        's_title',
        's_description',
        's_responsetime',
        's_resolutiontime',
        's_escalationtime',
        's_createdby',
        's_createdat',
        's_status'
    ];
    public function addSeverity($severity){
        return Severity::create($severity);
    }

    public function getSeverities(){
        return Severity::orderby('s_id', 'desc')->get();
    }

    public function viewSeverity($s_id){
        return Severity::where('s_id', $s_id)->first();
    }

    public function updateSeverity($severity){
        return Severity::where('s_id', $severity['s_id'])
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
    }
}
