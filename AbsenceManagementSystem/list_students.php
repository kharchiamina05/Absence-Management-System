<?php
require_once __DIR__ . '/db_connect.php';
$pdo = getDbConnection();

$stmt = $pdo->query("SELECT * FROM students ORDER BY id DESC");
$students = $stmt->fetchAll();
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Students List</title></head>
<body>
<h1>Students</h1>
<p><a href="add_student.php">Add student</a></p>
<table border="1" cellpadding="6">
<tr><th>ID</th><th>Fullname</th><th>Matricule</th><th>Group</th><th>Actions</th></tr>
<?php foreach($students as $s): ?>
<tr>
  <td><?=htmlspecialchars($s['id'])?></td>
  <td><?=htmlspecialchars($s['fullname'])?></td>
  <td><?=htmlspecialchars($s['matricule'])?></td>
  <td><?=htmlspecialchars($s['group_id'])?></td>
  <td>
    <a href="update_student.php?id=<?=urlencode($s['id'])?>">Edit</a> |
    <a href="delete_student.php?id=<?=urlencode($s['id'])?>" onclick="return confirm('Delete?')">Delete</a>
  </td>
</tr>
<?php endforeach; ?>
</table>
</body>
</html>