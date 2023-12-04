<?php
session_start();
include '../../backend/koneksi.php';
$sqld = "SELECT * FROM banjir";
$resultd = mysqli_query($conn, $sqld);
$rowd = mysqli_fetch_assoc($resultd);
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
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>

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
            <div class="container-fluid py-4">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Data Lokasi Banjir</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div id="map-container">
                                <div id="google-map" style="height: 500px"></div>
                            </div>
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Daerah</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Longitude</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Latitude</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Level</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Radius (M)</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $sqld = "SELECT * FROM banjir";
                                        $resultd = mysqli_query($conn, $sqld);

                                        if ($resultd) {
                                            while ($rowd = mysqli_fetch_assoc($resultd)) {
                                                $id = $rowd['id'];
                                                $nama = $rowd['nama_daerah'];
                                                $longitude = $rowd['longitude'];
                                                $latitude = $rowd['latitude'];
                                                $level = $rowd['level'];
                                                $radius = $rowd['radius'];
                                        ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td><?php echo $nama; ?></td>
                                                    <td class="text-center"><?php echo $longitude; ?></td>
                                                    <td class="text-center"><?php echo $latitude; ?></td>
                                                    <td class="text-center"><?php echo $level; ?></td>
                                                    <td class="text-center"><?php echo $radius; ?></td>
                                                    <td class="text-center">
                                                        <a href="edit.php?id=<?php echo $id; ?>" class="btn btn-warning">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a class="btn btn-danger" href="#" onclick="confirmDelete(<?php echo $id; ?>)"><i class="fas fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        } else {
                                            echo "<tr><td colspan='10'>Tidak ada data.</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <a href="tambah.php" class="btn btn-primary float-end">Tambah Data</a>
                    </div>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
    </main>
    <!--   Core JS Files   -->
    <script src="../../plugins/assets/js/core/popper.min.js"></script>
    <script src="../../plugins/assets/js/core/bootstrap.min.js"></script>
    <script src="../../plugins/assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../../plugins/assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../../plugins/assets/js/material-dashboard.min.js?v=3.1.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: "Apa kamu yakin?",
                text: "Ketika dihapus, Anda tidak dapat mengembalikan data ini!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "hapus.php?id=" + id;
                } else {}
            });
        }
    </script>
    <script>
        var googleMap;
        var markers = [];
        var circles = [];

        function initGoogleMap() {
            googleMap = new google.maps.Map(document.getElementById("google-map"), {
                center: {
                    lat: 0.537488,
                    lng: 101.448387
                },
                zoom: 15,
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
                    circles.push(circle);
            <?php
                }
            }
            ?>

        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAQqCVzh9CHvZAJrfAoR-mVZD-dZxap2Xo&callback=initGoogleMap&libraries=geometry" async defer></script>
</body>

</html>