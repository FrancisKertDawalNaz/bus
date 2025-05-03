<?php include '../template/header.php'; ?>

<main class="full-bg d-flex align-items-center justify-content-center" style="min-height: 100vh; background-image: url('../../asset/images/buss.png'); background-size: cover; background-position: center;">
    <div class="bg-white bg-opacity-75 p-4 rounded-4 shadow-lg" style="max-width: 400px; width: 100%;">
        <h2 class="text-center mb-4">Admin Login</h2>
        <form action="../function/login.php" method="POST">
            <div class="mb-3">
                <label for="adminId" class="form-label">Admin ID</label>
                <input type="text" class="form-control" id="adminId" name="admin_id" placeholder="Enter your Admin ID" required>
            </div>
            <div class="mb-3">
                <label for="adminPassword" class="form-label">Password</label>
                <input type="password" class="form-control" id="adminPassword" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</main>


<?php include '../template/footer.php'; ?>
