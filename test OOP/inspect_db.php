<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=manage_surf', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $tables = $db->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);
    echo "tables: " . implode(', ', $tables) . "\n";
    if (in_array('users', $tables)) {
        $cols = $db->query('SHOW COLUMNS FROM users')->fetchAll(PDO::FETCH_ASSOC);
        foreach ($cols as $c) {
            echo $c['Field'] . ' ' . $c['Type'] . ' ' . $c['Key'] . ' ' . $c['Extra'] . "\n";
        }
    }
} catch (Exception $e) {
    echo 'err:' . $e->getMessage();
}
