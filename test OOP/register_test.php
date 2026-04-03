<?php
session_start();
require_once 'usercontroller.php';
$auth = new AuthController();
$auth->register();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
</head>

<body>
  <form action="" method="post" style="border:1px solid #ccc">
    <div class="container">
      <h1>Sign Up</h1>
      <p>Please fill in this form to create an account.</p>
      <hr>

      <label for="email"><b>Email</b></label>
      <input type="email" placeholder="Enter Email" name="email" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="psw" required>

      <label for="psw-repeat"><b>Repeat Password</b></label>
      <input type="password" placeholder="Repeat Password" name="psw-repeat" required>

      <div class="clearfix">
        <button type="button" class="cancelbtn" onclick="window.location.href='login_test.php';">Go to Login</button>
        <button type="button" class="cancelbtn" onclick="window.location.href='index.php';">Home</button>
        <button type="submit" class="signupbtn" name="register">Sign Up</button>
      </div>
    </div>
  </form>
</body>

</html>