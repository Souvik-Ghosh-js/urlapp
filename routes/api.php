<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\UrlController;




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

Route::get('/', [HomeController::class, 'index']);


Route::get('/signuppage',[HomeController::class, 'signuppage'] );

Route::get('/short/{short_url}', [UrlController::class, 'redirect']);
Route::get('/masked/{masked_url}', [UrlController::class, 'redirect1']);

Route::post('/login', [AuthController::class, 'login']);


Route::middleware(['web'])->group(function () {
    Route::get('/loginpage', [HomeController::class, 'loginpage'])->name('loginpage');
    Route::get('/otpcheck', [HomeController::class, 'otpcheck']);
    Route::get('/setpassword', [HomeController::class, 'setpage']);
    Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('set-password', [AuthController::class, 'setPassword']);
    Route::post('verify', [AuthController::class, 'sendOtp']);

    Route::post('reset', [DashboardController::class,'sendOtp']);
    Route::post('verify-otp-reset',[DashboardController::class,'verifyOtp']);
    Route::post('set-password-reset',[DashboardController::class, 'setPassword']);

});


Route::middleware(['auth:api'])->group(function ()
{
    Route::post('/shorten', [UrlController::class, 'shorten']);
    Route::get('/abc',[HomeController::class, 'urla'] );
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard',[DashBoardController::class, 'dashboard'] );
    Route::get('/table',[DashBoardController::class, 'table'] );
    Route::get('/table1',[DashBoardController::class, 'table1'] );
    Route::get('/table2',[DashBoardController::class, 'table2'] );
    Route::get('/forgot-password',[DashBoardController::class, 'forgot_password'] );
    Route::get('/visits/{urlType}/{urlId}', [DashboardController::class, 'visitss']);
    Route::get('/profilepage',[DashBoardController::class,'profilepage']);
    Route::put('/change-profile', [DashBoardController::class,'updateProfile']);


});
Route::middleware('auth:api')->group(function () {
    Route::get('user', function () {
        return auth()->user();
    });

});
