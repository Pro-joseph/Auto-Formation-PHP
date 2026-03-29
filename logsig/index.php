<?php
include("db.php");
session_start();

            $stmt = $conn->prepare("SELECT * FROM users");
            $stmt->execute();
            $users = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <table>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($users as $user) {
                echo "<tr>";
                echo "<td>" . $user['username'] . "</td>";
                echo "<td>" . $user['email'] . "</td>";
                echo "<td><a href='edit.php?id=" . $user['id'] . "'>Edit</a> | <a href='delete.php?id=" . $user['id'] . "'>Delete</a></td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>