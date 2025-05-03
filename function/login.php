<?php
session_start();
include '../connection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user_tb WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['login_success'] = true; 
                header("Location: ../main.php"); // ✅ SUCCESS → main.php
                exit;
            } else {
                $_SESSION['login_failed'] = true; 
                header("Location: ../index.php"); // ❌ ERROR → index.php
                exit;
            }
        } else {
            $_SESSION['login_failed'] = true; 
            header("Location: ../index.php"); // ❌ ERROR → index.php
            exit;
        }
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
