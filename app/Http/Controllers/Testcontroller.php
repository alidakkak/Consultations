<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class Testcontroller extends Controller
{

    ///////////// filters //////////////
    public function index(Request $request)
    {
        return User::filter($request)->get();
    }


    public function a() {
      return  User::all()->where("role","expert")->random(2);
    }
}
