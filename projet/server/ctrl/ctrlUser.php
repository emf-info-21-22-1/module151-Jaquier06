<?php

class CtrlUser
{
    private $manager;
    public function __construct()
    {
        $this->manager = new WrkUser();
    }
    public function checkUser($username, $password, $session)
    {
        return $this->manager->selectUser($username, $password, $session);
    }

    public function createUser($username, $password, $session)
    {
        $this->manager->createUser($username, $password, $session);
    }

    public function ctrlGetUserInfos($username)
    {
        $this->manager->getUserInfos($username);
    }
}