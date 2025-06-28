<?php

namespace App\Http\Controllers\ApiController;

use App\Events\UserLogedIn;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{


    public function login(Request $request)
    {
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password]))
        {
            $user=Auth::user();
            event(new UserLogedIn($user));
            $createToken=$user->createToken('auth_token')->plainTextToken;
            return response()->json(['token'=>$createToken,'user'=>$user]);

        }
        return response()->json(['error'=>'email or password is incorrect '],401);
    }
}
