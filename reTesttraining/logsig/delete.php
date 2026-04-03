<?php
include("db.php");
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied");
}
$id = $_GET['id'];
$stmt = $conn->prepare("delete from users where id = ?");
$stmt->execute([$id]);
header("Location: index.php");



?>