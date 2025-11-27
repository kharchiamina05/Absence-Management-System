<?php
require_once __DIR__ . '/db_connect.php';
$pdo = getDbConnection();

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) die('Invalid id');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname'] ?? '');
    $matricule = trim($_POST['matricule'] ?? '');
    $group_id = trim($_POST['group_id'] ?? '');
    if ($fullname === '' || $matricule === '') {
        $msg = "Fullname and matricule required.";
    } else {
        $stmt = $pdo->prepare("UPDATE student SET fullname=?, matricule=?, group_id=? WHERE id=?");
        $stmt->execute([$fullname, $matricule, $group_id ?: null, $id]);
        header("Location: list_students.php");
        exit;
    }
}

// fetch
$stmt = $pdo->prepare("SELECT * FROM student WHERE id=?");
$stmt->execute([$id]);
$student = $stmt->fetch();
if (!$student) die('Student not found');
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Edit Student</title></head><body>
<h1>Edit Student</h1>
<?php if(!empty($msg)) echo "<p>$msg</p>"; ?>
<form method="post">
  <label>Fullname: <input name="fullname" value="<?=htmlspecialchars($student['fullname'])?>"></label><br>
  <label>Matricule: <input name="matricule" value="<?=htmlspecialchars($student['matricule'])?>"></label><br>
  <label>Group: <input name="group_id" value="<?=htmlspecialchars($student['group_id'])?>"></label><br>
  <button type="submit">Save</button>
</form>
<p><a href="list_students.php">Back</a></p>
</body></html>