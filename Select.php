<?php include_once('template/mainheader.php') ?>

<?php
include('connection.php');

$busTitle = isset($_GET['bus_title']) ? htmlspecialchars($_GET['bus_title']) : 'N/A';
$busNo = isset($_GET['bus_no']) ? htmlspecialchars($_GET['bus_no']) : 'N/A';
$busPrice = isset($_GET['bus_price']) ? htmlspecialchars($_GET['bus_price']) : 'N/A';

$bookedSeats = [];
if ($busNo !== '') {
  $result = $conn->query("SELECT seat_no FROM booking_tb WHERE bus_no = '$busNo'");
  while ($row = $result->fetch_assoc()) {
    $bookedSeats[] = $row['seat_no'];
  }
}

$availableSeats = [];
for ($i = 1; $i <= 20; $i++) {
  $seat = "S" . str_pad($i, 2, "0", STR_PAD_LEFT);
  if (!in_array($seat, $bookedSeats)) {
    $availableSeats[] = $seat;
  }
}
?>

<main class="container pt-5 pb-5 mt-5">
  <div class="row justify-content-center mb-4">
    <div class="col-md-8">
      <div class="card shadow-lg border-light">
        <div class="card-header bg-gradient-primary text-white rounded-top">
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <p><strong>Bus Title:</strong> <?php echo $busTitle; ?></p>
              <p><strong>Bus Number:</strong> <?php echo $busNo; ?></p>
              <p><strong>Price:</strong> ₱<?php echo $busPrice; ?></p>
            </div>
            <div class="col-md-6">
              <h5 class="text-center mt-3 mb-4">Available Seats</h5>
              <div class="row">
                <?php foreach ($availableSeats as $seat): ?>
                  <div class="col-3">
                    <button class="btn btn-outline-success btn-sm w-100 mb-2"><?php echo $seat; ?></button>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <h3 class="mb-3">Book Your Bus</h3>
      <form action="submit_booking.php" method="POST">
        <input type="hidden" name="bus_title" value="<?php echo $busTitle; ?>">
        <input type="hidden" name="bus_no" value="<?php echo $busNo; ?>">
        <input type="hidden" name="bus_price" value="<?php echo $busPrice; ?>">

        <div class="mb-3">
          <label for="name" class="form-label">Your Name</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-user"></i></span>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
        </div>

        <div class="mb-3">
          <label for="phone" class="form-label">Phone Number</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-phone"></i></span>
            <input type="text" class="form-control" id="phone" name="phone" required>
          </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
          <label for="origin" class="form-label">Origin</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-location-arrow"></i></span>
            <input type="text" class="form-control" id="origin" name="origin" required>
          </div>
        </div>

        <div class="mb-3">
          <label for="destination" class="form-label">Destination</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
            <input type="text" class="form-control" id="destination" name="destination" required>
          </div>
        </div>

        <div class="mb-3">
          <label for="seat_no" class="form-label">Select Seat</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-chair"></i></span>
            <select class="form-select" id="seat_no" name="seat_no" required>
              <option value="">Choose a seat</option>
              <?php foreach ($availableSeats as $seat): ?>
                <option value="<?php echo $seat; ?>"><?php echo $seat; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-check-circle"></i> Submit</button>
      </form>
    </div>
  </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
