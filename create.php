<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];

    $image = $_FILES['image']['name'];
    $target_dir = "uploads" . DIRECTORY_SEPARATOR;
    $target_file = $target_dir . basename($image);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $valid_extensions = array("jpg", "png");

if (in_array($imageFileType, $valid_extensions)) {
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {

        $stmt = $conn->prepare("INSERT INTO student (name, email, address, class_id, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssis", $name, $email, $address, $class_id, $image);

        if ($stmt->execute()) {
            header("Location: index.php");
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo '<p style="color: red;">Failed to upload image.</p>';
    }
} else {
    echo '<p style="color: red;">Invalid image format. Only JPG and PNG are allowed.</p>';
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
    <link rel="icon" href="logo-removebg-preview.png" >
</head>
<body class="container mt-4">

<h2>Create Student</h2>
<form method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>Name:</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Email:</label>
        <input type="email" name="email" class="form-control">
    </div>

    <div class="form-group">
        <label>Address:</label>
        <textarea name="address" class="form-control"></textarea>
    </div>

    <div class="form-group">
        <label>Class:</label>
        <select name="class_id" class="form-control" required>
            <option value="" disabled selected>Select your class</option>
            <option value="1">6th</option>
            <option value="2">7th</option>
            <option value="3">8th</option>
            <option value="4">9th</option>
            <option value="5">10th</option>
        </select>
    </div>

    <div class="form-group">
        <label>Image:</label>
        <input type="file" name="image" class="form-control-file" required>
    </div>

    <button type="submit" class="btn btn-primary">Create</button>
</form>

</body>
</html>
