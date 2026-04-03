<?php
include("db.php");
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied");
}

$id = $_GET['id'];
$stmt = $conn->prepare("select * from users where id = ?");
$stmt->execute([$id]);
$update = $stmt->fetch();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);

$stmt = $conn->prepare("update users set username=?,email=? where id=?");
$stmt->execute([$username,$email,$id]);
    echo "updated";
    header("Location: index.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit</title>
</head>
<body>
    <div>
        <form method="POST">
            
        <label>Username</label>
        <input type="text" name="username"  value="<?php echo $update['username'] ?>" required><br>

        <label>Email</label>
        <input type="email" name="email" value="<?php echo $update['email'] ?>" required><br>

        <button type="submit">update</button>
        
    </form>
</body>
</html>