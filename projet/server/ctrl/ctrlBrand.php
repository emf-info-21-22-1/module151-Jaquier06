<?php
class CtrlBrand
{
    private $manager;

    public function __construct()
    {
        $this->manager = new WrkBrand();
    }

    public function getBrand()
    {
        $brands = $this->manager->getBrandFromDB();
        echo $brands;
    }
}
