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

$query = "SELECT name, phone, origin, destination, bus_title, bus_no, bus_price, seat_no, booking_date FROM booking_tb";
$result = $conn->query($query);

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
        <!-- Sidebar -->
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
                <li><a href="./reports.php" class="sidebar-link text-white d-flex align-items-center py-2"><i class="fas fa-file-alt me-2"></i> Reports</a></li> <!-- New: Reports -->
            </ul>

            <ul class="list-unstyled mt-auto">
                <li><a href="#" class="text-white d-flex align-items-center py-2"><i class="fas fa-life-ring me-2"></i> Help</a></li>
                <li><a href="./index.php" class="text-white d-flex align-items-center py-2"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
            </ul>
        </nav>

        <!-- Main content -->
        <div class="flex-fill p-4" style="margin-left: 250px; height: 100vh; overflow-y: auto; background-color: #f0f8ff;">
            <div class="d-flex justify-content-between align-items-center p-3 mb-4" style="background-color: #7dd87d; border-radius: 10px;">
                <div class="text-white">
                    <h5>Welcome <?php echo htmlspecialchars($driver_name); ?></h5>
                    <small>Let's take a detailed look at your financial situation today</small>
                </div>
                <div class="d-flex align-items-center">
                    <div class="input-group me-3" style="width: 200px;">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Search here...">
                    </div>
                    <img src="<?php echo $image_path; ?>" alt="Profile" class="rounded-circle" style="width: 40px; height: 40px;">
                </div>
            </div>

            <!-- Passenger List -->
            <div class="bg-white p-4 rounded shadow-sm">
                <h4 class="mb-4">Passengers</h4>
                <table class="table table-hover">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Passenger</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Destination</th>
                            <th>Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $result->fetch_assoc()) {
                            $name = $row['name'];
                            $origin = $row['origin'];
                            $destination = $row['destination'];
                            $bus_title = $row['bus_title'];
                            $seat_no = $row['seat_no'];
                            $booking_date = $row['booking_date'];
                            $bus_price = $row['bus_price'];
                            $type = ($origin == 'Station') ? 'Station' : 'Pick-up';
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($name); ?><br><small>Row <?php echo htmlspecialchars($seat_no); ?></small></td>
                                <td><?php echo htmlspecialchars($booking_date); ?><br><small><?php echo time_ago($booking_date); ?></small></td>
                                <td>P<?php echo number_format($bus_price, 2); ?><br>Gcash</td>
                                <td><a href="#"><?php echo htmlspecialchars($destination); ?></a></td>
                                <td><?php echo htmlspecialchars($type); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>                     
                </table>

                <div class="text-center mt-3">
                    <a href="#" class="btn btn-outline-primary">Show All My Passengers</a>
                </div>
            </div>

            <!-- Main content -->
            <div class="flex-fill p-4" style="margin-left: 250px; height: 100vh; overflow-y: auto; background-color: #f0f8ff;">
                <?php if (isset($_GET['login']) && $_GET['login'] === 'success'): ?>
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Login Successful',
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
            </div>
        </div>
</main>

<?php
function time_ago($date)
{
    $timestamp = strtotime($date);
    $difference = time() - $timestamp;
    $periods = array("second", "minute", "hour", "day", "week", "month", "year");
    $lengths = array("60", "60", "24", "7", "4.35", "12", "10");

    for ($i = 0; $difference >= $lengths[$i]; $i++) {
        $difference /= $lengths[$i];
    }

    $difference = round($difference);

    return "$difference $periods[$i]" . ($difference > 1 ? "s" : "") . " ago";
}
?>