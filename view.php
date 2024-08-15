<?php
include 'db.php';

$id = $_GET['id'];
$sql = "SELECT student.*, classes.name AS class_name FROM student 
        JOIN classes ON student.class_id = classes.class_id 
        WHERE student.id = $id";
$result = $conn->query($sql);
$student = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Demo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/styles.css">
    <link rel="icon" href="logo-removebg-preview.png">
</head>
<body class="container mt-4">

<h2>Student Details</h2>
<p>Name: <?= $student['name'] ?></p>
<p>Email: <?= $student['email'] ?></p>
<p>Address: <?= $student['address'] ?></p>
<p>Class: <?= $student['class_name'] ?></p>
<p>Created At: <?= $student['created_at'] ?></p>
<img src="uploads/<?= $student['image'] ?>" width="100">
<br><br>
<a href="index.php">Back to List</a>
</body>
</html>