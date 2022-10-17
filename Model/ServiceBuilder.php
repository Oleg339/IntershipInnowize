<?php

namespace Model;

require_once 'vendor/autoload.php';

interface ServiceBuilder
{
    public function setCost(string $cost): ServiceBuilder;

    public function setDeadline(string $deadline): ServiceBuilder;

    public function build(): ServiceBuilder;

    public function get(): Service;
}