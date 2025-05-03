<?php
session_start();
include_once('../../connection.php');

// Ensure driver is logged in
if (!isset($_SESSION['driver_id'])) {
    die("Unauthorized access.");
}

$driver_id = $_SESSION['driver_id'];

// Sanitize form inputs
$driver_name = trim($_POST['driver_name']);
$driver_custom_id = trim($_POST['driver_id']);
$password = trim($_POST['password']);

// Hash the password for security
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Handle image upload
$image_path = null;
$upload_dir = '../../driver/uploads/';
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);  // Create folder if it doesn't exist
}

if (isset($_FILES['driver_image']) && $_FILES['driver_image']['error'] === UPLOAD_ERR_OK) {
    $original_name = basename($_FILES['driver_image']['name']);
    $ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));

    // Validate file type
    $allowed_extensions = ['jpg', 'jpeg', 'png'];
    if (!in_array($ext, $allowed_extensions)) {
        echo "Invalid file type. Only JPG, JPEG, and PNG are allowed.";
        exit;
    }

    $new_filename = 'driver_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
    $target_file = $upload_dir . $new_filename;

    // Move the file
    if (move_uploaded_file($_FILES['driver_image']['tmp_name'], $target_file)) {
        $image_path = $new_filename; // Store filename only, not full path
    } else {
        echo "Failed to upload image.";
        exit;
    }
}

// Update query
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

// Execute and redirect
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
