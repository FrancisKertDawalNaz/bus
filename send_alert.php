<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access.");
}

include_once('./connection.php');

$user_id = $_SESSION['user_id'];

// Fetch the username (optional, for logging or personalization)
$query_user = "SELECT username FROM user_tb WHERE id = ?";
$stmt_user = $conn->prepare($query_user);
$stmt_user->bind_param('i', $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();

if ($result_user->num_rows > 0) {
    $user = $result_user->fetch_assoc();
    $username = $user['username'];
} else {
    die("User not found.");
}

// Define allowed emergency types based on modal options
$allowed_types = ['fire', 'accident', 'mechanical_issue', 'medical', 'other'];

// Validate emergency type from POST
$emergency_type = isset($_POST['emergency_type']) && in_array($_POST['emergency_type'], $allowed_types)
    ? $_POST['emergency_type']
    : 'other';

// Format message
$readable_type = ucfirst(str_replace('_', ' ', $emergency_type));
$alert_message = "Emergency alert sent by passenger. Emergency Type: " . $readable_type;

// Insert alert into the database
$query = "INSERT INTO alert_tb (user_id, emergency_type, alert_message, status, created_at)
          VALUES (?, ?, ?, 'unread', NOW())";
$stmt = $conn->prepare($query);
$stmt->bind_param('iss', $user_id, $emergency_type, $alert_message);

if ($stmt->execute()) {
    header('Location: main.php?alert=sent');
    exit();
} else {
    echo "Error sending alert: " . $stmt->error;
}
?>
