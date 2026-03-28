<?php
require 'auth.php';
require '../includes/config.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->execute([$id]);
}
header('Location: dashboard.php');
exit;
?>
