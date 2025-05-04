<?php
session_start();
include_once('../../connection.php');

if (!isset($_SESSION['admin_id'])) {
    die("Unauthorized access.");
}

include_once('../../connection.php');

if (isset($_GET['booking_date']) && isset($_GET['bus_no'])) {
    $booking_date = $_GET['booking_date'];
    $bus_no = $_GET['bus_no'];

    // Prepare the DELETE SQL query
    $delete_query = "DELETE FROM booking_tb WHERE booking_date = ? AND bus_no = ?";

    if ($stmt = $conn->prepare($delete_query)) {
        $stmt->bind_param("ss", $booking_date, $bus_no); // Bind parameters
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Redirect with success message
            header("Location: ../view/main.php?delete=success");
        } else {
            // Redirect with error message
            header("Location: ../view/main.php?delete=fail");
        }

        $stmt->close();
    } else {
        // Redirect if query fails
        header("Location: ../view/main.php?delete=error");
    }

    $conn->close();
}
?>
