<?php
$servername = "localhost";
$database   = "smpn4sda";
$username   = "root";
$password   = "";

// Membuat koneksi
$conn = mysqli_connect($servername, $username, $password, $database);

// Memeriksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>