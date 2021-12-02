<?php

namespace App\Helpers;

class Counter
{
    public $count = 0;

    public function increment()
    {
        $this->count++;
    }

    public function dicrement()
    {
        $this->count--;
    }

}
