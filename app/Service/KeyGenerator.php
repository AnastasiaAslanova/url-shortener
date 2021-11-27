<?php

declare(strict_types=1);

namespace App\Service;

use Illuminate\Support\Str;

class KeyGenerator implements KeyGeneratorInterface
{
    public function generate(int $length = self::DEFAULT_KEY_LENGTH): string
    {
        return Str::random($length);
    }
}
