<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {

        // form theke je value gulo pabo, adike sugulo validator diye check kra hobe valid kina
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:100',
            'email'=>'required|string|email|max:100|unique:users',
            'password'=>'required|string|min:6|confirmed',
        ]);

        // jdi form e kono input e problem thake tahle sei error show krar jnne fails() use hoise
        if ($validator->fails())
        {
            return response()->json($validator->errors());
        }

        // ar jdi sob thik thake, tahle amra akta user register krbo 'create' function er dhara
        // sathe json er dhara msg, user value pathabo.
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);

        return response()->json([
            'msg'=>'User Registerd Successfully',
            'user'=>$user,
        ]);
    }
}
