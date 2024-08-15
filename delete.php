<?php
include 'db.php';

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch the image path to delete it from the server
    $sql = "SELECT image FROM student WHERE id = $id";
    $result = $conn->query($sql);
    $student = $result->fetch_assoc();
    $image_path = "uploads" . $student['image'];

    // Delete the student record
    $sql = "DELETE FROM student WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        // Delete the image file
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        header("Location: index.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
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

<h2>Delete Student</h2>
<p>Are you sure you want to delete this student?</p>

<form method="post">
    <button type="submit">Yes, Delete</button>
    <a href="index.php">Cancel</a>
</form>
</body>
</html>