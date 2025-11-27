<?php
date_default_timezone_set('Europe/Algiers'); // adjust as needed

$studentsFile = __DIR__ . '/students.json';
$today = date('Y-m-d');
$outFile = __DIR__ . "/attendance_{$today}.json";
$message = "";

$students = [];
if (file_exists($studentsFile)) {
    $json = file_get_contents($studentsFile);
    $students = json_decode($json, true) ?? [];
} else {
    $message = "students.json not found. Please create it first.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (file_exists($outFile)) {
        $message = "Attendance for today has already been taken.";
    } else {
        $attendance = [];
        foreach ($students as $s) {
            $id = $s['student_id'] ?? ($s['studentId'] ?? null);
            if ($id === null) continue;

            $fieldName = 'status_' . $id;
            $status = isset($_POST[$fieldName]) && $_POST[$fieldName] === 'present' ? 'present' : 'absent';

            $attendance[] = [
                'student_id' => (string)$id,
                'status' => $status
            ];
        }

        file_put_contents($outFile, json_encode($attendance, JSON_PRETTY_PRINT));
        $message = "Attendance saved to attendance_{$today}.json";
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Take Attendance - <?= htmlentities($today) ?></title>
    <style>label{margin-right:10px;} table{border-collapse:collapse;} td,th{padding:6px;border:1px solid #ccc;}</style>
</head>
<body>
    <h1>Take Attendance (<?= htmlentities($today) ?>)</h1>
    <?php if($message): ?><p><strong><?=htmlentities($message)?></strong></p><?php endif; ?>

    <?php if (!file_exists($outFile) && !empty($students)): ?>
        <form method="post">
            <table>
                <thead><tr><th>Student ID</th><th>Name</th><th>Present</th><th>Absent</th></tr></thead>
                <tbody>
                    <?php foreach($students as $s): 
                    $id = $s['student_id'] ?? ($s['studentId'] ?? '');
                    $name = $s['name'] ?? (($s['last_name'] ?? '') . ' ' . ($s['first_name'] ?? ''));
                    ?>
                    <tr>
                        <td><?=htmlspecialchars($id)?></td>
                        <td><?=htmlspecialchars($name)?></td>
                        <td><label><input type="radio" name="status_<?=htmlspecialchars($id)?>" value="present" checked></label></td>
                        <td><label><input type="radio" name="status_<?=htmlspecialchars($id)?>" value="absent"></label></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p><button type="submit">Save Attendance</button></p>
        </form>
        <?php endif; ?>

        <?php if (empty($students)): ?>
            <p>No students available to take attendance.</p>
        <?php endif; ?>

    <p><a href="StudentAttendance.html">Back to Attendance</a></p>
</body>
</html>