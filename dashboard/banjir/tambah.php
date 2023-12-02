<?php
session_start();
include '../../backend/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $namaDaerah = mysqli_real_escape_string($conn, $_POST["nama_daerah"]);
    $latitude = mysqli_real_escape_string($conn, $_POST["latitude"]);
    $longitude = mysqli_real_escape_string($conn, $_POST["longitude"]);
    $level = mysqli_real_escape_string($conn, $_POST["level"]);

    $sql = "INSERT INTO banjir (nama_daerah, latitude, longitude, level) VALUES ('$namaDaerah', '$latitude', '$longitude', '$level')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header('location: banjir.php');
    } else {
        echo json_encode(array("status" => "error", "message" => "Error: " . mysqli_error($conn)));
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../../plugins/assets/img/apple-icon.png">
    <title>
        Banjirin.id | Data Banjir
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="../../plugins/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../../plugins/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="../../plugins/assets/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Nepcha Analytics (nepcha.com) -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAQqCVzh9CHvZAJrfAoR-mVZD-dZxap2Xo&libraries=places" defer></script>
    <!-- Include SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


</head>

<body class="g-sidenav-show  bg-gray-200">
    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href="../index.php">
                <img src="../../plugins/assets/img/logo-ct.png" class="navbar-brand-img h-100" alt="main_logo">
                <span class="ms-1 font-weight-bold text-white">Banjirin.id</span>
            </a>
        </div>
        <hr class="horizontal light mt-0 mb-2">
        <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white " href="../index.php">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">dashboard</i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white " href="banjir.php">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">table_view</i>
                        </div>
                        <span class="nav-link-text ms-1">Lokasi Banjir</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="sidenav-footer position-absolute w-100 bottom-0 ">
            <div class="mx-3">
                <a class="btn bg-gradient-primary w-100" href="../EditUser.php" type="button">Edit Profile</a>
            </div>
            <div class="mx-3">
                <a class="btn bg-gradient-secondary w-100" href="../../backend/logout.php" type="button">Log out</a>
            </div>
        </div>
    </aside>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">

        </nav>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card shadow">
                        <div class="card-header bg-gradient-primary shadow-primary border-0">
                            <h6 class="text-white text-uppercase mb-0">Tambah Lokasi Banjir</h6>
                        </div>
                        <div class="card-body px-4">
                            <div id="map" style="height: 600px;"></div>
                            <form method="post" action="">
                                <div class="mb-3">
                                    <label for="nama_daerah" class="form-label">Nama Daerah:</label>
                                    <input type="text" name="nama_daerah" id="nama_daerah" class="form-control" readonly required>
                                </div>

                                <div class="mb-3">
                                    <label for="latitude" class="form-label">Latitude:</label>
                                    <input type="text" id="latitude" name="latitude" class="form-control" readonly required>
                                </div>

                                <div class="mb-3">
                                    <label for="longitude" class="form-label">Longitude:</label>
                                    <input type="text" id="longitude" name="longitude" class="form-control" readonly required>
                                </div>

                                <div class="mb-3">
                                    <label for="level" class="form-label">Level:</label>
                                    <select name="level" id="level" class="form-select" required>
                                        <option value="rendah">Rendah</option>
                                        <option value="menengah">Menengah</option>
                                        <option value="tinggi">Tinggi</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary mt-3">Tambah Data</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!--   Core JS Files   -->
    <script src="../../plugins/assets/js/core/popper.min.js"></script>
    <script src="../../plugins/assets/js/core/bootstrap.min.js"></script>
    <script src="../../plugins/assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../../plugins/assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <script src="../../plugins/assets/js/material-dashboard.min.js?v=3.1.0"></script>
    <script>
        let map, marker;

        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                center: {
                    lat: 0.537488,
                    lng: 101.448387
                },
                zoom: 15,
            });

            map.addListener("click", (event) => {
                placeMarker(event.latLng);
            });
        }

        function placeMarker(location) {
            if (marker) {
                marker.setPosition(location);
            } else {
                marker = new google.maps.Marker({
                    position: location,
                    map: map,
                });
            }

            $("#latitude").val(location.lat());
            $("#longitude").val(location.lng());

            reverseGeocode(location);
        }

        function reverseGeocode(location) {
            const geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                'location': location
            }, function(results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        const namaDaerah = results[0].formatted_address;
                        $("#nama_daerah").val(namaDaerah);
                    }
                }
            });
        }

        function updateMarkerColor() {
            const level = $("#level").val();
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

            if (marker) {
                const iconUrl = `http://maps.google.com/mapfiles/ms/icons/${markerColor}-dot.png`;
                marker.setIcon({
                    url: iconUrl,
                    scaledSize: new google.maps.Size(40, 40),
                });

            }
        }

        $(document).ready(function() {
            initMap();

            // Event listener for level change
            $("#level").change(function() {
                updateMarkerColor();
            });
        });
    </script>
</body>

</html>