<?php
require_once "displayusermodel.php";

class DisplayUserController
{
    private $displayuser;

    public function __construct()
    {
        $this->displayuser = new DisplayUsers();
    }

    public function index()
    {
        return $this->displayuser->getAllUsers();
    }
}

