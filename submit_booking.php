<?php
include('connection.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $origin = $_POST['origin'];
    $destination = $_POST['destination'];
    $busTitle = $_POST['bus_title'];
    $busNo = $_POST['bus_no'];
    $busPrice = $_POST['bus_price'];
    $seatNo = $_POST['seat_no'];

    $stmt = $conn->prepare("INSERT INTO booking_tb (name, email, phone, origin, destination, bus_title, bus_no, bus_price, seat_no) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssis", $name, $email, $phone, $origin, $destination, $busTitle, $busNo, $busPrice, $seatNo);
    
    if ($stmt->execute()) {
        $_SESSION['booking_notification'] = "Your ticket has been successfully booked!";
        header("Location: main.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
