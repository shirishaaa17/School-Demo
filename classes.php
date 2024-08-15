<?php
include 'db.php';

// Add new class
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_class'])) {
    $class_name = $_POST['class_name'];

    $sql = "INSERT INTO classes (name) VALUES ('$class_name')";
    if ($conn->query($sql) === TRUE) {
        header("Location: classes.php");
    } else {
        echo "Error: " . $conn->error;
    }
}

// Delete class
if (isset($_GET['delete'])) {
    $class_id = $_GET['delete'];

    $sql = "DELETE FROM classes WHERE class_id = $class_id";
    if ($conn->query($sql) === TRUE) {
        header("Location: classes.php");
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch all classes
$sql = "SELECT * FROM classes";
$result = $conn->query($sql);
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

<h2>Manage Classes</h2>

<h3>Add New Class</h3>
<form method="post">
    <input type="text" name="class_name" required>
    <button type="submit" name="add_class">Add Class</button>
</form>

<h3>Class List</h3>
<table>
    <tr>
        <th>Name</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['name'] ?></td>
            <td>
                <a href="edit_class.php?class_id=<?= $row['class_id'] ?>">Edit</a>
                <a href="classes.php?delete=<?= $row['class_id'] ?>">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
</body>
</html>