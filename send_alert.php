<?php
include_once('./connection.php');
session_start();

echo "Session ID: " . $_SESSION['id'] . "<br>";

$user_id = $_SESSION['id']; 

$query_user = "SELECT username FROM user_tb WHERE id = ?";
$stmt_user = $conn->prepare($query_user);
$stmt_user->bind_param('i', $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();

if ($result_user->num_rows > 0) {
    $user = $result_user->fetch_assoc();
    echo "User Found: " . $user['username'] . "<br>"; 
    $username = $user['username'];
} else {

    echo "No user found with ID: " . $user_id . "<br>"; 
}

$alert_message = "Emergency alert sent by passenger";

$query = "INSERT INTO alert_tb (user_id, alert_message, status, created_at) VALUES (?, ?, 'unread', NOW())";
$stmt = $conn->prepare($query);
$stmt->bind_param('is', $user_id, $alert_message);

if ($stmt->execute()) {
    header('Location: main.php?alert=sent');
    exit();
} else {
    echo "Error sending alert.";
}
?>
