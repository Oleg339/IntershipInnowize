<?php

namespace Model;

require_once 'vendor/autoload.php';

abstract class ServiceAbstract implements ModelDB
{
    const TABLE = 'Services';

    const FIELDS = ['deadline', 'cost', 'service'];

    protected $id;

    protected $deadline;

    protected $cost;

    public function __construct($data)
    {
        $this->cost = $data['cost'];
        $this->deadline = $data['deadline'];

        return $this;
    }

    public function getTable()
    {
        return self::TABLE;
    }

    public abstract function getService();

    public function getId()
    {
        return $this->id;
    }

    public function save()
    {
        $this->id = Database::store($this);

        return $this;
    }

    public static function find($findBy, $parameter)
    {
        $service = Database::find(self::class, $findBy, $parameter);

        if (!$service) {
            return false;
        }

        return $service;
    }

    public function getValues(): array
    {
        return [
            'deadline' => $this->deadline,
            'cost' => $this->cost,
            'service' => $this->getService()
        ];
    }
}