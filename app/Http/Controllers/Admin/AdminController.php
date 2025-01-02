<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Intervention\Image\Facades\Image;

class AdminController extends Controller
{
    public function getPersonnel()
    {
        return User::orderBy('id', 'desc')->with('role')->get();
    }

    public function storePersonnel(){
        return 'test';
    }

    public function uploadPersonnelImage(Request $request){
        // return $request;
        $request->validate([
            'file' => 'required'
        ]);
        $file = $request->file;
        $picName = time().'.webp';

        $img = Image::make($file)->encode('webp');

        if($img->width()>=800){
            $img->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        $img->save(public_path('/img/personnel/'.$picName));

        // $request->file->move(public_path('uploads/high'),$picName);
        return $picName;
    }
}
