<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    die("Unauthorized access.");
}

include '../template/header.php';
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

        <!-- Main content -->
        <div class="flex-fill p-4" style="margin-left: 250px; height: 100vh; overflow-y: auto; background-color: #f0f8ff;">
            <?php if (isset($_GET['login']) && $_GET['login'] === 'success'): ?>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Login Successful',
                        text: 'Welcome, Admin!',
                        confirmButtonText: 'OK'
                    });
                </script>
            <?php endif; ?>

            <?php if (isset($_GET['login']) && $_GET['login'] === 'fail'): ?>
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Failed',
                        text: 'Incorrect ID or Password!',
                        confirmButtonText: 'Try Again'
                    });
                </script>
            <?php endif; ?>

            <!-- Dashboard Content -->
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

            
            <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="../function/update_booking.php" method="POST">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="editUserModalLabel">Edit Booking Details</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="original_booking_date" id="originalBookingDate"> <!-- Primary key or identifier -->

                                <div class="mb-3">
                                    <label for="bookingDate" class="form-label">Booking Date</label>
                                    <input type="text" class="form-control" id="bookingDate" name="booking_date" required>
                                </div>

                                <div class="mb-3">
                                    <label for="busNo" class="form-label">Bus No</label>
                                    <input type="text" class="form-control" id="busNo" name="bus_no" required>
                                </div>

                                <div class="mb-3">
                                    <label for="busPrice" class="form-label">Bus Price</label>
                                    <input type="text" class="form-control" id="busPrice" name="bus_price" required>
                                </div>

                                <div class="mb-3">
                                    <label for="seatNo" class="form-label">Seat No</label>
                                    <input type="text" class="form-control" id="seatNo" name="seat_no" required>
                                </div>

                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete the booking for Bus No: <strong id="modalBusNo"></strong> on <strong id="modalBookingDate"></strong>?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Delete</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card p-3">
                <h5 class="mb-3">Bus Bookings</h5>
                <div class="table-responsive" id="bookingTable">
                    <table class="table table-striped align-middle">
                        <thead class="table-success">
                            <tr>
                                <th>Booking Date</th>
                                <th>Bus No</th>
                                <th>Bus Price</th>
                                <th>Seat No</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include_once('../../connection.php');

                            $booking_query = "SELECT booking_date, bus_no, bus_price, seat_no, name FROM booking_tb ORDER BY booking_date DESC";
                            $result = $conn->query($booking_query);

                            $count = 0;
                            $allRows = [];
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $allRows[] = $row;
                                }
                            }

                            foreach (array_slice($allRows, 0, 4) as $row) {
                                echo "<tr class='booking-row'>";
                                echo "<td>" . htmlspecialchars($row['booking_date']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['bus_no']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['bus_price']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['seat_no']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                echo "<td>
                                        <button 
                                             class='btn btn-sm btn-primary me-1 edit-btn'
                                             data-bs-toggle='modal'
                                             data-bs-target='#editUserModal'
                                             data-booking-date='" . htmlspecialchars($row['booking_date']) . "'
                                             data-bus-no='" . htmlspecialchars($row['bus_no']) . "'
                                             data-bus-price='" . htmlspecialchars($row['bus_price']) . "'
                                             data-seat-no='" . htmlspecialchars($row['seat_no']) . "'
                                             data-name='" . htmlspecialchars($row['name']) . "'>
                                            <i class='fas fa-edit'></i> Edit
                                        </button>

                                        <button 
                                             class='btn btn-sm btn-danger me-1 delete-btn' 
                                             data-bs-toggle='modal' 
                                             data-bs-target='#deleteModal'
                                             data-booking-date='" . htmlspecialchars($row['booking_date']) . "' 
                                             data-bus-no='" . htmlspecialchars($row['bus_no']) . "'>
                                             <i class='fas fa-trash-alt'></i> Delete
                                        </button>

                                        
                                      </td>";
                                echo "</tr>";
                            }

                            $conn->close();
                            ?>
                        </tbody>
                    </table>

                
                    <div id="seeMoreBtn" class="text-center mt-3">
                        <button class="btn btn-primary" onclick="showMoreRows()">See More</button>
                    </div>


                    <div id="seeLessBtn" class="text-center mt-3" style="display: none;">
                        <button class="btn btn-secondary" onclick="showLessRows()">See Less</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

<script>
    let allRows = <?php echo json_encode($allRows); ?>;
    let displayedRowsCount = 4;

    function showMoreRows() {

        let rowsToDisplay = allRows.slice(displayedRowsCount);
        let tableBody = document.querySelector('#bookingTable tbody');
        rowsToDisplay.forEach(row => {
            let tr = document.createElement('tr');
            tr.classList.add('booking-row');
            tr.innerHTML = `
                <td>${row.booking_date}</td>
                <td>${row.bus_no}</td>
                <td>${row.bus_price}</td>
                <td>${row.seat_no}</td>
                <td>${row.name}</td>
                <td>
                    <button class='btn btn-sm btn-primary me-1'>
                        <i class='fas fa-edit'></i> Edit
                    </button>
                    <button class='btn btn-sm btn-danger'>
                        <i class='fas fa-trash-alt'></i> Delete
                    </button>
                </td>
            `;
            tableBody.appendChild(tr);
        });

        displayedRowsCount = allRows.length;

        document.getElementById('seeMoreBtn').style.display = 'none';
        document.getElementById('seeLessBtn').style.display = 'block';
    }

    function showLessRows() {
        let rows = document.querySelectorAll('.booking-row');
        rows.forEach((row, index) => {
            if (index >= 4) {
                row.style.display = 'none';
            }
        });

        displayedRowsCount = 4;

        document.getElementById('seeLessBtn').style.display = 'none';
        document.getElementById('seeMoreBtn').style.display = 'block';
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const editButtons = document.querySelectorAll('.edit-btn');

        editButtons.forEach(button => {
            button.addEventListener('click', () => {
                document.getElementById('originalBookingDate').value = button.getAttribute('data-booking-date');
                document.getElementById('bookingDate').value = button.getAttribute('data-booking-date');
                document.getElementById('busNo').value = button.getAttribute('data-bus-no');
                document.getElementById('busPrice').value = button.getAttribute('data-bus-price');
                document.getElementById('seatNo').value = button.getAttribute('data-seat-no');
                document.getElementById('name').value = button.getAttribute('data-name');
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const bookingDate = this.getAttribute('data-booking-date');
                const busNo = this.getAttribute('data-bus-no');
                document.getElementById('modalBookingDate').textContent = bookingDate;
                document.getElementById('modalBusNo').textContent = busNo;
                const confirmDeleteUrl = `../function/delete_booking.php?booking_date=${encodeURIComponent(bookingDate)}&bus_no=${encodeURIComponent(busNo)}`;
                document.getElementById('confirmDeleteBtn').setAttribute('href', confirmDeleteUrl);
            });
        });
    });
</script>



<?php if (isset($_GET['update']) && $_GET['update'] === 'success'): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Updated!',
            text: 'Booking details have been updated.',
            confirmButtonText: 'OK'
        });
    </script>
<?php elseif (isset($_GET['update']) && $_GET['update'] === 'fail'): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Update Failed',
            text: 'Something went wrong while updating.',
            confirmButtonText: 'OK'
        });
    </script>
<?php endif; ?>

<?php if (isset($_GET['delete']) && $_GET['delete'] === 'success'): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Deleted!',
            text: 'The booking has been successfully deleted.',
            confirmButtonText: 'OK'
        });
    </script>
<?php elseif (isset($_GET['delete']) && $_GET['delete'] === 'fail'): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Delete Failed',
            text: 'There was an issue deleting the booking.',
            confirmButtonText: 'OK'
        });
    </script>
<?php elseif (isset($_GET['delete']) && $_GET['delete'] === 'error'): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'There was an error processing your request.',
            confirmButtonText: 'OK'
        });
    </script>
<?php endif; ?>



<?php

if (!isset($_SESSION['admin_id'])) {
    session_destroy();
}
?>