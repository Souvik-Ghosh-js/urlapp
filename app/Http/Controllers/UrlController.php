<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Url;
use App\Models\ShortUrl;
use App\Models\MaskedUrl;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\GenQr;

class UrlController extends Controller
{
    public function shorten(Request $request)
    {
        try
        {
        $user = auth()->user();
        $validator = validator($request->all(), [
            'long_url' => 'required|url|unique:urls',
        ]);

        if ($validator->fails()) {

            return redirect()->route('error')->withErrors($validator);
        }


        $action = $request->input('action');

        if ($action == 'shorten') {
            $short_url = $this->generateShortUrl();
            ShortUrl::create([
                'user_id' => $user->id,
                'long_url_id' => $this->storeLongUrlAndGetId($request->input('long_url')),
                'short_url' => $short_url,
                'visit_count' => 0, // Set initial visit count to 0
            ]);

            // return view('home.urla', ['short_url' => $short_url]);
            return response()->json(['created' => 'short url'], 200);

        } elseif ($action == 'mask') {
            $request->validate([
                'long_url' => 'required|url',
                'additionalInput' => 'required|string',
            ]);

            $randomNumber = sprintf("%02d", rand(0, 99));
            $masked_url = $request->input('additionalInput') . $randomNumber;

            MaskedUrl::create([
                'user_id' => $user->id,
                'long_url_id' => $this->storeLongUrlAndGetId($request->input('long_url')),
                'masked_url' => $masked_url,
                'visit_count' => 0, // Set initial visit count to 0
            ]);

            // return view('home.urla', ['masked_url' => $masked_url]);
            return response()->json(['created' => 'masked url'], 200);

        } elseif ($action == 'generateQR') {
            $long_url=$request->input('long_url');
            $qr_code =QrCode::format('svg')->size(300)->generate($long_url);
            GenQr::create([
                'long_url' => $request->input('long_url'),
                'qr_code' => $qr_code,
                'long_url_id' => $this->storeLongUrlAndGetId($long_url),
                'visit_count' => 0, // Set initial visit count to 0
                'user_id' => $user->id,
            ]);
            return view('home.urla', ['qr_code' => $qr_code]);
        } else {
            // Handle unsupported action here
            return response()->json(['error' => 'Unsupported action'], 400);
        }
    }
    catch(exception $e){
        return view('dashboard.error', ['error' => $e->getMessage()]);
        dd($e->getMessage());

    }
    }

    public function redirect($short_url)
    {
        $urlRecord = ShortUrl::where('short_url', $short_url)->first();
        $urlRecord->increment('visit_count');

        $longUrlId = $urlRecord->long_url_id;

        $longUrl = Url::where('id', $longUrlId)->value('long_url');

        $urlRecord->visits()->create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'referrer' => request()->headers->get('referer'),
            ]);
    // dd($longUrl);
    return redirect($longUrl);
    }

    public function redirect1($masked)
    {
        $urlRecord = MaskedUrl::where('masked_url', $masked)->first();
        $longUrlId = $urlRecord->long_url_id;
        $urlRecord->increment('visit_count');


        $longUrl = Url::where('id', $longUrlId)->value('long_url');

        $urlRecord->visits()->create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'referrer' => request()->headers->get('referer'),

    ]);
    // dd($longUrl);
    return redirect($longUrl);
    }




    private function generateShortUrl()
    {
        return substr(md5(uniqid()), 0, 8);
    }

    private function storeLongUrlAndGetId($longUrl)
    {
        $existingUrl = Url::where('long_url', $longUrl)->first();

        if ($existingUrl) {
            return $existingUrl->id;
        }
        $user = auth()->user();

        $newUrl = Url::create(['long_url' => $longUrl,
        'user_id' => $user->id,
    ]);
        return $newUrl->id;
    }
}
