<?php

namespace App\Tools\Coin;

class Ticker
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = strtoupper($name);
    }

    public function getName(): string
    {
        return $this->name;
    }


}