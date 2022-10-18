<?php

namespace Model;

require_once 'vendor/autoload.php';

interface ServiceBuilderInterface
{
    public function setCost(string $cost): ServiceBuilderInterface;

    public function setDeadline(string $deadline): ServiceBuilderInterface;

    public function build(): ServiceBuilderInterface;

    public function get(): Service;
}