<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Facades\Passport;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $token = $user->createToken('AppName')->accessToken;
                // $previousUrl = $request->session()->pull('url.intended', '/');
                // return redirect()->intended($previousUrl);
                return response()->json(['success' => 'authorized', 'token' => $token ], 200);


            }
            else{

            return response()->json(['error' => 'Unauthorized'], 401);
            }
        } catch (\Exception $e) {
            \Log::error('Error during login: ' . $e->getMessage());
            dd($e->getMessage());

            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }


    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        $request->session()->put('signup_data', [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            // Other relevant data
        ]);

        // Generate OTP
        $otp = rand(100000, 999999);

        // Save OTP in user session
        $request->session()->put('otp', $otp);

        try{
        Mail::to($request->email)->send(new OtpMail($otp));
        // return redirect("/otpcheck");
        return response()->json(['redirecting to OTP check' => 'success'], 200);

        }
        catch (\Exception $e) {
            //
            Log::error('Error creating user: ' . $e->getMessage());
            dd($e->getMessage());
            return response()->json(['error' => 'Something went wrong'], 500);
        }

    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $savedOtp = $request->session()->get('otp');

        if ($request->otp == $savedOtp) {
            // return redirect('/setpassword');
            return response()->json(['done' => 'redirect to set password'], 200);

        } else {
            return response()->json(['error' => 'Invalid OTP'], 422);
        }
    }

    public function setPassword(Request $request)
    {
    $validator = Validator::make($request->all(), [
        'password' => 'required|string|min:6|confirmed',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 422);
    }

    try {
        // Retrieve user details from the session
        $userData = $request->session()->get('signup_data');

        // Check if $userData is not null
        if (!$userData) {
            return response()->json(['error' => 'User data not found in session'], 500);
        }

        // Create a new user in the database
        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => Hash::make($request->password),
        ]);

        // Clear user details from the session
        $request->session()->forget('signup_data');

        // return redirect('/loginpage');
        return response()->json(['success' => 'redirect to loginpage'], 200);

    } catch (\Exception $e) {
        Log::error('Error creating user: ' . $e->getMessage());
        // dd($e->getMessage());
        return response()->json(['error' => 'Something went wrong'], 500);
    }
    }

    public function logout(Request $request)
{
    try {
        $accessToken = $request->user()->token();

        if ($accessToken) {
            $accessToken->revoke();
            DB::table('oauth_refresh_tokens')
                ->where('access_token_id', $accessToken->id)
                ->delete();
        }

        auth()->logout();

        $request->session()->forget('key');

        // return redirect("/");
        return response()->json(['loggged out' => 'Succesfully'], 200);

    } catch (\Exception $e) {
        \Log::error('Error during logout: ' . $e->getMessage());
        return response()->json(['error' => 'Something went wrong'], 500);
    }
}

}
