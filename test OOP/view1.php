<?php
require_once "displayusercontroller.php";
$view = new DisplayUserController();
$users = $view->index();



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <?php foreach ($users as $user): ?>

        <table class="table">
            <thead>
                <tr>
                    <th>email</th>
                    <th>role</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $user['email']; ?></td>
                    <td><?= $user['role']; ?></td>
                </tr>
            </tbody>
        </table>
    <?php endforeach; ?>
</body>

</html>