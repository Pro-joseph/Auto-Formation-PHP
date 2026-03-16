<?php

require 'db.php';

$minPrice = 9;

$sql = "SELECT title FROM library_books WHERE price > :price";

$stmt = $conn->prepare($sql);

$stmt->execute(['price' => $minPrice]);

$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<ul>
<?php foreach ($books as $book): ?>
    <li><?php echo $book['title']; ?></li>
<?php endforeach; ?>
</ul>