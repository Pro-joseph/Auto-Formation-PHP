<?php
include ("db.php");
session_start();

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

        <label>Email</label>
        <input type="email" name="email" required><br>

        <label>Password</label>
        <input type="password" name="password" required><br>

        <button type="submit">Sign up</button>
    </form>

    </div>

</body>
</html>