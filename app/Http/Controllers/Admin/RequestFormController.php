<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RequestForm;
use Carbon\Carbon;


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
        $requestForm = RequestForm::all();
        return $requestForm;
    }
}
