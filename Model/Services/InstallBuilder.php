<?php

namespace Model\Services;

require_once 'vendor/autoload.php';

use Model\ServiceBuilder;

class InstallBuilder implements ServiceBuilder
{
    private Install $install;

    private $cost;

    private $deadline;

    public function setCost(string $cost): InstallBuilder
    {
        $this->cost = $cost;

        return $this;
    }

    public function setDeadline(string $deadline): InstallBuilder
    {
        $this->deadline = $deadline;

        return $this;
    }

    public function build(): InstallBuilder
    {
        $this->install = new Install($this->cost, $this->deadline);

        return $this;
    }

    public function get(): Install
    {
        return $this->install;
    }
}