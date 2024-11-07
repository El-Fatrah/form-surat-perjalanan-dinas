<?php
// Aktifkan error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Koneksi ke database
$servername = "localhost";
$database = "smpn4sda";
$username = "root";
$password = "";

// Membuat koneksi
$conn = mysqli_connect($servername, $username, $password, $database);

// Memeriksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Menghapus data guru berdasarkan id
$id = $_GET['id'];
$sql = "DELETE FROM daftar_gtk WHERE id='$id'";

if (mysqli_query($conn, $sql)) {
    echo "Data berhasil dihapus.";
    header("Location: tabel_guru.php");
} else {
    echo "Error: " . mysqli_error($conn);
}

// Menutup koneksi
mysqli_close($conn);
?>
