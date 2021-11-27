<?php

namespace App\Http\Controllers;

use App\Helpers\ShortUrl;
use App\Models\ShortLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\ViewErrorBag;

class ShortUrlGenerator extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'long_url' => 'url',
        ]);

        $longUrl = $request->input('long_url');
        $link = $this->checkLongUrl($longUrl);
        if (!$link) {
            $link = new ShortLink();
            $link->long_url = $longUrl;
            $link->short_url = '';
            $link->user_id = Auth::id();
            $link->save();
            $short = ShortUrl::idToShortUrl($link->id);

            while ($this->checkBlackList($short)) {
                $link->delete();
                $link = new ShortLink();
                $link->long_url = $longUrl;
                $link->short_url = '';
                $link->save();
                $short = ShortUrl::idToShortUrl($link->id);
            }
            $type = $request->input('type');

            if ($type == "shortWithKey")
            {
                $short = $short.'/'.Str::random(6);
            }
            $link->short_url = $short;
            $link->user_id = Auth::id();
            $link->save();
        } else {
            Session::flash('short', $link->short_url);
            Session::flash('long', $link->long_url);
        }
        return redirect()->route('linkList');
    }

    public function generateNamed(Request $request, ViewErrorBag $messageBag)
    {
        $request->validate([
            'long_url' => 'url'
        ]);
        $longUrl = $request->input('long_url');
        $link = $this->checkLongUrl($longUrl);
        if (!$link) {
            $shortName = $request->input('name');
            $data = ShortLink::where('short_url', $shortName)->where('user_id',Auth::id())->first();
            if ($data) {
                return redirect()->back()->withErrors(['name' => 'The name already exist']);
            } else if ($this->checkBlackList($shortName)) {
                return redirect()->back()->withErrors(['name' => 'You are using bad words']);
            } else {
                $link = new ShortLink();
                $link->long_url = $longUrl;
                $link->short_url = $shortName;
                $link->user_id = Auth::id();
                $link->save();
            }
        } else {
            Session::flash('short', $link->short_url);
            Session::flash('long', $link->long_url);
        }
        return redirect()->route('linkList');
    }
    public function short($short)
    {
        $shortLink = ShortLink::where('short_url', $short)->first();
        if ($shortLink) {
            return redirect()->away($shortLink->long_url);
        } else {
            echo 'No such link exists';
        }
    }

    public function shortWithKey($short, $key)
    {
        $path = $short.'/'.$key;
        $shortLink = ShortLink::where('short_url', $path)->where('user_id',Auth::id())->first();
        if ($shortLink) {
            return redirect()->away($shortLink->long_url);
        } else {
            echo 'No such link exists';
        }
    }

    public function checkBlackList(string $shortUrl): bool
    {
        $blackWords = config('blackList');
        return in_array(strtolower($shortUrl), $blackWords);
    }

    public function checkLongUrl(string $longUrl): ?ShortLink
    {
        return ShortLink::where('long_url', $longUrl)->where('user_id',Auth::id())->first();
    }

    public function linkList()
    {
        $links = ShortLink::where('user_id',Auth::id())->orderByDesc('id')->get();

        return view('short-url-generator', ['links' => $links]);
    }



}
