<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;

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
            return response()->json(['errors'=>$validator->errors()]);
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

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'=>'required|string|email|',
            'password'=>'required|string|min:6',
        ]);

        if ($validator->fails())
        {
            return response()->json($validator->errors());
        }
        // token tokhon e dibe jokhon email password database er sathe match krbe,
        // jdi email, password valid pay, database er sathe match na kore
        // tahle nicher success false return krbe.
        // ar jdi data valid thake, data base e register kra data match kore
        // tahle success true dibe. ar jdi valid na hoy, match na kore, tahle
        // upore deya '$validator->errors()' theke laravel er default error return krbe.
        $token = auth()->attempt($validator->validated());
        if (!$token)
        {
            return response()->json([
                'success'=>false,
                'msg' =>'Username and Password is uncorrect',
            ]);

        }
        return response()->json([
            'success' => true,
            'msg'=>'Successfully Login',
            'token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth()->factory()->getTTL()*60
        ]);
    }

    public function logout()
    {
        try {
            auth()->logout();
            return response()->json([
                'success' => true,
                'msg' => 'User Log out Successfull',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage(),
            ]);

        }

    }

    public function profile()
    {
        try {
            return response()->json([
                'success' => true,
                'data' => auth()->user(),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage(),
            ]);

        }

    }

    public function updateProfile(Request $request)
    {

        if (auth()->user()){
            $validator = Validator::make($request->all(), [
                'id'=>'required',
                'name'=>'required|string',
                'email'=>'required|string|email',
            ]);

            if ($validator->fails())
            {
                return response()->json($validator->errors());
            }

            $user = User::find($request->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
            return response()->json([
                'success' => true,
                'msg' => 'User Updated Successfully',
                'data' => $user,
            ]);



        } else {
            return response()->json([
                'success' => false,
                'msg' => 'User Not Authenticated',
            ]);
        }


    }



}
