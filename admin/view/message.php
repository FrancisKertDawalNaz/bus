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
        <div class="flex-fill p-4" style="margin-left: 250px; height: 100vh; overflow-y: auto; background-color: #f0f8ff;">
            <div class="d-flex justify-content-between align-items-center p-3 mb-4" style="background-color: #7dd87d; border-radius: 10px;">
                <div class="text-white">
                    <h5>Welcome Admin</h5>
                    <small>Here are your recent messages.</small>
                </div>
                <div class="d-flex align-items-center">
                    <div class="input-group me-3" style="width: 200px;">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Search users...">
                    </div>
                    <img src="../../driver/assets/images/user.png" alt="Profile" class="rounded-circle" style="width: 40px; height: 40px;">
                </div>
            </div>

            <div class="row g-3">
                <!-- Sidebar user list -->
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h6 class="mb-0">Users</h6>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex align-items-center">
                                <img src="../../driver/assets/images/user.png" alt="User" class="rounded-circle me-2" width="40" height="40">
                                <div>
                                    <strong>Juan Dela Cruz</strong><br>
                                    <small class="text-muted">Hello, admin!</small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <img src="../../driver/assets/images/user.png" alt="User" class="rounded-circle me-2" width="40" height="40">
                                <div>
                                    <strong>Ana Santos</strong><br>
                                    <small class="text-muted">Thank you po sa reply.</small>
                                </div>
                            </li>
                            <!-- Add more users here -->
                        </ul>
                    </div>
                </div>

                <!-- Chat messages -->
                <div class="col-md-8">
                    <div class="card shadow-sm d-flex flex-column" style="height: 500px;">
                        <div class="card-header bg-white">
                            <strong>Chat with Juan Dela Cruz</strong>
                        </div>
                        <div class="card-body overflow-auto" style="flex-grow: 1;">
                            <div class="mb-3">
                                <div class="bg-light p-2 rounded w-75 mb-2">
                                    <small><strong>Juan:</strong> Hello Admin!</small>
                                </div>
                                <div class="bg-success text-white p-2 rounded w-75 ms-auto text-end">
                                    <small><strong>You:</strong> Hello! How can I help?</small>
                                </div>
                            </div>
                            <!-- Add more messages as needed -->
                        </div>
                        <div class="card-footer bg-white">
                            <form class="d-flex">
                                <input type="text" class="form-control me-2" placeholder="Type a message...">
                                <button class="btn btn-success" type="submit"><i class="fas fa-paper-plane"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>