<?php

namespace App\Service;

interface KeyGeneratorInterface
{
    const DEFAULT_KEY_LENGTH = 6;

    public function generate(int $length = self::DEFAULT_KEY_LENGTH): string;
}
