<?php
class Brand
{
    private $pk_brand;
    private $brand;

    public function initFromDb($data)
    {
        $this->pk_brand = $data["pk_brand"];
        $this->brand = $data["brand"];
    }

    public function getPKBrand()
    {
        return $this->pk_brand;
    }

    public function getBrand()
    {
        return $this->brand;
    }
}