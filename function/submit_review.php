<?php
session_start();
include_once('../connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $review_name = mysqli_real_escape_string($conn, $_POST['review_name']);
    $review_message = mysqli_real_escape_string($conn, $_POST['review_message']);
    $rating = (int) $_POST['rating'];
    $driver_id = isset($_SESSION['driver_id']) ? $_SESSION['driver_id'] : 1;

    if ($rating < 1 || $rating > 5) {
        $_SESSION['review_status'] = 'invalid';
        header("Location: ../main.php");
        exit;
    }

    $query = "INSERT INTO reviews (driver_id, review_name, review_message, rating) 
              VALUES ('$driver_id', '$review_name', '$review_message', '$rating')";

    if (mysqli_query($conn, $query)) {
        $_SESSION['review_status'] = 'success';
    } else {
        $_SESSION['review_status'] = 'error';
    }

    mysqli_close($conn);
    header("Location: ../main.php");
    exit;
} else {
    header("Location: ../main.php");
    exit;
}
