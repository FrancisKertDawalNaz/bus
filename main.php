<?php include_once('template/mainheader.php')

?>

<main>
    <div class="position-relative w-100 vh-100">
        <img src="asset/images/buss.png" alt="Main Image" class="img-fluid w-100 h-100 object-fit-cover blurred-image">
        <div class="position-absolute top-50 end-0 translate-middle-y text-end text-white p-5" style="max-width: 600px;">
            <h1 class="display-3 fw-bold">Your Journey<br>of Explorations</h1>
            <h4 class="mt-3 fw-semibold text-danger">Where Every Ride Matters.</h4>
            <p class="mt-2">Every Ride Counts, Every Passenger Matters with GoTranspo.</p>

            <div class="mt-4">
                <a href="./book.php" class="btn btn-primary btn-sm me-2 px-4 py-2" style="background-color: #001f3d; border: none; font-size: 0.9rem;">
                    <i class="bi bi-bus-front-fill me-2"></i> Book Now
                </a>
                <a href="#" class="btn btn-outline-light btn-sm px-4 py-2" style="font-size: 0.9rem;">
                    <i class="bi bi-info-circle me-2"></i> Learn More
                </a>
            </div>

            <div class="mt-4">
                <a href="#" class="btn btn-danger px-5 py-2 fw-bold" style="font-size: 1rem;" data-bs-toggle="modal" data-bs-target="#sosModal">
                    <i class="bi bi-bell-fill me-2"></i> SOS Alarm
                </a>
            </div>

            <div class="mt-4">
                <a href="#" class="btn btn-danger px-5 py-2 fw-bold" style="font-size: 1rem;" data-bs-toggle="modal" data-bs-target="#reviewModal">
                    <i class="bi bi-star-fill me-2"></i> Set a Review
                </a>
            </div>
        </div>
    </div>

    <!-- SOS Modal -->
    <div class="modal fade" id="sosModal" tabindex="-1" aria-labelledby="sosModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-white" style="background-color: #dc3545;">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="sosModalLabel"><i class="bi bi-exclamation-triangle-fill me-2"></i>Emergency Alert</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="fs-5 mb-0 text-center">Are you in danger or need urgent help?</p>
                    <p class="text-center">An alert will be sent to the driver and GoTranspo support.</p>

                    <!-- Emergency Type Selection -->
                    <div class="mb-3">
                        <label for="emergencyType" class="form-label">Select Emergency Type</label>
                        <select class="form-select" id="emergencyType" name="emergency_type" required>
                            <option value="fire">Fire</option>
                            <option value="accident">Accident</option>
                            <option value="mechanical_issue">Mechanical Issue</option>
                            <option value="medical">Medical Emergency</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                    <form action="send_alert.php" method="post">
                        <input type="hidden" name="driver_id" value="<?php echo $driver_id; ?>"> <!-- Pass Driver ID if needed -->
                        <button type="submit" class="btn btn-dark px-4">Send Alert</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Review Modal -->
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-dark">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel"><i class="bi bi-pencil-fill me-2"></i> Leave a Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Review Form -->
                    <form action="./function/submit_review.php" method="POST">
                        <div class="mb-3">
                            <label for="review_name" class="form-label">Your Name</label>
                            <input type="text" class="form-control" id="review_name" name="review_name" placeholder="Enter your name" required>
                        </div>
                        <div class="mb-3">
                            <label for="review_message" class="form-label">Your Review</label>
                            <textarea class="form-control" id="review_message" name="review_message" rows="4" placeholder="Write your review here..." required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="rating" class="form-label">Rating</label>
                            <select class="form-select" id="rating" name="rating" required>
                                <option value="1">1 - Poor</option>
                                <option value="2">2 - Fair</option>
                                <option value="3">3 - Good</option>
                                <option value="4">4 - Very Good</option>
                                <option value="5">5 - Excellent</option>
                            </select>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-success">Submit Review</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</main>

<?php if (isset($_SESSION['review_status'])): ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            <?php if ($_SESSION['review_status'] === 'success'): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Thank you!',
                    text: 'Your review was submitted successfully.',
                    confirmButtonColor: '#3085d6'
                });
            <?php elseif ($_SESSION['review_status'] === 'error'): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'There was a problem submitting your review.',
                    confirmButtonColor: '#d33'
                });
            <?php elseif ($_SESSION['review_status'] === 'invalid'): ?>
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Rating',
                    text: 'Please choose a rating between 1 and 5.',
                    confirmButtonColor: '#f39c12'
                });
            <?php endif; ?>
        });
    </script>
    <?php unset($_SESSION['review_status']); ?>
<?php endif; ?>