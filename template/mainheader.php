<?php

include('connection.php');

session_start();
$user_id = $_SESSION['user_id'];
$query = "SELECT username, email, password FROM user_tb WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $email, $password);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap');

        .profile-info {
            font-size: 0.85rem;
            font-weight: 400;
            font-family: 'Roboto', sans-serif;
        }

        .navbar-custom {
            background-color: #001f3d;
        }

        .blurred-image {
            filter: blur(3px);
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="asset/images/logo.png" alt="Logo" width="50" height="50" class="me-2">
            </a>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="./main.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./support.php">Support</a>
                    </li>
                </ul>
            </div>
            <div class="d-flex">
                <!-- Notification Button -->
                <button class="btn btn-link text-white" type="button" data-bs-toggle="modal" data-bs-target="#notificationModal">
                    <i class="bi bi-bell-fill"></i>
                </button>

                <!-- Profile Button -->
                <a href="#" class="btn btn-link text-white" data-bs-toggle="modal" data-bs-target="#profileModal">
                    <i class="bi bi-person-circle"></i>
                </a>
            </div>
        </div>
    </nav>

    <!-- Notification Modal -->
    <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notificationModalLabel">Notifications</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if (isset($_SESSION['booking_notification'])): ?>
                        <p><i class="bi bi-info-circle-fill text-primary me-2"></i> <?= $_SESSION['booking_notification'] ?></p>


                        <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#bookingSummaryModal" data-bs-dismiss="modal">
                            View Booking Summary
                        </button>

                        <?php unset($_SESSION['booking_notification']); ?>
                    <?php else: ?>
                        <p>No new notifications.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>


    <!-- Profile Modal -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Username:</strong> <span class="profile-info"><?php echo htmlspecialchars($username); ?></span></p>
                    <p><strong>Email:</strong> <span class="profile-info"><?php echo htmlspecialchars($email); ?></span></p>
                    <p><strong>Password:</strong> <span class="profile-info"><?php echo htmlspecialchars($password); ?></span></p>

                    <!-- Reset Password Button -->
                    <button class="btn btn-danger my-2" data-bs-toggle="modal" data-bs-target="#resetPasswordModal">Reset Password</button>

                    <!-- Logout Button -->
                    <a href="#" class="btn btn-secondary w-100" id="logoutButton">
                        Logout
                    </a>

                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById('logoutButton').addEventListener('click', function(e) {
            e.preventDefault(); 

            Swal.fire({
                icon: 'warning',
                title: 'Are you sure you want to logout?',
                showCancelButton: true,
                confirmButtonText: 'Yes, logout',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'function/logout.php'; 
                }
            });
        });
    </script>



    <!-- Reset Password Modal -->
    <div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resetPasswordModalLabel">Reset Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="reset_password.php" method="POST">
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                        </div>
                        <button type="submit" class="btn btn-success">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Summary Modal -->
    <div class="modal fade" id="bookingSummaryModal" tabindex="-1" aria-labelledby="bookingSummaryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingSummaryModalLabel">Booking Summary</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    include('connection.php');
                    // You can use email or session to get the latest booking, here assuming latest booking
                    $result = $conn->query("SELECT * FROM booking_tb ORDER BY id DESC LIMIT 1");

                    if ($result && $result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                    ?>
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Name:</strong> <?= $row['name'] ?></li>
                            <li class="list-group-item"><strong>Email:</strong> <?= $row['email'] ?></li>
                            <li class="list-group-item"><strong>Phone:</strong> <?= $row['phone'] ?></li>
                            <li class="list-group-item"><strong>Origin:</strong> <?= $row['origin'] ?></li>
                            <li class="list-group-item"><strong>Destination:</strong> <?= $row['destination'] ?></li>
                            <li class="list-group-item"><strong>Bus Title:</strong> <?= $row['bus_title'] ?></li>
                            <li class="list-group-item"><strong>Bus No:</strong> <?= $row['bus_no'] ?></li>
                            <li class="list-group-item"><strong>Bus Price:</strong> <?= $row['bus_price'] ?></li>
                            <li class="list-group-item"><strong>Seat No:</strong> <?= $row['seat_no'] ?></li>
                        </ul>
                    <?php
                    } else {
                        echo "<p>No booking data found.</p>";
                    }

                    $conn->close();
                    ?>
                </div>
            </div>
        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>