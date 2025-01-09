<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RequestForm;
use Illuminate\Support\Facades\Mail;
use App\Mail\RequestMail;
use Carbon\Carbon;
use DB;


class RequestFormController extends Controller
{
    public function storeRequestForm(Request $request) {
        $request->validate([
            'emailAddress' => 'required',
            'date' => 'required',
            'nameOfRequester' => 'required',
            'nameOfLearner' => 'required',
            'schoolYearGraduated' => 'required',
            'issuedBy' => 'required',
            'purpose' => 'required',
            'documentCategory' => 'required',
        ]);

        $requestForm = new RequestForm();
        $requestForm->requestformstatus_id = 1;
        $requestForm->emailAddress = $request->emailAddress;
        $requestForm->date = Carbon::parse($request->date)->format('Y-m-d');
        $requestForm->nameOfRequester = $request->nameOfRequester;
        $requestForm->nameOfLearner = $request->nameOfLearner;
        $requestForm->schoolYearGraduated = $request->schoolYearGraduated;
        $requestForm->issuedBy = $request->issuedBy;
        $requestForm->purpose = $request->purpose;
        $requestForm->documentCategory = $request->documentCategory;
        $requestForm->save();

        return response()->json([
            'message' => 'Request Form has been successfully submitted',
            'requestForm' => $requestForm
        ]);
    }

    public function getAllRequest() {
        $requestForm = RequestForm::where('requestformstatus_id', '!=', 4)->get();
        return $requestForm;
    }

    public function startProcessRequestForm(Request $request) {
        DB::table('request_forms')
        ->where('id', $request->id)
        ->update([
        'requestformstatus_id' => 2,
        ]);

        $requestForm = RequestForm::where('id', $request->id)->get();
        $subject = "Document Request Ready for Pickup";

        $data = [
            'subject' => 'Document Request Ready for Pickup',
            'content' => 'This is Darapidap Elementary School (DES-PRMS), and we would like to inform you
            that your requested document is currently being processed by the administration.
            Please keep an eye on your email for further updates regarding its status.'
        ];

        Mail::to($requestForm[0]->emailAddress)->send(new RequestMail($requestForm[0], $data));

        return;
    }

    public function startPickUpRequestForm(Request $request) {
        DB::table('request_forms')
        ->where('id', $request->id)
        ->update([
        'requestformstatus_id' => 3,
        ]);

        $requestForm = RequestForm::where('id', $request->id)->get();
        $subject = "Document Request Ready for Pickup";

        $data = [
            'subject' => 'Document Request Ready for Pickup',
            'content' => 'This is Darapidap Elementary School (DES-PRMS), and we are pleased to
            inform you that your requested document is now ready for pickup.
            Kindly visit our school at your earliest convenience to collect it'
        ];

        Mail::to($requestForm[0]->emailAddress)->send(new RequestMail($requestForm[0], $data));

        return;
    }

    public function startReleasedRequestForm(Request $request) {
        DB::table('request_forms')
        ->where('id', $request->id)
        ->update([
        'requestformstatus_id' => 4,
        ]);
        return;
    }

    public function getCompletedRequest(){
        $requestForm = RequestForm::where('requestformstatus_id', 4)->get();
        return $requestForm;
    }
}
