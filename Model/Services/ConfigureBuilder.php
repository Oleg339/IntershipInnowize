<?php

namespace Model\Services;

require_once 'vendor/autoload.php';

use Model\ServiceBuilder;

class ConfigureBuilder implements ServiceBuilder
{
    private Configure $configure;

    private $cost;

    private $deadline;

    public function setCost(string $cost): ConfigureBuilder
    {
        $this->cost = $cost;

        return $this;
    }

    public function setDeadline(string $deadline): ConfigureBuilder
    {
        $this->deadline = $deadline;

        return $this;
    }

    public function build(): ConfigureBuilder
    {
        $this->configure = new Configure($this->cost, $this->deadline);

        return $this;
    }

    public function get(): Configure
    {
        return $this->configure;
    }
}