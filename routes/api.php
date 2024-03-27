<?php

use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
// http://127.0.0.1:8000/api/register @ $ #

route::group(['middleware'=>'api'], function(){

    route::post('/register', [UserController::class, 'register']);
    route::post('/login', [UserController::class, 'login']);
    route::get('/logout', [UserController::class, 'logout']);
    route::get('/profile', [UserController::class, 'profile']);
    route::post('/update-profile', [UserController::class, 'updateProfile']);
    route::get('/send-verify-mail/{email}', [UserController::class, 'sendVerifyMail']);
});







