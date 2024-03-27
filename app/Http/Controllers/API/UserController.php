<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;


class UserController extends Controller
{
    // created Register API
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

    // created Login API
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

    // created Logout API
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

    // created profile API
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

    // created profile-update API
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
            if ($user->email != $request->email) {
                $user->is_verified = 0;
            }
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
                'msg' => 'User is Not Authenticated',
            ]);
        }
    }

    // send verification mail with verify link
    public function sendVerifyMail($email)
    {
        if (auth()->user()){
            $user = User::where('email', $email)->get();
            if (count($user) > 0) {
                // random url bananor jnne, 40ta random word nilam,domain nilam
                // sese url banalam agula diye
                $random = Str::random(40);
                $domain = URL::to('/');
                $url = $domain.'/verify-mail/'.$random;

                // Mail 'view' page e email er data send krte hobe, tai $data variable e kore
                // url, email,title,body pathiye dilam 'data' array akare.
                $data['url'] = $url;
                $data['email'] = $email;
                $data['title'] = 'Email Verification';
                $data['body'] = 'Please click here to below verify your mail';

                Mail::send('verifyMail', ['data'=>$data], function($message) use ($data){
                    $message->to($data['email'])->subject($data['title']);
                });

                $user = User::find($user[0]['id']);
                $user->remember_token = $random;
                $user->save();
                return response()->json([
                    'success' => true,
                    'msg' => 'Mail Sent Successfully',
                ]);


            } else {
                return response()->json([
                    'success' => false,
                    'msg' => 'User not found.',
                ]);
            }

        } else {
            return response()->json([
                'success' => false,
                'msg' => 'User is Not Authenticated',
            ]);
        }
    }

    // token link after verification message
    public function verificationMail($token)
    {
        $user = User::where('remember_token', $token)->get();
        if (count($user) > 0) {
            $datetime = Carbon::now()->format('Y-m-d H:i:s');
            $user = User::find($user[0]['id']);
            $user->remember_token = '';
            $user->is_verified = 1;
            $user->email_verified_at = $datetime;
            $user->save();

            return "<h1>Email Verified Successfully</h1>";


        } else {
            return view('404');
        }

    }

    public function refreshToken()
    {

        if (auth()->user()){

            return response()->json([
                'success' => true,
                'token' => auth()->refresh(),
                'token_type' => 'Bearer',
                'expires_in' => auth()->factory()->getTTL()*60
            ]);



        } else {
            return response()->json([
                'success' => false,
                'msg' => 'User is Not Authenticated',
            ]);
        }
    }



}
