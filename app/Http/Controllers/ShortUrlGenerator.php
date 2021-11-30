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
use Illuminate\Support\Facades\Redirect;
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
        if (Redis::exists($short)) {
            $longUrl = Redis::get($short);
            return redirect()->away($longUrl);
        } else {
            $shortLink = ShortLink::where('short_url', $short)->first();
            if ($shortLink) {
                if ($shortLink->expiration_date && date('Y-m-d') > $shortLink->expiration_date) {
                    abort(404, 'Link expired');
                } else {
                    Redis::set(
                        $shortLink->short_url,
                        $shortLink->long_url,
                        $shortLink->expiration_date ? 'EXAT' : null,
                        strtotime($shortLink->expiration_date)
                    );
                }
                return redirect()->away($shortLink->long_url);
            }
            abort(404, 'Link not found');
        }
    }

    public function shortWithKey($short, $key)
    {
        $path = $short . '/' . $key;
        if (Redirect::exists($path)){
            $longUrl = Redirect::get($path);
            return redirect()->away($longUrl);
        }else{
            $shortLink = ShortLink::where('short_url', $path)->where('user_id', Auth::id())->first();
        }
        if ($shortLink) {
            if ($shortLink->expiration_date && date('Y-m-d') > $shortLink->expiration_date) {
                abort(404, 'Link expired');
            }else{
                Redirect::set(
                  $shortLink->short_url,
                  $shortLink->long_url,
                  $shortLink-> expiration_date ? 'EXAT' : null,
                  strtotime($shortLink->expiration_date)
                );
            }
            return redirect()->away($shortLink->long_url);
        }
        abort(404, 'Link not found');
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
