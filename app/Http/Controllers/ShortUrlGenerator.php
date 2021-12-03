<?php

namespace App\Http\Controllers;

use App\Models\ShortLink;
use App\Service\NamedShortGenerate;
use App\Service\ShortGenerate;
use App\Service\ShortLinkGenerator;
use App\Service\ValidationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;

class ShortUrlGenerator extends Controller
{
    public function generate(Request $request, ShortLinkGenerator $generator): RedirectResponse
    {
        $request->validate(
            [
                'long_url' => 'url',
                'date' => 'nullable|date_format:Y-m-d'
            ]
        );

        $type = $request->input('type', 'simpleShort');
        $link = $generator->generate(
            ShortGenerate::create(
                Auth::id(),
                $request->input('long_url'),
                $request->input('date'),
                'shortWithKey' === $type
            )
        );
        Session::flash('short', $link->short_url);
        Session::flash('long', $link->long_url);

        return redirect()->route('linkList');
    }

    public function generateNamed(Request $request, ShortLinkGenerator $generator): RedirectResponse
    {
        $request->validate(
            [
                'long_url' => 'url',
                'date' => 'nullable|date_format:Y-m-d'
            ]
        );

        try {
            $link = $generator->generateNamed(
                NamedShortGenerate::create(
                    Auth::id(),
                    $request->input('long_url'),
                    $request->input('date'),
                    $request->input('name')
                )
            );
            Session::flash('short', $link->short_url);
            Session::flash('long', $link->long_url);
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->getErrors());
        }

        return redirect()->route('linkList');
    }

    public function short($short)
    {
        if (Redis::exists('short_' . $short)) {
            $shortLink = Redis::hgetall('short_' . $short);
            $this->saveStat($shortLink['id']);
            return redirect()->away($shortLink['long_url']);
        } else {
            $shortLink = ShortLink::where('short_url', $short)->first();
            if ($shortLink) {
                if ($shortLink->expiration_date && date('Y-m-d') > $shortLink->expiration_date) {
                    abort(404, 'Link expired');
                }
                $this->saveLinkToCache($shortLink);
                $this->saveStat($shortLink->id);
                return redirect()->away($shortLink->long_url);
            }
            abort(404, 'Link not found');
        }
    }

    public function shortWithKey($short, $key)
    {
        $path = $short . '/' . $key;
        return $this->short($path);
    }

    private function saveStat($id)
    {
        DB::table('stats')->insert(
            [
                'short_url_id' => $id,
                'date' => date('Y-m-d')
            ]
        );
    }

    private function saveLinkToCache(ShortLink $short)
    {
        $key = 'short_' . $short->short_url;
        Redis::hmset(
            $key,
            'id',
            $short->id,
            'long_url',
            $short->long_url
        );
        if ($short->expiration_date) {
            Redis::expireat($key, strtotime($short->expiration_date));
        }
    }

    public function linkList(): View
    {
        $links = ShortLink::where('user_id', Auth::id())->orderByDesc('id')->get();

        return view('short-url-generator', ['links' => $links]);
    }

    public function deleteLink($id)
    {
        $link = ShortLink::where('id', $id)->first();
        if (!$link) {
            Session::flash('error', 'Link not found');
        }
        $link->delete();
        return redirect()->route('linkList');
    }

}
