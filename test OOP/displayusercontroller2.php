<?php
require_once "displayusermodel.php";

class DisplayUserController2
{

    private $displayuser2;

    public function __construct()
    {
        $this->displayuser2 = new Displayusers();
    }

    public function index()
    {
        return $this->displayuser2->getAllUsers();
    }

}



?>