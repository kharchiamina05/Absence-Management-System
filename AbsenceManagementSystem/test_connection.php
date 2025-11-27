<?php
require_once __DIR__ . '/db_connect.php';
try {
    $pdo = getDbConnection();
    echo "Connection successful";
} catch (Exception $e) {
    echo "Connection failed: " . htmlspecialchars($e->getMessage());
}