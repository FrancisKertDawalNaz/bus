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
                    <small>Manage your account details below</small>
                </div>
                <div class="d-flex align-items-center">
                    <div class="input-group me-3" style="width: 200px;">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Search here...">
                    </div>
                    <!-- Profile Image -->
                    <img src="<?php echo $image_path; ?>" alt="Profile" class="rounded-circle" style="width: 40px; height: 40px;">
                </div>
            </div>

            <!-- Driver Profile Form -->
            <div class="card p-4">
                <h4 class="mb-4">Edit Driver Profile</h4>
                <form action="../function/update_driver.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-4 text-center">
                        <img src="../assets/images/user.png" alt="Driver Image" class="rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover;">
                        <div>
                            <input type="file" name="driver_image" class="form-control" style="max-width: 300px; margin: 0 auto;">
                        </div>
                    </div>

                    <!-- Driver Name -->
                    <div class="mb-3">
                        <label for="driver_name" class="form-label">Driver Name</label>
                        <input type="text" name="driver_name" id="driver_name" class="form-control" placeholder="Enter driver name" required>
                    </div>

                    <!-- Driver ID -->
                    <div class="mb-3">
                        <label for="driver_id" class="form-label">Driver ID</label>
                        <input type="text" name="driver_id" id="driver_id" class="form-control" placeholder="Enter driver ID" required>
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </div>
                </form>
            </div>

        </div>

    </div>
</main>

<?php
if (isset($_GET['status']) && $_GET['status'] == 'success') {
    echo "<script>
        Swal.fire({
            title: 'Success!',
            text: 'Your changes have been saved.',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>";
} elseif (isset($_GET['status']) && $_GET['status'] == 'error') {
    echo "<script>
        Swal.fire({
            title: 'Error!',
            text: 'There was an issue saving your changes.',
            icon: 'error',
            confirmButtonText: 'Try Again'
        });
    </script>";
}
?>
