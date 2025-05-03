<?php
include_once('../../connection.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_id = $_POST["admin_id"];  
    $password = $_POST["password"];  

    $stmt = $conn->prepare("SELECT admin_id, username, password FROM admins WHERE admin_id = ?");
    $stmt->bind_param("s", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
       
        if ($password === $row['password']) {

            $_SESSION['admin_id'] = $row['admin_id'];
            $_SESSION['admin_name'] = $row['username'];

            header("Location: ../view/main.php?login=success");
            exit();
        } else {

            echo "<script>alert('Incorrect password. Please try again.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Admin ID not found. Please check your ID or register first.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
