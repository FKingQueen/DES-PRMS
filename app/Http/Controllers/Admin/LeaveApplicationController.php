<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveApplication;
use Carbon\Carbon;

class LeaveApplicationController extends Controller
{
    public function getLeaveApplications(){
        return LeaveApplication::where('leaveapplicationstatus_id', 1)
        ->orderBy('id', 'desc')
        ->with('user')
        ->get();
    }

    public function storeLeaveApplication(Request $request){
        $leaveApplication = new LeaveApplication;
        $leaveApplication->user_id = $request->id;
        $leaveApplication->leaveapplicationstatus_id = 1;
        $leaveApplication->leaveCategory = $request->leaveCategory;
        $leaveApplication->noOfDays = $request->noOfDays;
        $leaveApplication->dateFiled = Carbon::parse( $request->dateFiled)->format('Y-m-d');
        $leaveApplication->dateOfLeave = Carbon::parse( $request->dateOfLeave)->format('Y-m-d');
        $leaveApplication->save();
        return $request;
    }

    public function acceptLeaveApplication(Request $request){
        if($request->value == 1){
            $leaveApplication = LeaveApplication::find($request->id);
            $leaveApplication->leaveapplicationstatus_id = 2;
            $leaveApplication->save();
        }
        if($request->value == 2){
            $leaveApplication = LeaveApplication::find($request->id);
            $leaveApplication->leaveapplicationstatus_id = 3;
            $leaveApplication->save();
        }
        
        return $leaveApplication;
    }
}
