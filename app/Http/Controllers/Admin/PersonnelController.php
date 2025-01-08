<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PersonnelController extends Controller
{
    public function getUserPersonnel() {
        return User::where('id', Auth::user()->id)->get();
    }

}
