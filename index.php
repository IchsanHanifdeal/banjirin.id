<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/style.css">
    <title>Pemetaan Banjir</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAQqCVzh9CHvZAJrfAoR-mVZD-dZxap2Xo&callback=initGoogleMap" async defer></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #6C5F5B">
        <div class="container">
            <a class="navbar-brand" href="#">Banjirin.id</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#home">Home</a>
                    </li>
                    <li class="nav-item text-right">
                        <a class="nav-link" aria-current="page" href="login.php ">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div id="map-container">
        <div id="google-map" style="height: 800px"></div>
    </div>
    <footer class="text-center text-white" style="background-color: #6C5F5B">
        <div class="text-center p-3" style="background-color: #6C5F5B">
            &copy; Ichsan Hanifdeal
        </div>
    </footer>
    <script>
        var googleMap;

        function initGoogleMap() {
            googleMap = new google.maps.Map(document.getElementById("google-map"), {
                center: {
                    lat: 0.537488,
                    lng: 101.448387
                },
                zoom: 15,
            });
        }
    </script>
</body>

</html>