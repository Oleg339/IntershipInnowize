<?php

use Model\ServiceAbstract;
use Model\User;

require_once 'ModelDB.php';

abstract class ProductAbstract implements ModelDB
{
    const TABLE = 'Products';

    const FIELDS = ['name', 'cost', 'manufacture', 'date', 'service', 'product'];

    protected ServiceAbstract $service;

    protected User $user;

    protected $id;

    protected $name;

    protected $cost;

    protected $manufacture;

    protected $date;

    public function __construct($data)
    {
        $this->name = $data['name'];
        $this->date = $data['date'];
        $this->manufacture = $data['manufacture'];
        $this->cost = $data['cost'];
        $this->service = $data['service'];
        $this->user = $data['user'];

        return $this;
    }

    public function save()
    {
        $this->id = Database::store($this);
        return $this;
    }

    public function getTable()
    {
        return self::TABLE;
    }

    public static function hello(){
        echo 'hello';
    }


    public function getValues(): array
    {
        return [
            'name' => $this->name,
            'date' => $this->date,
            'manufacture' => $this->manufacture,
            'cost' => $this->cost,
            'service' => $this->service->getService(),
            'product' => $this->getProduct(),
            'id' => $this->id
        ];
    }

    public function setService(ServiceAbstract $service)
    {
        $this->service = $service;
    }

    public abstract function getProduct();

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCost()
    {
        return $this->cost;
    }

    public function getManufacture()
    {
        return $this->manufacture;
    }

    public function getDate()
    {
        return $this->date;
    }
}