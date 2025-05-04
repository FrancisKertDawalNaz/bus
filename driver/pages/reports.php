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


$query = "SELECT alert_tb.*, user_tb.username 
          FROM alert_tb 
          INNER JOIN user_tb ON alert_tb.user_id = user_tb.id 
          ORDER BY alert_tb.created_at DESC 
          LIMIT 3";

$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$alerts = [];

while ($row = $result->fetch_assoc()) {
    $alerts[] = $row;
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
                <li><a href="./reports.php" class="sidebar-link text-white d-flex align-items-center py-2 active"><i class="fas fa-file-alt me-2"></i> Reports</a></li>
            </ul>
            <ul class="list-unstyled mt-auto">
                <li><a href="#" class="text-white d-flex align-items-center py-2"><i class="fas fa-life-ring me-2"></i> Help</a></li>
                <li><a href="./index.php" class="text-white d-flex align-items-center py-2"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="flex-fill p-4" style="margin-left: 250px; height: 100vh; overflow-y: auto; background-color: #f0f8ff;">
            <div class="d-flex justify-content-between align-items-center p-3 mb-4" style="background-color: #7dd87d; border-radius: 10px;">
                <div class="text-white">
                    <h5>Welcome <?php echo htmlspecialchars($driver_name); ?></h5>
                    <small>Reports</small>
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

            <!-- Reports Section -->
            <div class="card p-4">
                <h4 class="mb-4">User Reports</h4>

                <?php foreach ($alerts as $alert): ?>
                    <div class="mb-4 border-bottom pb-3">
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge <?php echo ($alert['emergency_type'] == 'fire') ? 'bg-danger' : ($alert['emergency_type'] == 'accident' ? 'bg-warning' : 'bg-info'); ?>">
                                <?php echo ucfirst($alert['emergency_type']); ?>
                            </span>
                        </div>
                        <p class="mb-1 fw-bold mb-0"><?php echo htmlspecialchars($alert['username']); ?></p>
                        <p class="mb-1"><strong>Alert Message:</strong> <?php echo htmlspecialchars($alert['alert_message']); ?></p>
                        <p class="mb-1"><strong>Emergency Type:</strong> <?php echo ucfirst(htmlspecialchars($alert['emergency_type'])); ?></p>
                        <p class="mb-0"><strong>Created At:</strong> <?php echo htmlspecialchars($alert['created_at']); ?></p>
                    </div>
                <?php endforeach; ?>


                <div class="text-center mt-4">
                    <button class="btn btn-outline-primary" id="showAllReports">Show All</button>
                </div>

               
                <div id="additionalReports" style="display: none;">
                    
                </div>

            </div>
        </div>
    </div>
</main>

<script>
    document.getElementById('showAllReports').addEventListener('click', function() {
        document.getElementById('additionalReports').style.display = 'block';
        this.style.display = 'none'; 
    });
</script>
