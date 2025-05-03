<?php include '../template/header.php'; ?>

<main class="full-bg d-flex align-items-center justify-content-center" style="min-height: 100vh; background-image: url('../assets/images/buss.png'); background-size: cover; background-position: center;">
    <div class="bg-white bg-opacity-75 p-4 rounded-4 shadow-lg" style="max-width: 400px; width: 100%;">
        <h2 class="text-center mb-4">Driver Login</h2>
        <form action="../function/login.php" method="POST">
            <div class="mb-3">
                <label for="driverId" class="form-label">Driver ID</label>
                <input type="text" class="form-control" id="driverId" name="driver_id" placeholder="Enter your ID" required>
            </div>
            <div class="mb-3">
                <label for="driverPassword" class="form-label">Password</label>
                <input type="password" class="form-control" id="driverPassword" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <div class="text-center mt-3">
            <a href="#" data-bs-toggle="modal" data-bs-target="#createAccountModal">Create Account</a>
        </div>
    </div>
</main>

<div class="modal fade" id="createAccountModal" tabindex="-1" aria-labelledby="createAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createAccountModalLabel">Create Driver Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../function/insert.php" method="POST" class="modal-content">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="newDriverName" class="form-label">Driver Name</label>
                        <input type="text" class="form-control" id="newDriverName" name="driver_name" placeholder="Enter your name" required>
                    </div>
                    <div class="mb-3">
                        <label for="newDriverId" class="form-label">Driver ID</label>
                        <input type="text" class="form-control" id="newDriverId" name="driver_id" placeholder="Enter your ID" required>
                    </div>
                    <div class="mb-3">
                        <label for="newDriverPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="newDriverPassword" name="password" placeholder="Enter your password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Create Account</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../template/footer.php'; ?>
