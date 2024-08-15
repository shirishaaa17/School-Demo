<?php
include 'db.php';

$sql = "SELECT student.*, classes.name AS class_name FROM student
        JOIN classes ON student.class_id=classes.class_id";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>School Demo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/styles.css">
    <link rel="icon" href="logo-removebg-preview.png">
</head>
<body class="container mt-4">

<h2>Student List</h2>

    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Class</th>
            <th>Created At</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['name'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['class_name'] ?></td>
                <td><?= $row['created_at'] ?></td>
                <td><img src="uploads/<?= $row['image'] ?>" width="50"/></td>
                <td>
                    <a href="view.php?id=<?= $row['id'] ?>">View</a>
                    <a href="edit.php?id=<?= $row['id'] ?>">Edit</a>
                    <a href="delete.php?id=<?= $row['id'] ?>">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

</body>
</html>
