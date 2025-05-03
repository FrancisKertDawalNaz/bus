<?php
include_once('../template/header.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once('../../connection.php');

if (!isset($_SESSION['driver_id'])) {
    die("Unauthorized access.");
}

$driver_id = $_SESSION['driver_id'];
$driver_name = 'Guest';
$image_path = '../uploads/default_driver.png';

// Fetch driver's name
$query = "SELECT driver_name, image_path FROM drivers WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $driver_id);
$stmt->execute();
$stmt->bind_result($name, $img_path);
if ($stmt->fetch()) {
    $driver_name = $name;
    if (!empty($img_path) && file_exists('../uploads/' . $img_path)) {
        $image_path = '../uploads/' . $img_path;
    }
}
$stmt->close();
?>

<main style="height: 100vh; overflow: hidden;">
    <div class="d-flex" style="height: 100%;">

        <!-- Sidebar -->
        <nav class="text-white p-3" style="width: 250px; background-color: #001f5b; position: fixed; top: 0; left: 0; height: 100vh; overflow-y: auto;">
            <div class="text-center mb-4">
                <img src="../assets/images/logo.png" alt="Logo" class="img-fluid" style="max-width: 150px;">
            </div>
            <ul class="list-unstyled">
                <li><a href="./main.php" class="sidebar-link text-white d-flex align-items-center py-2"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a></li>
                <li><a href="./notification.php" class="sidebar-link text-white d-flex align-items-center py-2"><i class="fas fa-bell me-2"></i> Notifications</a></li>
                <li><a href="./account.php" class="sidebar-link text-white d-flex align-items-center py-2"><i class="fas fa-user me-2"></i> Account</a></li>
                <li><a href="./reviews.php" class="sidebar-link text-white d-flex align-items-center py-2"><i class="fas fa-star me-2"></i> Reviews</a></li>
                <li><a href="./tracking.php" class="sidebar-link text-white d-flex align-items-center py-2"><i class="fas fa-location-arrow me-2"></i> GPS Tracking</a></li>
                <li><a href="./reports.php" class="sidebar-link text-white d-flex align-items-center py-2"><i class="fas fa-file-alt me-2"></i> Reports</a></li>
            </ul>
            <ul class="list-unstyled mt-auto">
                <li><a href="#" class="text-white d-flex align-items-center py-2"><i class="fas fa-life-ring me-2"></i> Help</a></li>
                <li><a href="./index.php" class="text-white d-flex align-items-center py-2"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="flex-fill p-4" style="margin-left: 250px; height: 100vh; overflow-y: auto; background-color: #f0f8ff;">
            <div class="d-flex justify-content-between align-items-center p-3 mb-4" style="background-color: #7dd87d; border-radius: 10px;">
                <div class="text-white">
                    <h5>Welcome <?php echo htmlspecialchars($driver_name); ?></h5>
                    <small>See what people are saying about you!</small>
                </div>
                <div class="d-flex align-items-center">
                    <div class="input-group me-3" style="width: 200px;">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Search here...">
                    </div>
                    <img src="<?php echo $image_path; ?>" alt="Profile" class="rounded-circle" style="width: 40px; height: 40px;">
                </div>
            </div>

            <!-- Reviews Section -->
            <div class="card p-4">
                <h4 class="mb-4">User Reviews</h4>

                <?php
                $limit = 3; // Limit the number of reviews initially displayed
                $review_query = "SELECT review_name, review_message, rating FROM reviews WHERE driver_id = ? ORDER BY id DESC LIMIT ?";
                $review_stmt = $conn->prepare($review_query);
                $review_stmt->bind_param('ii', $driver_id, $limit);
                $review_stmt->execute();
                $review_result = $review_stmt->get_result();

                if ($review_result->num_rows > 0):
                    while ($row = $review_result->fetch_assoc()):
                        $stars = (int) $row['rating'];
                        $label = match ($stars) {
                            5 => ['Excellent', 'success'],
                            4 => ['Good', 'primary'],
                            3 => ['Average', 'info'],
                            2 => ['Poor', 'warning'],
                            default => ['Unacceptable', 'danger'],
                        };
                ?>
                    <div class="mb-4 border-bottom pb-3 review-item">
                        <div class="d-flex align-items-center mb-2">
                            <div class="me-2">
                                <?php
                                for ($i = 1; $i <= 5; $i++) {
                                    echo $i <= $stars
                                        ? '<i class="fas fa-star text-warning"></i>'
                                        : '<i class="far fa-star text-warning"></i>';
                                }
                                ?>
                            </div>
                            <span class="badge bg-<?= $label[1] ?>"><?= $label[0] ?></span>
                        </div>
                        <p class="mb-1 fw-bold mb-0"><?= htmlspecialchars($row['review_name']) ?></p>
                        <p class="mb-0"><?= htmlspecialchars($row['review_message']) ?></p>
                    </div>
                <?php
                    endwhile;
                else:
                    echo "<p class='text-muted'>No reviews found.</p>";
                endif;

                $review_stmt->close();
                ?>

                <!-- See More Button -->
                <button id="seeMoreBtn" class="btn btn-link text-decoration-none text-center" style="width: 100%;">See More</button>

                <!-- Hidden Reviews Section -->
                <div id="extraReviews" style="display: none;">
                    <?php
                    // Fetch additional reviews beyond the initial 3
                    $review_query = "SELECT review_name, review_message, rating FROM reviews WHERE driver_id = ? ORDER BY id DESC LIMIT ?, 9999";
                    $review_stmt = $conn->prepare($review_query);
                    $review_stmt->bind_param('ii', $driver_id, $limit);
                    $review_stmt->execute();
                    $review_result = $review_stmt->get_result();

                    if ($review_result->num_rows > 0):
                        while ($row = $review_result->fetch_assoc()):
                            $stars = (int) $row['rating'];
                            $label = match ($stars) {
                                5 => ['Excellent', 'success'],
                                4 => ['Good', 'primary'],
                                3 => ['Average', 'info'],
                                2 => ['Poor', 'warning'],
                                default => ['Unacceptable', 'danger'],
                            };
                    ?>
                        <div class="mb-4 border-bottom pb-3 review-item">
                            <div class="d-flex align-items-center mb-2">
                                <div class="me-2">
                                    <?php
                                    for ($i = 1; $i <= 5; $i++) {
                                        echo $i <= $stars
                                            ? '<i class="fas fa-star text-warning"></i>'
                                            : '<i class="far fa-star text-warning"></i>';
                                    }
                                    ?>
                                </div>
                                <span class="badge bg-<?= $label[1] ?>"><?= $label[0] ?></span>
                            </div>
                            <p class="mb-1 fw-bold mb-0"><?= htmlspecialchars($row['review_name']) ?></p>
                            <p class="mb-0"><?= htmlspecialchars($row['review_message']) ?></p>
                        </div>
                    <?php
                        endwhile;
                    endif;

                    $review_stmt->close();
                    ?>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    document.getElementById('seeMoreBtn').addEventListener('click', function() {
        var extraReviews = document.getElementById('extraReviews');
        var button = document.getElementById('seeMoreBtn');

        if (extraReviews.style.display === 'none') {
            extraReviews.style.display = 'block';
            button.textContent = 'See Less';
        } else {
            extraReviews.style.display = 'none';
            button.textContent = 'See More';
        }
    });
</script>
