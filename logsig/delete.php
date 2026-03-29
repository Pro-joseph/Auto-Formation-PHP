<?php
include("db.php");
session_start();
$id = $_GET['id'];
$stmt = $conn->prepare("delete from users where id = ?");
$stmt->execute([$id]);
header("Location: index.php");



?>