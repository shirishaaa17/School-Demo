<?php
include 'db.php';

$id = $_GET['id'];
$sql = "SELECT * FROM student WHERE id = $id";
$result = $conn->query($sql);
$student = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];

    // Image upload
    if ($_FILES['image']['name']) {
        $image = $_FILES['image']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate image
        $valid_extensions = array("jpg", "png");
        if (in_array($imageFileType, $valid_extensions)) {
            move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
        } else {
            echo "Invalid image format";
        }
    } else {
        $image = $student['image']; // retain old image if not changed
    }

    $sql = "UPDATE student SET name='$name', email='$email', address='$address', class_id='$class_id', image='$image' 
            WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch classes
$class_result = $conn->query("SELECT * FROM classes");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/styles.css">
    <link rel="icon" href="logo-removebg-preview.png">
</head>
<body class="container mt-4">

<h2>Edit Student</h2>
<form method="post" enctype="multipart/form-data">
    <label>Name:</label><br>
    <input type="text" name="name" value="<?= $student['name'] ?>" required><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?= $student['email'] ?>"><br>

    <label>Address:</label><br>
    <textarea name="address"><?= $student['address'] ?></textarea><br>

    <label>Class:</label><br>
    <select name="class_id">
        <?php while ($class = $class_result->fetch_assoc()): ?>
               <option value="<?= $class['class_id'] ?>" <?= $student['class_id'] == $class['class_id'] ? 'selected' : '' ?>>
               <?= $class['name'] ?>
           </option>
       <?php endwhile; ?>
   </select><br>

   <label>Image:</label><br>
   <input type="file" name="image"><br>
   <img src="uploads/<?= $student['image'] ?>" width="100"><br>
   <small>Leave this empty if you don't want to change the image.</small><br><br>

   <button type="submit">Update</button>
</form>

<a href="index.php">Back to List</a>
        </body>
</html>