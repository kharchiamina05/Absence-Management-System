<?php
require_once __DIR__ . '/db_connect.php';
$pdo = getDbConnection();

$id = intval($_GET['id'] ?? 0);
if ($id > 0) {
    $stmt = $pdo->prepare("DELETE FROM student WHERE id=?");
    $stmt->execute([$id]);
}
header("Location: list_students.php");
exit;