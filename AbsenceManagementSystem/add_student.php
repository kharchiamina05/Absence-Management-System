<?php
// add_student.php (DB version)
require_once __DIR__ . '/db_connect.php';
$pdo = getDbConnection();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname'] ?? '');
    $matricule = trim($_POST['matricule'] ?? '');
    $group_id = trim($_POST['group_id'] ?? '');

    if ($fullname === '' || $matricule === '') {
        $message = "Full name and matricule are required.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO students (fullname, matricule, group_id) VALUES (?, ?, ?)");
        try {
            $stmt->execute([$fullname, $matricule, $group_id ?: null]);
            $message = "Student added successfully.";
        } catch (PDOException $e) {
            $message = "Error: " . htmlspecialchars($e->getMessage());
        }
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Add Student (DB)</title></head>
<body>
<h1>Add Student</h1>
<?php if($message): ?><p><?=htmlspecialchars($message)?></p><?php endif; ?>
<form method="post">
    <label>Full name: <input name="fullname"></label><br>
    <label>Matricule: <input name="matricule"></label><br>
    <label>Group id: <input name="group_id"></label><br>
    <button type="submit">Add</button>
</form>
<p><a href="list_students.php">View Students</a></p>
</body>
</html>