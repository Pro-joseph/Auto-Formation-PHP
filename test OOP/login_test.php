<?php
session_start();
require_once 'usercontroller.php';
$auth = new AuthController();
$auth->login();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
</head>

<body>
  <form action="" method="post">
    <div class="container">
      <label for="email"><b>Email</b></label>
      <input type="email" placeholder="Enter Email" name="email" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="pswd" required>

      <button type="submit" name="login">Login</button>
      <label>
        <input type="checkbox" checked="checked" name="remember"> Remember me
      </label>
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" class="cancelbtn" onclick="window.location.href='register_test.php';">Go to
        Register</button>
      <button type="button" class="cancelbtn" onclick="window.location.href='index.php';">Home</button>
      <span class="psw">Forgot <a href="#">password?</a></span>
    </div>
  </form>
</body>

</html>