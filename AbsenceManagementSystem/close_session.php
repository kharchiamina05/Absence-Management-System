<?php
require_once __DIR__ . '/db_connect.php';
$pdo = getDbConnection();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Send POST with session_id";
    exit;
}

$session_id = intval($_POST['session_id'] ?? 0);
if ($session_id <= 0) die("Invalid session_id");

$stmt = $pdo->prepare("UPDATE attendance_sessions SET status = 'closed' WHERE id = ?");
$stmt->execute([$session_id]);

echo json_encode(['success' => true, 'session_id' => $session_id]);