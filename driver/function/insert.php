<?php
include '../../connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $driver_name = $_POST["driver_name"];
    $driver_id   = $_POST["driver_id"];
    $password    = password_hash($_POST["password"], PASSWORD_DEFAULT); 

    $sql = "INSERT INTO drivers (driver_name, driver_id, password) VALUES ('$driver_name', '$driver_id', '$password')";

    if ($conn->query($sql)) {
        header("Location: ../pages/index.php?signup=success");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }


    $conn->close();
}
?>
