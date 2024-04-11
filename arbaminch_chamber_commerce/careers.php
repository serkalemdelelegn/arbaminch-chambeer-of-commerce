<?php
require("./path/to/database/connection/file.php"); // Database connection file

$title = $_POST["title"];
$short_description = $_POST["short_description"];
$long_description = $_POST["long_description"];

$filename = $_FILES["image"]["name"];
$filetype = $_FILES["image"]["type"];
$tempfile = $_FILES["image"]["tmp_name"];
$targetDirectory = "uploads/";
$filenameWithDirectory = $targetDirectory . basename($filename);

// Validate the file type
$allowedTypes = ['image/jpeg', 'image/png'];
if (!in_array($filetype, $allowedTypes)) {
    echo "<center><h1>Only JPEG and PNG files are allowed.</h1></center>";
    exit;
}

// Attempt to move the uploaded file
if (!move_uploaded_file($tempfile, $filenameWithDirectory)) {
    echo "<center><h1>Error uploading image! Please try again.</h1></center>";
    exit;
}

// Insert news into the database
try {
    $stmt = $pdo->prepare("INSERT INTO news (title, short_description, long_description, image_path) VALUES (?, ?, ?, ?)");
    $stmt->execute([$title, $short_description, $long_description, $filenameWithDirectory]);
    echo '<center><h1>News posted successfully!</h1></center>';
} catch (PDOException $e) {
    echo "<center><h1>Error: " . $e->getMessage() . "</h1></center>";
}
?>
