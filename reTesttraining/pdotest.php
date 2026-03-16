<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_manager";


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "connected succesfullo";
}catch(PDOException $e){
    echo "connected denied". $e->getMessage();
}

?>