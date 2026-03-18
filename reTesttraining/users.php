<?php
require_once '../controller/auth.php';
require_once '../model/db.php';
require_once('../include/header.php');



if ($_SESSION['role'] !== 'admin') {
    die("Access denied");
}

// delete
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM users WHERE id = :id AND role = 'employee'");
    $stmt->execute(['id' => $id]);

    header("Location: manage_users.php");
    exit();
}

// edit user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_id'])) {

    $id = (int) $_POST['update_id'];
    $username = trim($_POST['username']);

    if (!empty($username)) {
        $stmt = $conn->prepare("UPDATE users SET username = :username WHERE id = :id AND role = 'employee'");
        $stmt->execute([
            'username' => $username,
            'id' => $id
        ]);
    }

    header("Location: users.php");
    exit();
}

// FETCH USERS
$stmt = $conn->prepare("SELECT id, username FROM users WHERE role = 'employee'");
$stmt->execute();
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<title>Manage Employees</title>
</head>

<body class="bg-light">

<div class="container mt-5">

    <h3 class="mb-4">Manage Employees</h3>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th width="250">Actions</th>
            </tr>
        </thead>
        <tbody>

        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>

                <td>
                    <form method="POST" class="d-flex">
                        <input type="hidden" name="update_id" value="<?= $user['id'] ?>">

                        <input type="text" name="username"
                               value="<?= htmlspecialchars($user['username']) ?>"
                               class="form-control me-2">

                        <button class="btn btn-success btn-sm">Update</button>
                    </form>
                </td>

                <td>
                    <a href="?delete=<?= $user['id'] ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Delete this employee?')">
                        Delete
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>

</div>

</body>
</html>