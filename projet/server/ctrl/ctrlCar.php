<?php
class CtrlCar
{
    private $manager;

    public function __construct()
    {
        $this->manager = new WrkCar();
    }

    public function buyCar($user, $car)
    {
        echo $this->manager->updateBuyingCar($user, $car);
    }

    public function sellCar($user, $car)
    {
        echo $this->manager->updateSellingCar($user, $car);
    }

    public function getCar()
    {
        $cars = $this->manager->getCarFromDB();
        echo $cars;
    }

    public function getCarFromUser($user)
    {
        $cars = $this->manager->getCarFromUserFromDB($user);
        echo $cars;
    }

    public function newCar($brand, $model, $price, $user)
    {
        echo $this->manager->createCarInDB($brand, $model, $price, $user);
    }
}