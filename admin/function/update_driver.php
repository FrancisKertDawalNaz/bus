<?php
session_start();
include_once('../../connection.php');

if (!isset($_SESSION['driver_id'])) {
    die("Unauthorized access.");
}

$driver_id = $_SESSION['driver_id'];

$driver_name = trim($_POST['driver_name']);
$driver_custom_id = trim($_POST['driver_id']);
$password = trim($_POST['password']);

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$image_path = null;
$upload_dir = '../../driver/uploads/';
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);  
}

if (isset($_FILES['driver_image']) && $_FILES['driver_image']['error'] === UPLOAD_ERR_OK) {
    $original_name = basename($_FILES['driver_image']['name']);
    $ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));

    $allowed_extensions = ['jpg', 'jpeg', 'png'];
    if (!in_array($ext, $allowed_extensions)) {
        echo "Invalid file type. Only JPG, JPEG, and PNG are allowed.";
        exit;
    }

    $new_filename = 'driver_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
    $target_file = $upload_dir . $new_filename;

    if (move_uploaded_file($_FILES['driver_image']['tmp_name'], $target_file)) {
        $image_path = $new_filename; 
    } else {
        echo "Failed to upload image.";
        exit;
    }
}

$query = "UPDATE drivers SET driver_name = ?, driver_id = ?, password = ?";
if ($image_path) {
    $query .= ", image_path = ?";
}
$query .= " WHERE id = ?";

$stmt = $conn->prepare($query);

if ($image_path) {
    $stmt->bind_param("ssssi", $driver_name, $driver_custom_id, $hashed_password, $image_path, $driver_id);
} else {
    $stmt->bind_param("sssi", $driver_name, $driver_custom_id, $hashed_password, $driver_id);
}

if ($stmt->execute()) {
    header("Location: ../view/setting.php?status=success"); 
    exit;
} else {
    header("Location: ../view/setting.php?status=error");
    exit;
}

$stmt->close();
$conn->close();
?>
