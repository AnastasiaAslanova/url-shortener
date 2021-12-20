<?php

namespace Tests\Unit;

use App\Service\KeyGenerator;
use PHPUnit\Framework\TestCase;

class KeyGeneratorTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     * @dataProvider provider
     */
    public function test_key_generator($length)
    {
        $key = new KeyGenerator();
        $res = $key->generate($length);
        $this->assertSame($length, strlen($res));
    }
    public function provider()
    {
        return [[2],[3],[4],[5],[6]];
    }
}
