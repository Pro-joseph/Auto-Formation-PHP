<?php

require 'db.php';

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

    <li>
        <?php echo $categories['title']; ?> — <strong><?php echo $categories['category']; ?></strong>
    </li>

<?php endforeach; ?>

</select>