<?php
include_once('../../connection.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $original_booking_date = $_POST['original_booking_date'];
    $booking_date = $_POST['booking_date'];
    $bus_no = $_POST['bus_no'];
    $bus_price = $_POST['bus_price'];
    $seat_no = $_POST['seat_no'];
    $name = $_POST['name'];

    $stmt = $conn->prepare("UPDATE booking_tb SET booking_date = ?, bus_no = ?, bus_price = ?, seat_no = ?, name = ? WHERE booking_date = ?");
    $stmt->bind_param("ssssss", $booking_date, $bus_no, $bus_price, $seat_no, $name, $original_booking_date);

    if ($stmt->execute()) {
        header("Location: ../view/main.php?update=success");
    } else {
        header("Location: ../view/main.php?update=fail");
    }

    $stmt->close();
    $conn->close();
}
?>
