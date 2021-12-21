<?php

declare(strict_types=1);

namespace App\Service;

use App\Helpers\ShortUrl;
use App\Models\ShortLink;
use Illuminate\Support\Facades\Auth;

class ShortLinkGenerator
{
    public function __construct(
        private KeyGeneratorInterface $keyGenerator
    ) {
    }

    public function generate(ShortGenerate $request): ShortLink
    {
        $link = $this->checkLongUrl($request->getUserId(), $request->getLongUrl());
        if (!$link) {
            $link = new ShortLink();
            $link->long_url = $request->getLongUrl();
            $link->short_url = '';
            $link->user_id = $request->getUserId();
            $link->save();
            $short = ShortUrl::idToShortUrl($link->id);

            while ($this->checkBlackList($short)) {
                $link->delete();
                $link = new ShortLink();
                $link->long_url = $request->getLongUrl();
                $link->short_url = '';
                $link->user_id = $request->getUserId();
                $link->save();
                $short = ShortUrl::idToShortUrl($link->id);
            }
            if ($request->isWithKey()) {
                $short = $short . '/' . $this->keyGenerator->generate();
            }
            $link->expiration_date = $request->getDate();
            $link->short_url = $short;
            $link->save();
        }
        return $link;
    }

    public function generateNamed(NamedShortGenerate $request): ShortLink
    {
        $link = $this->checkLongUrl($request->getUserId(), $request->getLongUrl());
        if (!$link) {
            $data = ShortLink::where('short_url', $request->getName())->first();
            if ($data) {
                throw new ValidationException(['name' => 'The name already exist']);
            } else if ($this->checkBlackList($request->getName())) {
                throw new ValidationException(['name' => 'You are using bad words']);
            } else {
                $link = new ShortLink();
                $link->long_url = $request->getLongUrl();
                $link->short_url = $request->getName();
                $link->user_id = $request->getUserId();
                $link->expiration_date = $request->getDate();
                $link->save();
            }
        }
        return $link;
    }

    public function checkBlackList(string $shortUrl): bool
    {
        $blackWords = config('blackList');
        return in_array(strtolower($shortUrl), $blackWords);
    }

    public function checkLongUrl(int $userId, string $longUrl): ?ShortLink
    {
        return ShortLink::where('long_url', $longUrl)->where('user_id', $userId)->first();
    }
}
