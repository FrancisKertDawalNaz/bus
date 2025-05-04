<?php

echo '<script>
  window.onload = function() {
    const modal = new bootstrap.Modal(document.getElementById("thankYouModal"));
    modal.show();
    setTimeout(function() {
      window.location.href = "main.php"; // Redirect after 5 seconds
    }, 5000); // 5 seconds delay
  }
</script>';
?>

<!-- Thank You Modal -->
<div class="modal fade" id="thankYouModal" tabindex="-1" aria-labelledby="thankYouLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="thankYouLabel">Thank You!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Your booking has been successfully submitted. We will process it shortly.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
