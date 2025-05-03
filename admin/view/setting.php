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
                    <img src="../../asset/images/adminpic.jpg" alt="Profile" class="rounded-circle" style="width: 40px; height: 40px;">
                </div>
            </div>
            <div class="container">
                <!-- Upload Image -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body text-center">
                        <h6 class="mb-3">Upload Profile Image</h6>
                        <img src="../../driver/assets/images/user.png" alt="Profile Preview" class="rounded-circle mb-3" style="width: 100px; height: 100px;">
                        <input type="file" class="form-control w-50 mx-auto" accept="image/*">
                    </div>
                </div>

                <!-- Driver Info -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h6 class="mb-3">Driver Information</h6>
                        <form>
                            <div class="mb-3">
                                <label for="driverName" class="form-label">Driver Name</label>
                                <input type="text" class="form-control" id="driverName" placeholder="Enter driver name">
                            </div>
                            <div class="mb-3">
                                <label for="driverId" class="form-label">Driver ID</label>
                                <input type="text" class="form-control" id="driverId" placeholder="Enter driver ID">
                            </div>
                            <div class="mb-3">
                                <label for="driverPassword" class="form-label">Password</label>
                                <input type="password" class="form-control" id="driverPassword" placeholder="Enter new password">
                            </div>
                            <button type="submit" class="btn btn-success">Update Info</button>
                        </form>
                    </div>
                </div>

                <!-- Linked Accounts -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="mb-3">Linked Accounts</h6>
                        <p class="mb-2">Connect your account to Google for easier access:</p>
                        <a href="#" class="btn btn-outline-danger">
                            <i class="fab fa-google me-2"></i> Link Google Account
                        </a>
                    </div>
                </div>
            </div>
        </div>
</main>