<?php
$host = "localhost";
$user = "root"; // default MAMP username
$pass = "root"; // default MAMP password
$db   = "absence_management_system";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$student_id = $_POST['student_id'];
$last_name  = $_POST['last_name'];
$first_name = $_POST['first_name'];
$email      = $_POST['email'];

$sql = $conn->prepare("INSERT INTO students (student_id, last_name, first_name, email) VALUES (?, ?, ?, ?)");
$sql->bind_param("ssss", $student_id, $last_name, $first_name, $email);

if ($sql->execute()) {
    echo "<h2 style='color:green;text-align:center;'>Student Added Successfully!</h2>";
    echo "<p style='text-align:center;'><a href='AddNewStudent.html'>Back</a></p>";
} else {
    echo "Error: " . $sql->error;
}

$conn->close();
?>