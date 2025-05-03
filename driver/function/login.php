<?php
include_once('../../connection.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $driver_id = $_POST["driver_id"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, driver_name, password FROM drivers WHERE driver_id = ?");
    $stmt->bind_param("s", $driver_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        if (password_verify($password, $row['password'])) {
            $_SESSION['driver_id'] = $row['id'];
            $_SESSION['driver_name'] = $row['driver_name'];

            header("Location: ../pages/main.php?login=success");
            exit();
        } else {
            echo "<script>alert('Incorrect password. Please try again.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Driver ID not found. Please check your ID or register first.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
