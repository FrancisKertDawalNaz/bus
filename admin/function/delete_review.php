<?php
include_once('../../connection.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM reviews WHERE id = ?");
    $stmt->bind_param("i", $id);
    echo $stmt->execute() ? 'success' : 'error';
    $stmt->close();
}
?>
