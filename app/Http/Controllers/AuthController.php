<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Traits\GeneralTrait;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // Add User or Expert
    use GeneralTrait;

    public function register(Request $request)
    {
        $file_name = null;
        if ($request->image != null) {
            $file_extension = $request->image->getClientOriginalExtension();
            $file_name = time() . '.' . $file_extension;
            $path = 'images/expert';
            $request->image->move($path, $file_name);
        }


        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'role' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create(array_merge(
            $validator->validate(),
            [
                'password' => bcrypt($request->password),

                'image'    => $file_name
            ]
        ));
        $token = JWTAuth::attempt([
            'email' => $user->email,
            'password' => $request->password
        ]);
        return  $this->returnSuccessMessage('logged in successfully');
    }
    //////////////  login  ///////////////
    public function login(Request $request)
    {
        $validator = validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Bad request'
            ], 400);
        }
        $credentials = $request->only('email', 'password');
        $token = JWTAuth::attempt($credentials);
        try {
            if (!$token) {
                return response()->json(['error' => 'email or password is incorrect.'], 400);
            }
        } catch (JWTException $ex) {
            return response()->json(['error' => 'Unknown error'], 520);
        }
        return response()->json(['token' => $token]);
    }

    ///// السماح للمستخدم بتصفح تصنيفات االستشارات والخبراء لكل تصنيف
    public function get_category(Request $request)
    {

        $users = User::with("Experience", "Registeraton", "Availabletime", "Consulation")
            ->where('category', $request->category)->get();
        return response()->json([
            'users' => $users,
        ], 200);
    }
}
