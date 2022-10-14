<?php

namespace Model;

require_once 'vendor/autoload.php';

abstract class ProductAbstract implements ModelDB
{
    const TABLE = 'Products';

    const FIELDS = ['name', 'cost', 'manufacture', 'date', 'service', 'product', 'user_email'];

    protected $service;

    protected $user;

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
        $this->service = array_key_exists('service', $data) ? $data['service'] : '';
        $this->user = $data['email'];

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

    public static function find($findBy, $parameter)
    {
        $products = Database::find(self::class, $findBy, $parameter);

        if (!$products) {
            return false;
        }

        $data = [];

        foreach ($products as $product){
            if($product['service']){//TODO: переделать таблицу сервис и подгружать оттуда данные если есть значение в  ячейке
                //$data[] = array_merge($product, ['service_cost' => new $product['service']()])
            }
        }


        return $products;
    }

    public function getValues(): array
    {
        return [
            'name' => $this->name,
            'date' => $this->date,
            'manufacture' => $this->manufacture,
            'cost' => $this->cost,
            'service' => $this->service ? '' : $this->service->getService(),
            'product' => $this->getProduct(),
            'user_email' => $this->user
        ];
    }

    public abstract function getProduct();

    public function getId()
    {
        return $this->id;
    }
}