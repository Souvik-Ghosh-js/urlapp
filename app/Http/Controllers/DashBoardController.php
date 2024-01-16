<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Url;
use App\Models\User;
use App\Models\Visit;
use App\Models\ShortUrl;
use App\Models\MaskedUrl;
use App\Models\GenQr;

use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

class DashboardController extends Controller
{
    public function dashboard()
    {
        try {
            $user = auth()->user();
            $user_id = $user->id;
            $data = User::where('id', $user_id)->first();

            $urlCounts = [
                'short_url_count' => ShortUrl::where('user_id', $user_id)->count(),
                'masked_url_count' => MaskedUrl::where('user_id', $user_id)->count(),
                'qr_code_count' => GenQr::where('user_id', $user_id)->count(),
            ];
            $totalShortUrlVisits = Visit::join('short_urls', 'visits.short_url_id', '=', 'short_urls.id')
                                ->where('short_urls.user_id', $user_id)
                                ->count();

            $totalMaskedUrlVisits = Visit::join('masked_urls', 'visits.masked_url_id', '=', 'masked_urls.id')
                                ->where('masked_urls.user_id', $user_id)
                                ->count();
            $totalUrlsCount = $totalShortUrlVisits + $totalMaskedUrlVisits ;



            // return view('dashboard.index', compact('urlCounts', 'data', 'totalUrlsCount'));
            return response()->json([
                'urlCounts' => $urlCounts,
                'data' => $data,
                'totalUrlsCount' => $totalUrlsCount,
            ],200);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return view('dashboard.error', ['error' => $e->getMessage()]);
        }
    }

    public function table()
    {
        try {
            $user_id = auth()->user()->id;
            $data = User::where('id', $user_id)->first();
            $urls = Url::with(['shortUrl', 'maskedUrl', 'genQr'])
                ->where('user_id', $user_id)
                ->orderBy('created_at', 'desc')
                ->get();

            // return view('dashboard.tables', compact('urls','data'));
            return response()->json([
                'urls' => $urls,
                'data' => $data,
            ],200);
        } catch (\Exception $e) {
            return view('dashboard.error', ['error' => $e->getMessage()]);
        }
    }
    public function table1()
    {
        try {
            $user_id = auth()->user()->id;
            $data = User::where('id', $user_id)->first();
            $urls = Url::with(['shortUrl', 'maskedUrl', 'genQr'])
                ->where('user_id', $user_id)
                ->orderBy('created_at', 'desc')
                ->get();

            // return view('dashboard.tables1', compact('urls','data'));
            return response()->json([
                'urls' => $urls,
                'data' => $data,
            ],200);
        } catch (\Exception $e) {
            return view('dashboard.error', ['error' => $e->getMessage()]);
        }
    }
    public function table2()
    {
        try {
            $user_id = auth()->user()->id;
            $data = User::where('id', $user_id)->first();
            $urls = Url::with(['shortUrl', 'maskedUrl', 'genQr'])
                ->where('user_id', $user_id)
                ->orderBy('created_at', 'desc')
                ->get();

            // return view('dashboard.tables2', compact('urls','data'));
            return response()->json([
                'urls' => $urls,
                'data' => $data,
            ],200);
        } catch (\Exception $e) {
            return view('dashboard.error', ['error' => $e->getMessage()]);
        }
    }

    public function visitss($urlType, $urlId)
    {
        try {
            // Get the authenticated user's ID
            $user_id = auth()->user()->id;
            $data = User::where('id', $user_id)->first();

            // Define the relationship based on the URL type
            $relationship = '';
            switch ($urlType) {
                case 'short':
                    $relationship = 'shortUrl';
                    break;
                case 'masked':
                    $relationship = 'maskedUrl';
                    break;
                case 'qr':
                    $relationship = 'genQr';
                    break;
                default:
                    // Handle unsupported URL type
                    return response()->json(['error' => 'Unsupported URL type'], 400);
            }

            // Retrieve visits with related URL information
            $visits = Visit::with([$relationship])
                ->whereHas($relationship, function ($query) use ($user_id, $urlId) {
                    $query->where('user_id', $user_id)->where('id', $urlId);
                })
                ->latest()
                ->paginate(10);

            // return view('home.visitsss', compact('visits', 'urlType', 'urlId','data'));
            return response()->json([
                'urlType' => $urlType,
                'data' => $data,
                'visits' =>$visits,
                'urlId'=>$urlId,
            ],200);
        } catch (\Exception $e) {
            // Handle the exception (log it, show an error message, etc.)
            return view('dashboard.error', ['error' => $e->getMessage()]);
        }
    }
    public function forgot_password(){
        // return view("dashboard.forgot-password");
        return response()->json(['redirecting to forgot_password' => 'success'], 200);

    }


    public function sendOtp(Request $request)
    {
        // Validate email
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Generate and save OTP
        $otp = rand(100000, 999999);
        $user = User::where('email', $request->email)->first();
        $user->update(['otp' => $otp]);

        // Send OTP to the user's email
        Mail::to($request->email)->send(new OtpMail($otp));

        // Redirect to OTP verification page
        // return view('dashboard.otpcheck');
        return response()->json(['redirecting to OTP check' => 'success'], 200);

    }
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $user = auth()->user();

        if ($request->otp == $user->otp) {
            return response()->json(['redirecting to set password' => 'success'], 200);

        } else {
            return redirect()->back()->withErrors(['otp' => 'Invalid OTP']);
        }
    }
    public function setPassword(Request $request)
    {
        try{
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();
        $user->update(['password' => bcrypt($request->password)]);

        // Clear the OTP field
        // $user->update(['otp' => null]);

        // Redirect to the dashboard or login page
        // return redirect('/dashboard');
        return response()->json(['password set sucessfully' => 'redirect to dashboard'], 200);

    }
    catch (\Exception $e) {
        dd($e->getMessage());
        return view('dashboard.error', ['error' => $e->getMessage()]);
    }
    }

    public function updateProfile(Request $request)
    {
        try
        {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);
        $user->update([
            'name' => $request->input('name'),
            'phone_number' => $request->input('phone_number'),
            'address' => $request->input('address')
        ]);

        // dd("heelo");
        return response()->json(['changed' => 'redirect to dashbaord'], 200);

    }
    catch (\Exception $e) {
        dd($e->getMessage());
        return view('dashboard.error', ['error' => $e->getMessage()]);
    }
    }
    public function profilepage(){
        $user = auth()->user();
            $user_id = $user->id;
            $data = User::where('id', $user_id)->first();
        // return view("dashboard.profile",compact( 'data', ));
        return response()->json(['success' => 'open profile page'], 200);

    }
}
