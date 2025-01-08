<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EnrollmentContent;

class EnrollmentContentController extends Controller
{
    public function storeEnrollmentContent(Request $request){
        $enrollmentContent = new EnrollmentContent;
        $enrollmentContent->content = $request->editorData;;
        $enrollmentContent->save();
        return;
    }

    public function getEnrollmentContent(){
        $latestRecord = EnrollmentContent::latest()->first();
        return $latestRecord;
    }
}
