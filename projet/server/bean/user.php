<?php
class User
{
    private $pk_user;
    private $username;
    private $password;

    private $money;

    public function initFromDb($data)
    {
        $this->pk_user = $data["pk_user"];
        $this->username = $data["username"];
        $this->password = $data["password"];
        $this->money = $data["money"];
    }

    public function getPKUser()
    {
        return $this->pk_user;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }
    public function getMoney()
    {
        return $this->money;
    }
}