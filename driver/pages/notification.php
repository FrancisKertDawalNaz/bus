<?php
include_once('../template/header.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once('../../connection.php');

$driver_name = 'Guest';

if (isset($_SESSION['driver_id'])) {
    $driver_id = $_SESSION['driver_id'];

    $query = "SELECT driver_name FROM drivers WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $driver_id);
    $stmt->execute();
    $stmt->bind_result($name);

    if ($stmt->fetch()) {
        $driver_name = $name;
    }
    $stmt->close();
}

$bookings = [];
$booking_query = "SELECT origin, destination, bus_title, bus_no, seat_no FROM booking_tb ORDER BY id DESC";
$booking_result = $conn->query($booking_query);

if ($booking_result && $booking_result->num_rows > 0) {
    while ($row = $booking_result->fetch_assoc()) {
        $bookings[] = $row;
    }
}

$alerts = [];
$alert_query = "SELECT alert_message, created_at FROM alert_tb WHERE status = 'unread' ORDER BY created_at DESC";
$alert_result = $conn->query($alert_query);

if ($alert_result && $alert_result->num_rows > 0) {
    while ($row = $alert_result->fetch_assoc()) {
        $alerts[] = $row;
    }
}

$query = "SELECT username FROM user_tb";
$result = $conn->query($query);
$passenger_name = "";
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $passenger_name = $row['username'];
}

if (!isset($_SESSION['driver_id'])) {
    die("Unauthorized access.");
}

$driver_id = $_SESSION['driver_id'];
$image_path = '../uploads/default_driver.png';

$query = "SELECT image_path FROM drivers WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $driver_id);
$stmt->execute();
$stmt->bind_result($image_path);

if ($stmt->fetch()) {
    if (!empty($image_path) && file_exists('../uploads/' . $image_path)) {
        $image_path = '../uploads/' . $image_path;
    } else {
        $image_path = '../uploads/default_driver.png';
    }
}

$stmt->close();
?>

<main style="height: 100vh; overflow: hidden;">
    <div class="d-flex" style="height: 100%;">
        <nav class="text-white p-3" style="width: 250px; background-color: #001f5b; position: fixed; top: 0; left: 0; height: 100vh; overflow-y: auto;">
            <div class="text-center mb-4">
                <img src="../assets/images/logo.png" alt="Logo" class="img-fluid" style="max-width: 150px;">
            </div>
            <ul class="list-unstyled">
                <li><a href="./main.php" class="sidebar-link text-white d-flex align-items-center py-2"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a></li>
                <li><a href="./notification.php" class="sidebar-link text-white d-flex align-items-center py-2"><i class="fas fa-bell me-2"></i> Notifications</a></li>
                <li><a href="./account.php" class="sidebar-link text-white d-flex align-items-center py-2"><i class="fas fa-user me-2"></i> Account</a></li>
                <li><a href="./reviews.php" class="sidebar-link text-white d-flex align-items-center py-2"><i class="fas fa-star me-2"></i> Reviews</a></li>
                <li><a href="./tracking.php" class="sidebar-link text-white d-flex align-items-center py-2"><i class="fas fa-location-arrow me-2"></i> GPS Tracking</a></li>
                <li><a href="./reports.php" class="sidebar-link text-white d-flex align-items-center py-2"><i class="fas fa-file-alt me-2"></i> Reports</a></li>
            </ul>
            <ul class="list-unstyled mt-auto">
                <li><a href="#" class="text-white d-flex align-items-center py-2"><i class="fas fa-life-ring me-2"></i> Help</a></li>
                <li><a href="./index.php" class="text-white d-flex align-items-center py-2"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
            </ul>
        </nav>

        <div class="flex-fill p-4" style="margin-left: 250px; height: 100vh; overflow-y: auto; background-color: #f0f8ff;">
            <div class="d-flex justify-content-between align-items-center p-3 mb-4" style="background-color: #7dd87d; border-radius: 10px;">
                <div class="text-white">
                    <h5>Welcome <?php echo htmlspecialchars($driver_name); ?></h5>
                    <small>Here are your latest notifications</small>
                </div>
                <div class="d-flex align-items-center">
                    <button type="button" class="btn btn-link text-white me-3" data-bs-toggle="modal" data-bs-target="#emergencyAlertModal" style="text-decoration: none;">
                        <i class="fas fa-bell fa-lg"></i>
                    </button>
                    <img src="<?php echo $image_path; ?>" alt="Profile" class="rounded-circle" style="width: 40px; height: 40px;">
                </div>
            </div>

            <div class="modal fade" id="emergencyAlertModal" tabindex="-1" aria-labelledby="emergencyAlertModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="emergencyAlertModalLabel">
                                <i class="fas fa-exclamation-triangle me-2"></i>Emergency Alert
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <?php
                            $latest_alert_query = "SELECT alert_message, created_at FROM alert_tb WHERE status = 'unread' ORDER BY created_at DESC LIMIT 1";
                            $latest_alert_result = $conn->query($latest_alert_query);

                            if ($latest_alert_result && $latest_alert_result->num_rows > 0):
                                $latest_alert = $latest_alert_result->fetch_assoc();
                            ?>
                                <div class="alert alert-danger d-flex align-items-center mb-3" role="alert">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    <div>
                                        <?php echo htmlspecialchars($latest_alert['alert_message']); ?>
                                        <br><small>Passenger: <?php echo htmlspecialchars($passenger_name); ?></small>
                                        <br><small>Sent at: <?php echo htmlspecialchars($latest_alert['created_at']); ?></small>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-secondary" role="alert">
                                    No unread alerts.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card p-4">
                <h4 class="mb-4">Booking Notifications</h4>

                <?php if (!empty($bookings)): ?>
                    <?php $count = 0; ?>
                    <?php foreach ($bookings as $booking): ?>
                        <?php
                            $count++;
                            $hiddenClass = ($count > 5) ? 'd-none extra-booking' : '';
                        ?>
                        <div class="alert alert-info d-flex justify-content-between align-items-center mb-3 booking-item <?php echo $hiddenClass; ?>" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-ticket-alt me-2"></i>
                                <div>
                                    New passenger has booked:
                                    <strong><?php echo htmlspecialchars($booking['origin']); ?></strong>
                                    to
                                    <strong><?php echo htmlspecialchars($booking['destination']); ?></strong> —
                                    Bus <strong><?php echo htmlspecialchars($booking['bus_no']); ?></strong>
                                    (<?php echo htmlspecialchars($booking['bus_title']); ?>),
                                    Seat <strong><?php echo htmlspecialchars($booking['seat_no']); ?></strong>.
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <?php if ($count > 5): ?>
                        <div class="text-center mt-3">
                            <button id="seeMoreBtn" class="btn btn-outline-primary">See More</button>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="alert alert-secondary" role="alert">
                        No new bookings yet.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const seeMoreBtn = document.getElementById('seeMoreBtn');
        if (seeMoreBtn) {
            seeMoreBtn.addEventListener('click', function () {
                document.querySelectorAll('.extra-booking').forEach(function (item) {
                    item.classList.remove('d-none');
                });
                this.style.display = 'none';
            });
        }
    });
</script>
