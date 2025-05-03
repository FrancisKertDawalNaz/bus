<?php
include '../template/header.php'; 
include_once('../../connection.php'); 

// Fetch total reviews and average rating
$review_count_query = "SELECT COUNT(*) FROM reviews";
$rating_query = "SELECT AVG(rating) FROM reviews";

$review_count_result = $conn->query($review_count_query);
$review_count = $review_count_result->fetch_row()[0];

$rating_result = $conn->query($rating_query);
$avg_rating = $rating_result->fetch_row()[0];

// Fetch reviews
$review_query = "SELECT id, review_name, review_message, rating FROM reviews ORDER BY id DESC";
$review_result = $conn->query($review_query);
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

        <!-- Main Content -->
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

            <!-- Feedback Overview -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card p-3 shadow-sm">
                        <h5 class="mb-0">Total Reviews</h5>
                        <h3 class="text-primary"><?php echo $review_count; ?></h3>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card p-3 shadow-sm">
                        <h5 class="mb-0">Average Rating</h5>
                        <h3 class="text-warning">
                            <?php echo number_format($avg_rating, 1); ?>
                            <i class="fas fa-star text-warning ms-1"></i>
                        </h3>
                    </div>
                </div>
            </div>

            <!-- Feedback List -->
            <div class="card shadow-sm p-3">
                <h5 class="mb-3">User Feedback</h5>
                <div class="list-group">
                    <?php
                    if ($review_result->num_rows > 0):
                        $count = 0;
                        while ($row = $review_result->fetch_assoc()):
                            $stars = (int) $row['rating'];
                            $label = match ($stars) {
                                5 => ['Excellent', 'success'],
                                4 => ['Good', 'primary'],
                                3 => ['Average', 'info'],
                                2 => ['Poor', 'warning'],
                                default => ['Unacceptable', 'danger'],
                            };
                            $count++;
                            $hidden = $count > 3 ? 'd-none extra-feedback' : '';
                    ?>
                    <div class="list-group-item d-flex justify-content-between align-items-start <?= $hidden ?>" data-id="<?= $row['id'] ?>">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold"><?php echo htmlspecialchars($row['review_name']); ?></div>
                            <small><?php echo htmlspecialchars($row['review_message']); ?></small>
                            <div class="text-warning">
                                <?php
                                for ($i = 1; $i <= 5; $i++) {
                                    echo $i <= $stars
                                        ? '<i class="fas fa-star text-warning"></i>'
                                        : '<i class="far fa-star text-warning"></i>';
                                }
                                ?>
                            </div>
                        </div>
                        <button class="btn btn-sm btn-outline-danger delete-btn">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                    <?php endwhile; ?>
                    <button id="toggleFeedbackBtn" class="btn btn-link text-decoration-none text-center mt-3" style="width: 100%;">See More</button>
                    <?php else: ?>
                        <p class="text-muted">No feedback available.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById('toggleFeedbackBtn')?.addEventListener('click', function () {
    const extras = document.querySelectorAll('.extra-feedback');
    const isHidden = extras[0]?.classList.contains('d-none');
    extras.forEach(el => el.classList.toggle('d-none'));
    this.textContent = isHidden ? 'See Less' : 'See More';
});

document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        const item = this.closest('.list-group-item');
        const id = item.getAttribute('data-id');

        Swal.fire({
            title: 'Are you sure you want to delete this?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then(result => {
            if (result.isConfirmed) {
                fetch(`../function/delete_review.php?id=${id}`)
                    .then(res => res.text())
                    .then(data => {
                        if (data.trim() === 'success') {
                            item.remove();
                            Swal.fire('Deleted!', 'Feedback has been removed.', 'success');
                        } else {
                            Swal.fire('Error!', 'Failed to delete.', 'error');
                        }
                    });
            }
        });
    });
});
</script>

