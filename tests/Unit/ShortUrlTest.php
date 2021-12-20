<?php

namespace Tests\Unit;

use App\Helpers\ShortUrl;
use PHPUnit\Framework\TestCase;

class ShortUrlTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     * @dataProvider provider
     */
    public function test_short_url($id, $res)
    {
        $short = ShortUrl::idToShortUrl($id);
        self::assertSame($res, $short);
    }

    public function provider()
    {
        return [[3, 'ad'],[1, 'ab'],[4, 'ae']];
    }
}
