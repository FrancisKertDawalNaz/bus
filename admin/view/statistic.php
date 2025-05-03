<?php include '../template/header.php'; ?>

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
            <!-- Info Boxes -->
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <div class="card text-white bg-primary shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title">Book Trip</h6>
                            <h4 class="card-text">120</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card text-white bg-success shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title">Available Bus</h6>
                            <h4 class="card-text">25</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card text-white bg-warning shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title">Total Earnings</h6>
                            <h4 class="card-text">$18,450</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Line Graph -->
                <div class="col-md-8 mb-4">
                    <div class="card p-3">
                        <h5 class="mb-3">Monthly Bookings (Line Chart)</h5>
                        <canvas id="bookingLineChart" height="120"></canvas>
                    </div>
                </div>

                <!-- Doughnut Chart -->
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
    // Line Chart
    const lineCtx = document.getElementById('bookingLineChart').getContext('2d');
    const bookingLineChart = new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Bookings',
                data: [50, 70, 90, 40, 60, 80],
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

    // Doughnut Chart
    const doughnutCtx = document.getElementById('bookingDoughnutChart').getContext('2d');
    const bookingDoughnutChart = new Chart(doughnutCtx, {
        type: 'doughnut',
        data: {
            labels: ['Online', 'Visit'],
            datasets: [{
                label: 'Booking Method',
                data: [120, 90],
                backgroundColor: ['#4caf50', '#2196f3'],
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
