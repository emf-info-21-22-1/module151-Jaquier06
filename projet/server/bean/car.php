<?php
class Car
{
    private $pk_car;
    private $model;
    private $price;
    private $brand;

    public function initFromDb($data)
    {
        $this->pk_car = $data["pk_car"];
        $this->model = $data["model"];
        $this->price = $data["price"];
        $this->brand = $data["brand"];
    }

    public function getPKCar()
    {
        return $this->pk_car;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getBrand()
    {
        return $this->brand;
    }
}