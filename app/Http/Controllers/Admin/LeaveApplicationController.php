<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveApplication;
use Carbon\Carbon;

class LeaveApplicationController extends Controller
{
    public function getLeaveApplications(){
        return LeaveApplication::orderBy('id', 'desc')->with('user')->get();
    }

    public function storeLeaveApplication(Request $request){
        $leaveApplication = new LeaveApplication;
        $leaveApplication->user_id = $request->id;
        $leaveApplication->leaveCategory = $request->leaveCategory;
        $leaveApplication->noOfDays = $request->noOfDays;
        $leaveApplication->dateFiled = Carbon::parse( $request->dateFiled)->format('Y-m-d');
        $leaveApplication->dateOfLeave = Carbon::parse( $request->dateOfLeave)->format('Y-m-d');
        $leaveApplication->save();
        return $request;
    }
}
