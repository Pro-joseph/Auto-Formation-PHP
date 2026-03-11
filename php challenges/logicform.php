<?php
    $name = $email ="";
    $nameErr = $emailErr ="";

    if($_SERVER["REQUEST_METHOD"] == "GET"){
        if(empty($_GET["name"])){
            $nameErr = "* Name is required";
        }else{
            $name = test_input($_GET['name']);
        }
         if(empty($_GET["email"])){
            $nameErr = "* Email is required";
        }else{
            $name = test_input($_GET['email']);
        }

    }
function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

echo "Your name is:". "<h3>". $_GET['name']. "</h3>";


?>