<?php
try {
    $pdo = new PDO("pgsql:host=localhost;port=5432;dbname=db_estunting", "postgres", "admin123");
    $tables = ['balita', 'posyandu', 'berita', 'pengukuran', 'ibu_hamil', 'users'];
    foreach($tables as $t) {
        $stmt = $pdo->query("SELECT COUNT(*) FROM $t");
        if($stmt) {
            echo "$t: " . $stmt->fetchColumn() . "\n";
        } else {
            echo "$t: table not found\n";
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
