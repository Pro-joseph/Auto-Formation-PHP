<?php
// 1️⃣ Enable errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) session_start();

include '../model/db.php';

if (!isset($_FILES['csv_file']['tmp_name']) || empty($_FILES['csv_file']['tmp_name'])) {
    $_SESSION['error'] = "No file uploaded.";
    header("Location: ../view/index.php");
    exit;
}

$file = $_FILES['csv_file']['tmp_name'];

if (($handle = fopen($file, 'r')) === false) {
    $_SESSION['error'] = "Cannot open CSV file.";
    header("Location: ../view/index.php");
    exit;
}

$successCount = 0;
$errorCount = 0;

$header = fgetcsv($handle);

while (($row = fgetcsv($handle)) !== false) {

    if (count($row) < 5) {
        $errorCount++;
        continue;
    }

    $device_name   = trim($row[0]);
    $serial_number = trim($row[1]);
    $price         = trim($row[2]);
    $status        = trim($row[3]);
    $category_id   = trim($row[4]);

    if (!$device_name || !$serial_number || !$price) {
        $errorCount++;
        continue;
    }

    $check = $conn->prepare("SELECT id FROM assets WHERE serial_number = :serial");
    $check->execute(['serial' => $serial_number]);
    if ($check->rowCount() > 0) {
        $errorCount++;
        continue;
    }

    $stmt = $conn->prepare("
        INSERT INTO assets (device_name, serial_number, price, status, category_id)
        VALUES (:device_name, :serial_number, :price, :status, :category_id)
    ");

    if ($stmt->execute([
        'device_name'   => $device_name,
        'serial_number' => $serial_number,
        'price'         => $price,
        'status'        => $status,
        'category_id'   => $category_id
    ])) {
        $successCount++;
    } else {
        $errorCount++;
    }
}

// 9️⃣ Close file
fclose($handle);

// 10️⃣ Flash message
$_SESSION['success'] = "$successCount products imported successfully. $errorCount failed.";

// 11️⃣ Redirect back to index
header("Location: ../view/index.php");
exit;