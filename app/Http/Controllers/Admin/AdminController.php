<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use DB;

class AdminController extends Controller
{
    public function getPersonnel()
    {
        return User::orderBy('id', 'desc')->with('role')->get();
    }

    public function getOnePersonnel($id)
    {
        return User::where('id', $id)->get();
    }

    public function storePersonnel(Request $request){
        $newPersonnel = new User;
        $newPersonnel->role_id = $request->personnelRole;
        $newPersonnel->password = Hash::make($request->employeeNumber);
        $newPersonnel->name = $request->name;
        $newPersonnel->image = $request->image;
        $newPersonnel->position = $request->position;
        $newPersonnel->itemNumber = $request->itemNumber;
        $newPersonnel->employeeNumber = $request->employeeNumber;
        $newPersonnel->datePermanency = Carbon::parse( $request->datePermanency)->format('Y-m-d');
        $newPersonnel->dateOrigAppointment =  Carbon::parse($request->dateOrigAppointment)->format('Y-m-d');
        $newPersonnel->dateLastProAppointment = Carbon::parse($request->dateLastProAppointment)->format('Y-m-d');
        $newPersonnel->homeAddress = $request->homeAddress;
        $newPersonnel->contactNumber = $request->contactNumber;
        $newPersonnel->emailAddress = $request->emailAddress;
        $newPersonnel->dateOfBirth = Carbon::parse($request->dateOfBirth)->format('Y-m-d');
        $newPersonnel->civilStatus = $request->civilStatus;
        $newPersonnel->religion = $request->religion;
        $newPersonnel->gender = $request->gender;
        $newPersonnel->majorSpecialization = $request->majorSpecialization;
        $newPersonnel->minor = $request->minor;
        $newPersonnel->civilServiceEligibility = $request->civilServiceEligibility;
        $newPersonnel->highestEducationAttainment = $request->highestEducationAttainment;
        $newPersonnel->schoolRole = $request->schoolRole;
        $newPersonnel->ggisbpno = $request->ggisbpno;
        $newPersonnel->tin = $request->tin;
        $newPersonnel->basicSalary = $request->basicSalary;
        $newPersonnel->salaryGradeLevel = $request->salaryGradeLevel;
        $newPersonnel->stepIncrement = $request->stepIncrement;
        $newPersonnel->height = $request->height;
        $newPersonnel->weight = $request->weight;
        $newPersonnel->contactPerson = $request->contactPerson;
        $newPersonnel->teachingLoads = $request->teachingLoads;
        $newPersonnel->save();
        return;
    }

    public function uploadPersonnelImage(Request $request){
        // return;
        // return $request;
        $request->validate([
            'file' => 'required'
        ]);
        $file = $request->file;
        $picName = time().'.webp';

        $img = \Image::make($file)->encode('webp');

        if($img->width()>=800){
            $img->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        $img->save(public_path('/img/personnel/'.$picName));

        // $request->file->move(public_path('uploads/high'),$picName);
        return $picName;
    }

    public function deletePersonnelImage(Request $request){
        $fileName = $request->imageName;
        $this->deleteFileFromServe($fileName);
        return 'done';
    }

    public function deleteFileFromServe($fileName){
        $filePath = public_path().'/img/personnel/'.$fileName;
        if(file_exists($filePath)){
            @unlink($filePath);
        }
        return;
    }

    public function updatePersonnel(Request $request){
        DB::table('users')
        ->where('id', $request->id)
        ->update([
        'role_id' => $request->role_id,
        'password' => Hash::make($request->employeeNumber),
        'name' => $request->name,
        'image' => $request->image,
        'position' => $request->position,
        'itemNumber' => $request->itemNumber,
        'employeeNumber' => $request->employeeNumber,
        'datePermanency' => Carbon::parse($request->datePermanency)->format('Y-m-d'),
        'dateOrigAppointment' => Carbon::parse($request->dateOrigAppointment)->format('Y-m-d'),
        'dateLastProAppointment' => Carbon::parse($request->dateLastProAppointment)->format('Y-m-d'),
        'homeAddress' => $request->homeAddress,
        'contactNumber' => $request->contactNumber,
        'emailAddress' => $request->emailAddress,
        'dateOfBirth' => Carbon::parse($request->dateOfBirth)->format('Y-m-d'),
        'civilStatus' => $request->civilStatus,
        'religion' => $request->religion,
        'gender' => $request->gender,
        'majorSpecialization' => $request->majorSpecialization,
        'minor' => $request->minor,
        'civilServiceEligibility' => $request->civilServiceEligibility,
        'highestEducationAttainment' => $request->highestEducationAttainment,
        'schoolRole' => $request->schoolRole,
        'ggisbpno' => $request->ggisbpno,
        'tin' => $request->tin,
        'basicSalary' => $request->basicSalary,
        'salaryGradeLevel' => $request->salaryGradeLevel,
        'stepIncrement' => $request->stepIncrement,
        'height' => $request->height,
        'weight' => $request->weight,
        'contactPerson' => $request->contactPerson,
        'teachingLoads' => $request->teachingLoads,
        ]);
        return;
    }

    public function deletePersonnel(){
        return;
    }


}
