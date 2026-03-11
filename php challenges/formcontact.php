<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Contact form</title>
</head>
<body>
  

<?php

// required

    $name = $email = $message ="";
    $nameErr = $emailErr = $messageErr ="";

    if($_SERVER["REQUEST_METHOD"] === "POST"){
        if(empty($_POST["name"])){
            $nameErr = "* Name is required";
        }else{
            $name = test_input($_POST['name']);
        }
         if(empty($_POST["email"])){
            $emailErr = "* Email is required";
        }else{
            $email = test_input($_POST['email']);
            if(strpos($email, '@') === false){
            $emailErr = "* Email must contain @";
            }
        }
        if(empty($_POST["message"])){
            $messageErr = "* Message is required";
        }else{
            $message = test_input($_POST['message']);
        }

    }
function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// validation email
// $str = $_POST['email'];
// $pattern = "@";
// $messing = strpos($str, $pattern);


?>

  <form action="" method="post" class="m-5 b-1">
        <div class="mb-3 mt-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" placeholder="Enter your name" name="name" value="<?= $name ?>">
            <span class="text-danger"><?= $nameErr ?></span>
        </div>
        <div class="mb-3 mt-3">
            <label for="Email" class="form-Email">E-mail</label>
            <input type="text" class="form-control" id="email" placeholder="Enter your E-mail" name="email" value="<?= $email ?>">
            <span class="text-danger"><?= $emailErr ?></span>
        </div>
        <div class="mb-3 mt-3">
            <label for="message" class="form-Message">Message</label>
            <textarea type="text" class="form-control" id="message" placeholder="Enter your Message" name="message"></textarea>
            <span class="text-danger"><?= $messageErr ?></span>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

<?php
echo "Your name is: ". $name. "<br>";
echo "Your email is: ". $email. "<br>";
echo "Your message is: ". $message. "<br>";
?>
</body>
</html>