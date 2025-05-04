<?php include '../template/header.php';
?>

<?php
include_once('../../connection.php');

$tripQuery = "SELECT COUNT(*) AS total_trips FROM booking_tb";
$tripResult = $conn->query($tripQuery);
$tripCount = $tripResult->fetch_assoc()['total_trips'] ?? 0;

$earningQuery = "SELECT SUM(bus_price) AS total_earnings FROM booking_tb";
$earningResult = $conn->query($earningQuery);
$totalEarnings = $earningResult->fetch_assoc()['total_earnings'] ?? 0;

$availableBus = 4;
?>

<?php

$monthlyData = [];
$bookingChartQuery = "
    SELECT MONTH(booking_date) AS month, COUNT(*) AS total
    FROM booking_tb
    GROUP BY MONTH(booking_date)
    ORDER BY month
";
$bookingChartResult = $conn->query($bookingChartQuery);
while ($row = $bookingChartResult->fetch_assoc()) {
    $monthlyData[(int)$row['month']] = $row['total'];
}


$bookingsPerMonth = [];
for ($i = 1; $i <= 12; $i++) {
    $bookingsPerMonth[] = $monthlyData[$i] ?? 0;
}
?>

<?php
include_once('../../connection.php');


$userQuery = "SELECT COUNT(*) AS total_users FROM user_tb";
$userResult = $conn->query($userQuery);
$userData = $userResult->fetch_assoc();

$totalUsers = $userData['total_users'] ?? 0;
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
                <li>
                    <a href="../pages/index.php" onclick="confirmLogout()" class="text-white d-flex align-items-center py-2">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </li>
            </ul>



        </nav>

        <!-- Main content -->
        <div class="flex-fill p-4" style="margin-left: 250px; height: 100vh; overflow-y: auto; background-color: #f0f8ff;">
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
                    <img src="../../asset/images/adminpic.jpg" alt="Profile" class="rounded-circle" style="width: 40px; height: 40px;">
                </div>
            </div>
          
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <div class="card text-white bg-primary shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title">Book Trip</h6>
                            <h4 class="card-text"><?= $tripCount ?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card text-white bg-success shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title">Available Bus</h6>
                            <h4 class="card-text"><?= $availableBus ?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card text-white bg-warning shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title">Total Earnings</h6>
                            <h4 class="card-text">$<?= number_format($totalEarnings, 2) ?></h4>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
               
                <div class="col-md-8 mb-4">
                    <div class="card p-3">
                        <h5 class="mb-3">Monthly Bookings (Line Chart)</h5>
                        <canvas id="bookingLineChart" height="120"></canvas>
                    </div>
                </div>

          
                <div class="col-md-4 mb-4">
                    <div class="card p-3">
                        <h5 class="mb-3">Active Users</h5>
                        <canvas id="bookingDoughnutChart" height="120"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const lineCtx = document.getElementById('bookingLineChart').getContext('2d');
    const bookingLineChart = new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Bookings',
                data: <?= json_encode($bookingsPerMonth) ?>,
                backgroundColor: 'rgba(125, 216, 125, 0.2)',
                borderColor: '#7dd87d',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const doughnutCtx = document.getElementById('bookingDoughnutChart').getContext('2d');
    const bookingDoughnutChart = new Chart(doughnutCtx, {
        type: 'doughnut',
        data: {
            labels: ['Active Users'],
            datasets: [{
                label: 'Users',
                data: [<?= $totalUsers ?>],
                backgroundColor: ['#4caf50'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>