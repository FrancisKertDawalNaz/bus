<?php 
include '../template/header.php'; 
include_once('../../connection.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {
    die("Unauthorized access.");
}

// Fetch booking data
$booking_query = "SELECT booking_date, bus_no, bus_price, seat_no, booking_id FROM booking_tb ORDER BY booking_date DESC";
$booking_result = $conn->query($booking_query);
?>

<main style="height: 100vh; overflow: hidden;">
    <div class="d-flex" style="height: 100%;">


        <!-- Sidebar -->
        <nav class="text-white p-3" style="width: 250px; background-color: #07416b; position: fixed; top: 0; left: 0; height: 100vh; overflow-y: auto;">
            <div class="text-center mb-4">
                <img src="../../asset/images/logo.png" alt="Logo" class="img-fluid" style="max-width: 150px;">
            </div>
            <ul class="list-unstyled">
                <li><a href="./main.php" class="sidebar-link text-white d-flex align-items-center py-2"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a></li>
                <li><a href="./statistic.php" class="sidebar-link text-white d-flex align-items-center py-2"><i class="fas fa-chart-line me-2"></i> Statistics</a></li>
                <li><a href="./feedback.php" class="sidebar-link text-white d-flex align-items-center py-2"><i class="fas fa-comments me-2"></i> Feedback</a></li>
                <li><a href="./message.php" class="sidebar-link text-white d-flex align-items-center py-2"><i class="fas fa-envelope me-2"></i> Messages</a></li>
                <li><a href="./setting.php" class="sidebar-link text-white d-flex align-items-center py-2"><i class="fas fa-cogs me-2"></i> Settings</a></li>
                <li><a href="./bus_driver.php" class="sidebar-link text-white d-flex align-items-center py-2"><i class="fas fa-bus me-2"></i> Bus Driver</a></li>
                <li><a href="./network.php" class="sidebar-link text-white d-flex align-items-center py-2"><i class="fas fa-network-wired me-2"></i> Our Network</a></li>
                <li><a href="./report.php" class="sidebar-link text-white d-flex align-items-center py-2"><i class="fas fa-file-alt me-2"></i> Report Management</a></li>
            </ul>


            <ul class="list-unstyled mt-auto">
                <li><a href="../pages/index.php" class="text-white d-flex align-items-center py-2"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
            </ul>
        </nav>

        <!-- Main content -->
        <div class="flex-fill p-4" style="margin-left: 250px; height: 100vh; overflow-y: auto; background-color: #f0f8ff;">
            <?php if (isset($_GET['login']) && $_GET['login'] === 'success'): ?>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Login Successful',
                        text: 'Welcome, Admin!',
                        confirmButtonText: 'OK'
                    });
                </script>
            <?php endif; ?>

            <?php if (isset($_GET['login']) && $_GET['login'] === 'fail'): ?>
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Failed',
                        text: 'Incorrect ID or Password!',
                        confirmButtonText: 'Try Again'
                    });
                </script>
            <?php endif; ?>

            <!-- Dashboard Content -->
            <div class="d-flex justify-content-between align-items-center p-3 mb-4" style="background-color: #7dd87d; border-radius: 10px;">
                <div class="text-white">
                    <h5>Welcome Admin</h5>
                    <small>Let's take a detailed look at your dashboard.</small>
                </div>
                <div class="d-flex align-items-center">
                    <div class="input-group me-3" style="width: 200px;">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Search here...">
                    </div>
                    <img src="../../driver/assets/images/user.png" alt="Profile" class="rounded-circle" style="width: 40px; height: 40px;">
                </div>
            </div>

            <!-- Booking Table -->
            <div class="card p-3">
                <h5 class="mb-3">Bus Bookings</h5>
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead class="table-success">
                            <tr>
                                <th>Booking Date</th>
                                <th>Bus No</th>
                                <th>Bus Price</th>
                                <th>Seat No</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($booking_result->num_rows > 0):
                                while ($row = $booking_result->fetch_assoc()):
                            ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['booking_date']); ?></td>
                                    <td><?php echo htmlspecialchars($row['bus_no']); ?></td>
                                    <td><?php echo htmlspecialchars($row['bus_price']); ?></td>
                                    <td><?php echo htmlspecialchars($row['seat_no']); ?></td>
                                    <td>
                                        <a href="edit_booking.php?id=<?php echo $row['booking_id']; ?>" class="btn btn-sm btn-primary me-1">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="delete_booking.php?id=<?php echo $row['booking_id']; ?>" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php
                                endwhile;
                            else:
                                echo "<tr><td colspan='5' class='text-center text-muted'>No bookings available</td></tr>";
                            endif;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</main>
