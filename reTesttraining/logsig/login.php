<?php
include("db.php");
session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if(empty($username) || empty($password)){
        die('fields are empty');
    }

    $stmt = $conn->prepare('select * from users where username = ?');
    $stmt->execute([$username]);

    $user = $stmt->fetch();

    if($user && password_verify($password, $user['password'])){
        header('Location: index.php');
    }else{
        echo "wrong user";
    }


}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<body>
    <div>
        <form method="POST">
        <label>Username</label>
        <input type="text" name="username" required><br>

        <label>Password</label>
        <input type="password" name="password" required><br>

        <button type="submit">log in</button>
        <button name="signup" type="submit"><a href="signup.php">sign up</a></button>
    </form>

    </div>

</body>
</html>