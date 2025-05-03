<?php
include '../connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email    = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // secure hash

    $sql = "INSERT INTO user_tb (username, email, password) VALUES ('$username', '$email', '$password')";

    if ($conn->query($sql)) {
        header("Location: ../index.php?signup=success");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
