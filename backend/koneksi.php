<?php
$server = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'banjirin';
$conn = new mysqli($server, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
