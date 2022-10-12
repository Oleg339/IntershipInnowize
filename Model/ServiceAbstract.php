<?php

abstract class ServiceAbstract implements ModelDB
{
    public function getTable()
    {
        return 'Service';
    }

    public abstract function getService();

    public abstract function getId();
}