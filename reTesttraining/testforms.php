<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>test feedback</title>
</head>
<body>
   


<?php

//required
$name = $email = $message = $number = $message = "";
$nameERR = $emailERR = $messageERR = $numberERR = $messageERR = "";

if($_SERVER["REQUEST_METHOD"] === "POST"){
        if(empty($_POST['name'])){
            $nameERR = "* Name is required";
        }else{
            $name = input_test($_POST['name']);
        }
        if(empty($_POST['email'])){
            $emailERR = "* email is required";
        }else{
            $email = input_test($_POST['email']);
            if(strpos($email, '@') === false){
                $emailERR = "E-mail must contain @";
            }
        }
        if(empty($_POST['number'])){
            $numberERR = "* rate is required";
        }else{
            $number = input_test($_POST['number']);
            if($number < 1 || $number > 5){
                $numberERR = "Rate must be from 1 to 5";
            }
        }
        if(empty($_POST['message'])){
            $messageERR = "* message is required";
        }else{
            $message = input_test($_POST['message']);
        }
}

// input_test
function input_test($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


?>

 <form action="" method="POST" class="m-5 b-1">
        <div class="mt-3 mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" value="<?= $name ?>">
            <span class="text-danger"><?= $nameERR ?></span>
        </div>
        <div class="mt-3 mb-3">
            <label for="email" class="form-email">E-mail</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Enter your Email" value="<?= $email ?>">
            <span class="text-danger"><?= $emailERR ?></span>
        </div>
        <div class="mt-3 mb-3">
            <label for="number" class="form-rate">Rating (number between 1 and 5)</label>
            <input type="number" class="form-control" id="number" name="number" placeholder="rate max 5" >
            <span class="text-danger"><?= $numberERR ?></span>
        </div>
        <div class="mt-3 mb-3">
            <label for="message" class="form-message">Rate on 5</label>
            <textarea type="text" class="form-control" placeholder="Your Feedback" name="message"></textarea>
            <span class="text-danger"><?= $messageERR ?></span>
        </div>
        <button type="Submit" class="btn btn-primary">Submit</button>
    </form>

<?php
if($_SERVER["REQUEST_METHOD"] === "POST" 
   && !$nameERR && !$emailERR && !$numberERR && !$messageERR){

echo "Name: $name <br>
Email: $email<br>
Rating: $number<br>
Message: $message<br>";

}

?>

