<?php

namespace App\Helpers;

class Main
{
    public function getRandomArrayElement(array $array)
    {
        return $array[array_rand($array)];
    }
}