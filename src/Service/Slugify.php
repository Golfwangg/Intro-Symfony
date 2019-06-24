<?php


namespace App\Service;

class Slugify
{
    public function generate(string $input) : string
    {
        $input = iconv('UTF-8', 'ASCII//TRANSLIT', $input);
        $input = preg_replace('/[!-,]/', '', $input);
        $input = trim($input);
        $input = str_replace(' ', '-', $input);

        return strtolower($input);
    }
}
