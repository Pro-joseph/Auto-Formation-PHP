<?php
// in page where is form or where is data
// for example register.php

require_once usercontroller.php;
$auth = Authcontroller();
$auth->register();


//in usercontroller page
// we call the model page 
// we ask for the function that handle the register

require_once usermodel.php;
// we use function construct to call the function in model
// class AuthController {
//     private $userModel;
//     public function __construct() {
//         $this->userModel = new UserModel();
//     }

//model page
//we call database page
//the call the function of connection
// class UserModel {
//     public function __construct() {
//         $db = new Database();
//         $this->conn = $db->getConnection();
//     }


?>


classc ********{
    private $display;

    public function _constructor(){
        return $this->display = new model();
    }

    public function getUsers(){
         
    }
}