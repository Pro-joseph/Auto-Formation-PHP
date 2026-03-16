<?php
require 'db.php';  // make sure $pdo is defined in db.php

// Fetch all categories
$sql = "SELECT id, name FROM categories";
$stmt = $conn->prepare($sql);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<select name="category_id">
<?php foreach ($categories as $category): ?>
    <option value="<?php echo $category['id']; ?>">
        <?php echo $category['name']; ?>
    </option>
<?php endforeach; ?>
</select>