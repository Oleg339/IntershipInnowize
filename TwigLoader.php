<?php

namespace Task18;

class TwigLoader
{
    public static function run()
    {
        require_once __DIR__ . '/vendor/autoload.php';

        $loader = new \Twig\Loader\FilesystemLoader('View');

        return new \Twig\Environment($loader);
    }
}
