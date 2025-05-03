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
            <!-- Feedback Overview -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card p-3 shadow-sm">
                        <h5 class="mb-0">Total Reviews</h5>
                        <h3 class="text-primary">128</h3>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card p-3 shadow-sm">
                        <h5 class="mb-0">Average Rating</h5>
                        <h3 class="text-warning">
                            4.5
                            <i class="fas fa-star text-warning ms-1"></i>
                        </h3>
                    </div>
                </div>
            </div>

            <!-- Feedback List -->
            <div class="card shadow-sm p-3">
                <h5 class="mb-3">User Feedback</h5>
                <div class="list-group">

                    <!-- Sample Feedback Row -->
                    <div class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Juan Dela Cruz</div>
                            <small>“Great service and clean buses.”</small>
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                        </div>
                        <button class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>

                    <!-- Add more feedback entries here -->
                    <div class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Maria Santos</div>
                            <small>“Driver was courteous and on time.”</small>
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <i class="far fa-star"></i>
                            </div>
                        </div>
                        <button class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </div>
</main>