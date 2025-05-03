<?php include '../template/header.php'; ?>

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
                    <a href="./view_drivers.php" class="btn btn-primary mt-2">View Drivers</a>
                </div>
            </div>
        </div>
    </div>
</main>