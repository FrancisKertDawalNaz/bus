<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Bus Admin</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <!-- Include SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.8/dist/sweetalert2.min.css" rel="stylesheet">



</head>
<style>
    .sidebar-link {
        text-decoration: none;
        color: white;
        transition: background-color 0.3s, padding-left 0.3s;
        border-radius: 5px;
    }

    .sidebar-link:hover {
        background-color: #003580;
        padding-left: 10px;
        text-decoration: none;
    }

    #map {
        height: 500px;
        width: 100%;
    }
</style>

<body>



    <!-- Include SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.8/dist/sweetalert2.min.js"></script>


    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelector('form').onsubmit = function() {
            console.log('Form submitted');
        };
    </script>



</body>

</html>