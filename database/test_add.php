<?php

require 'db.php';

$title  = "Learning PHP";
$author = "John Smith";
$price  = 150;
$category_id = 1;

$sql = "INSERT INTO library_books (title, author, price, category_id)
        VALUES (:title, :author, :price, :category_id)";

$stmt = $conn->prepare($sql);

$stmt->execute([
    'title'  => $title,
    'author' => $author,
    'price'  => $price,
    'category_id' => $category_id
]);

$id = $conn->lastInsertId();

echo "Success! Book added with ID: " . $id;

?>