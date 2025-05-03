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
$upload_dir = '../uploads/';
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);  // Create folder if it doesn't exist
}

if (isset($_FILES['driver_image']) && $_FILES['driver_image']['error'] === UPLOAD_ERR_OK) {
    // Error checking
    if ($_FILES['driver_image']['error'] !== UPLOAD_ERR_OK) {
        echo "Upload failed with error code: " . $_FILES['driver_image']['error'];
        exit;
    }

    // Sanitize file name and check file type
    $original_name = basename($_FILES['driver_image']['name']);
    $ext = pathinfo($original_name, PATHINFO_EXTENSION);

    // Validate the file type (Optional)
    $allowed_extensions = ['jpg', 'jpeg', 'png'];
    if (!in_array($ext, $allowed_extensions)) {
        echo "Invalid file type. Only JPG, JPEG, and PNG are allowed.";
        exit;
    }

    $new_filename = 'driver_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
    $target_file = $upload_dir . $new_filename;

    // Move the file to the target folder
    if (move_uploaded_file($_FILES['driver_image']['tmp_name'], $target_file)) {
        $image_path = $target_file;
    } else {
        echo "Failed to upload image.";
        exit;
    }
}

// Update query with image path if available
$query = "UPDATE drivers SET driver_name = ?, driver_id = ?, password = ?" . ($image_path ? ", image_path = ?" : "") . " WHERE id = ?";
$stmt = $conn->prepare($query);

if ($image_path) {
    $stmt->bind_param("ssssi", $driver_name, $driver_custom_id, $hashed_password, $image_path, $driver_id);
} else {
    $stmt->bind_param("sssi", $driver_name, $driver_custom_id, $hashed_password, $driver_id);
}

if ($stmt->execute()) {
    // Redirect to account page with success message
    header("Location: ../pages/account.php?status=success");
    exit;
} else {
    // Redirect with error message
    header("Location: ../pages/account.php?status=error");
    exit;
}

$stmt->close();
$conn->close();
?>
