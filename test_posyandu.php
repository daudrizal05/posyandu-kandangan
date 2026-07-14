<?php
try {
    $pdo = new PDO("pgsql:host=localhost;port=5432;dbname=db_estunting", "postgres", "admin123");
    $stmt = $pdo->query("SELECT status, COUNT(*) FROM posyandu GROUP BY status");
    foreach($stmt->fetchAll() as $row) {
        echo $row['status'] . ": " . $row['count'] . "\n";
    }
} catch (Exception $e) { echo $e->getMessage(); }
