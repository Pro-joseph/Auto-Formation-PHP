<?php
include ("db.php");
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Get data
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    // 2. Validation
    if (empty($username) || empty($email) || empty($password)) {
        die("All fields are required");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email");
    }

    if (strlen($password) < 6) {
        die("Password must be at least 6 characters");
    }

    // 3. Check existing user
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
    $stmt->execute([$email, $username]);

    if ($stmt->fetch()) {
        die("User already exists");
    }

    // 4. Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // 5. Insert
    $stmt = $conn->prepare("
        INSERT INTO users (username, email, password)
        VALUES (:username, :email, :password)
    ");

    $stmt->execute([
        "username" => $username,
        "email" => $email,
        "password" => $hashed_password
    ]);

    echo "Signup successful";
    header('Location: login.php');
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

        <label>Email</label>
        <input type="email" name="email" required><br>

        <label>Password</label>
        <input type="password" name="password" required><br>

        <button type="submit">Sign up</button>
    </form>

    </div>

</body>
</html>