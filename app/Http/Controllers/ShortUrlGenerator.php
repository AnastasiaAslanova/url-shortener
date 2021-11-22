<?php

namespace App\Http\Controllers;

use App\Helpers\ShortUrl;
use App\Models\ShortLink;
use Illuminate\Http\Request;

class ShortUrlGenerator extends Controller
{
    public function short(Request $request, $short)
    {
        $shortLink = ShortLink::where('short_url', $short)->first();
        return redirect()->away($shortLink->long_url);
    }


    public function index(Request $request)
    {
        $request->validate([
            'long_url' => 'url',
        ]);
        $longUrl = $request->input('long_url');
        $link = new ShortLink();
        $link->long_url = $longUrl;
        $link->short_url = '';
        $link->save();

        $shortUrl = ShortUrl::idToShortUrl($link->id);
        $link->short_url = $shortUrl;
        $link->save();
        return view('short-url-generator',['shortUrl' => $shortUrl, 'longUrl' => $longUrl]);
    }
}
