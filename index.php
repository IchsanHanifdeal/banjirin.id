<?php
session_start();
include 'backend/koneksi.php';

$sqld = "SELECT * FROM banjir";
$resultd = mysqli_query($conn, $sqld);
$rowd = mysqli_fetch_assoc($resultd);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <title>Pemetaan Banjir</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAQqCVzh9CHvZAJrfAoR-mVZD-dZxap2Xo&callback=initGoogleMap&libraries=geometry" async defer></script>
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
                    <li class="nav-item">
                        <button id="getCurrentLocationBtn" class="btn btn-primary">Get Current Location</button>
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
        var markers = [];
        var currentLocationMarker;
        var directionsService;
        var directionsRenderer;

        function initGoogleMap() {
            googleMap = new google.maps.Map(document.getElementById("google-map"), {
                center: {
                    lat: 0.537488,
                    lng: 101.448387
                },
                zoom: 15,
            });

            directionsService = new google.maps.DirectionsService();
            directionsRenderer = new google.maps.DirectionsRenderer({
                map: googleMap
            });

            <?php
            $resultd = mysqli_query($conn, $sqld);
            while ($rowd = mysqli_fetch_assoc($resultd)) {
                $nama = $rowd['nama_daerah'];
                $long = $rowd['longitude'];
                $lat = $rowd['latitude'];
                $level = $rowd['level'];
                $radius = $rowd['radius'];

                if (!empty($lat) && !empty($long) && !empty($radius)) {
                    $icon = '';
                    $strokeColor = '';
                    $fillColor = '';
                    if ($level == 'rendah') {
                        $icon = 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png';
                        $strokeColor = '#0000FF';
                        $fillColor = '#0000FF';
                    } else if ($level == 'menengah') {
                        $icon = 'http://maps.google.com/mapfiles/ms/icons/yellow-dot.png';
                        $strokeColor = '#FFFF00';
                        $fillColor = '#FFFF00';
                    } else if ($level == 'tinggi') {
                        $icon = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
                        $strokeColor = '#FF0000';
                        $fillColor = '#FF0000';
                    }
            ?>
                    var marker = new google.maps.Marker({
                        position: {
                            lat: <?php echo $lat; ?>,
                            lng: <?php echo $long; ?>
                        },
                        map: googleMap,
                        title: '<?php echo $nama; ?>',
                        level: '<?php echo $level; ?>',
                        icon: '<?php echo $icon; ?>'
                    });

                    var circle = new google.maps.Circle({
                        strokeColor: '<?php echo $strokeColor; ?>',
                        strokeOpacity: 0.8,
                        strokeWeight: 2,
                        fillColor: '<?php echo $fillColor; ?>',
                        fillOpacity: 0.35,
                        map: googleMap,
                        center: {
                            lat: <?php echo $lat; ?>,
                            lng: <?php echo $long; ?>
                        },
                        radius: <?php echo $radius; ?>
                    });

                    marker.addListener('click', function() {
                        updateMarkerColor(this);
                        calculateAndDisplayRoute(this.getPosition());
                    });

                    markers.push(marker);
            <?php
                }
            }
            ?>

            function updateMarkerColor(marker) {
                const level = marker.level;

                let markerColor;

                switch (level) {
                    case "rendah":
                        markerColor = "green";
                        break;
                    case "menengah":
                        markerColor = "yellow";
                        break;
                    case "tinggi":
                        markerColor = "red";
                        break;
                    default:
                        markerColor = "blue";
                }

                const iconUrl = `http://maps.google.com/mapfiles/ms/icons/${markerColor}-dot.png`;
                marker.setIcon({
                    url: iconUrl,
                    scaledSize: new google.maps.Size(40, 40),
                });
            }

            function calculateAndDisplayRoute(destination) {
                var request = {
                    origin: currentLocationMarker.getPosition(),
                    destination: destination,
                    travelMode: 'DRIVING'
                };

                directionsService.route(request, function(result, status) {
                    if (status == 'OK') {
                        directionsRenderer.setDirections(result);
                    } else {
                        console.error('Error calculating route:', status);
                    }
                });
            }

            var getCurrentLocationBtn = document.getElementById('getCurrentLocationBtn');
            getCurrentLocationBtn.addEventListener('click', function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var currentLocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };

                        if (currentLocationMarker) {
                            currentLocationMarker.setMap(null);
                        }

                        currentLocationMarker = new google.maps.Marker({
                            position: currentLocation,
                            map: googleMap,
                            title: 'Your Location'
                        });

                        var distances = [];
                        markers.forEach(function(marker, index) {
                            var distance = google.maps.geometry.spherical.computeDistanceBetween(
                                new google.maps.LatLng(currentLocation.lat, currentLocation.lng),
                                marker.getPosition()
                            );
                            distances.push({
                                index: index,
                                distance: distance
                            });
                        });

                        distances.sort(function(a, b) {
                            return a.distance - b.distance;
                        });

                        var closestMarker = markers[distances[0].index];

                        updateMarkerColor(closestMarker);
                        calculateAndDisplayRoute(closestMarker.getPosition());
                    }, function(error) {
                        console.error('Error getting current location:', error);
                    });
                } else {
                    alert('Geolocation is not supported by your browser.');
                }
            });
        }
    </script>

</body>

</html>