<?php

namespace App\Helpers;

class ShortUrl
{
    //    id from the database
   public static function idToShortUrl(int $id):string
    {
        $arrayMap = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $shortUrl = [];
        while ($id > 0)
        {
            $shortUrl[] = $arrayMap[$id % 62];
            $id = (int) $id/62;
        }

        return implode ("", array_reverse($shortUrl));
    }
}
