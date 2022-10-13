<?php

namespace Model;

require_once 'Database.php';

interface ModelDB
{
    public function getTable();

    public function getId();

    public function save();

    public function getValues(): array;
}