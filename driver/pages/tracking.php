<?php
include_once('../template/header.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once('../../connection.php');

$driver_name = 'Guest';

if (!isset($_SESSION['driver_id'])) {
    die("Unauthorized access.");
}

$driver_id = $_SESSION['driver_id'];

// Get driver name
$query = "SELECT driver_name FROM drivers WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $driver_id);
$stmt->execute();
$stmt->bind_result($name);
if ($stmt->fetch()) {
    $driver_name = $name;
}
$stmt->close();

// Get driver image
$image_path = '../uploads/default_driver.png';
$query = "SELECT image_path FROM drivers WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $driver_id);
$stmt->execute();
$stmt->bind_result($img);
if ($stmt->fetch()) {
    if (!empty($img) && file_exists('../uploads/' . $img)) {
        $image_path = '../uploads/' . $img;
    }
}
$stmt->close();

// Get the latest origin and destination from bookings
$latestBooking = null;
$query = "SELECT origin, destination FROM booking_tb ORDER BY booking_date DESC LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $latestBooking = $row;
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
                <li><a href="./tracking.php" class="sidebar-link text-white d-flex align-items-center py-2 active"><i class="fas fa-location-arrow me-2"></i> GPS Tracking</a></li>
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
                    <small>Here's the live tracking map</small>
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

            <!-- Map Section -->
            <div id="map" style="height: 500px; width: 100%;"></div>
        </div>
    </div>
</main>

<script>
    const latestBooking = <?php echo json_encode($latestBooking); ?>;
</script>

<!-- Leaflet.js CDN -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', async function () {
    const map = L.map('map').setView([14.5995, 120.9842], 13);  // Default view (Manila)

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    if (latestBooking) {
        try {
            // Geocode origin and destination of the latest booking
            const originCoords = await geocodeAddress(latestBooking.origin);
            const destCoords = await geocodeAddress(latestBooking.destination);

            if (originCoords && destCoords) {
                L.marker(originCoords).addTo(map).bindPopup(`Origin: ${latestBooking.origin}`);
                L.marker(destCoords).addTo(map).bindPopup(`Destination: ${latestBooking.destination}`);

                const line = L.polyline([originCoords, destCoords], { color: 'blue' }).addTo(map);
                map.fitBounds(line.getBounds());
            }
        } catch (error) {
            console.error('Error geocoding latest booking', error);
        }
    }

    // Function to geocode an address
    async function geocodeAddress(address) {
        const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`);
        const data = await response.json();
        if (data.length > 0) {
            return [parseFloat(data[0].lat), parseFloat(data[0].lon)];
        }
        return null;
    }
});
</script>
