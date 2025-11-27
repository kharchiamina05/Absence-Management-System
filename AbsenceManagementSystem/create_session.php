<?php
require_once __DIR__ . '/db_connect.php';
$pdo = getDbConnection();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Send POST with course_id, group_id, opened_by";
    exit;
}

$course_id = intval($_POST['course_id'] ?? 0);
$group_id = intval($_POST['group_id'] ?? 0);
$opened_by = intval($_POST['opened_by'] ?? 0);
$session_date = $_POST['date'] ?? date('Y-m-d');

if ($course_id <= 0 || $group_id <= 0 || $opened_by <= 0) {
    die("Missing required values.");
}

$stmt = $pdo->prepare("INSERT INTO attendance_sessions (course_id, group_id, date, opened_by, status) VALUES (?, ?, ?, ?, 'open')");
$stmt->execute([$course_id, $group_id, $session_date, $opened_by]);
$sessionId = $pdo->lastInsertId();

echo json_encode(['success' => true, 'session_id' => $sessionId]);