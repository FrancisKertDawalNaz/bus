<?php include '../template/header.php'; 
include_once('../../connection.php');

// Fetch drivers from the database
$drivers = [];
$query = "SELECT driver_id, driver_name FROM drivers";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $drivers[] = $row;
}
$stmt->close();
?>

<main style="height: 100vh; overflow: hidden;">
    <div class="d-flex" style="height: 100%;"> 

        <!-- Sidebar -->
        <nav class="text-white p-3" style="width: 250px; background-color: #001f5b; position: fixed; top: 0; left: 0; height: 100vh; overflow-y: auto;">
            <div class="text-center mb-4">
                <img src="../../asset/images/logo.png" alt="Logo" class="img-fluid" style="max-width: 150px;">
            </div>
            <ul class="list-unstyled">
                <li><a href="./main.php" class="sidebar-link text-white d-flex align-items-center py-2"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a></li>
                <li><a href="./statistic.php" class="sidebar-link text-white d-flex align-items-center py-2"><i class="fas fa-chart-line me-2"></i> Statistics</a></li>
                <li><a href="./feedback.php" class="sidebar-link text-white d-flex align-items-center py-2"><i class="fas fa-comments me-2"></i> Feedback</a></li>
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
        <div class="flex-fill p-4" style="margin-left: 250px; height: 100vh; overflow-y: auto; background-color: #f0f8ff; display: flex; flex-direction: column;">

            <!-- Income & Spending Section -->
            <div class="d-flex justify-content-between align-items-center p-3 mb-4" style="background-color: #7dd87d; border-radius: 10px;">
                <div class="text-white">
                    <h5>Income & Spending Overview</h5>
                    <small>Track your financials here.</small>
                </div>
                <div class="d-flex align-items-center">
                    <div class="input-group me-3" style="width: 200px;">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Search...">
                    </div>
                    <img src="../../asset/images/adminpic.jpg" alt="Profile" class="rounded-circle" style="width: 40px; height: 40px;">
                </div>
            </div>

            <!-- Debit/Unpaid Subscription (on the right) -->
            <div class="d-flex justify-content-between align-items-center p-3 mb-4" style="background-color: #ffcc00; border-radius: 10px;">
                <div class="text-dark">
                    <h5>Debit/Unpaid Subscription</h5>
                    <small>Manage your subscriptions here.</small>
                    <!-- Display amount at the bottom -->
                    <p><strong>Amount Due: 50,000</strong></p>
                </div>
            </div>

            <!-- Bus Companies Section (at the bottom) -->
            <div class="d-flex justify-content-between align-items-center p-3" style="background-color: #f0f8ff; border-top: 2px solid #07416b;">
                <div class="text-dark">
                    <h5>Bus Companies</h5>
                    <ul>
                        <li>DLTB</li>
                        <li>LLI</li>
                        <li>SINCRODA</li>
                        <li>HM</li>
                    </ul>
                    <!-- View Drivers Action Button -->
                    <a href="#" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#driversModal">View Drivers</a>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal for Viewing Drivers -->
<div class="modal fade" id="driversModal" tabindex="-1" aria-labelledby="driversModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="driversModalLabel">View Drivers</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ul class="list-group">
          <?php foreach ($drivers as $driver): ?>
            <li class="list-group-item">
                <strong>Driver Name:</strong> <?php echo $driver['driver_name']; ?> 
                <br><strong>Driver ID:</strong> <?php echo $driver['driver_id']; ?>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap 5 JS and CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
