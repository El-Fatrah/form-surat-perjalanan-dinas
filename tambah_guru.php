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

// Memproses form ketika disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $nip = $_POST['nip'];
    $gol = $_POST['gol'];
    $posisi = $_POST['posisi'];

    // Query untuk menambahkan data guru baru
    $sql = "INSERT INTO daftar_gtk (nama, nip, gol, posisi) VALUES ('$nama', '$nip', '$gol', '$posisi'  )";

    if (mysqli_query($conn, $sql)) {
        echo "Data guru berhasil ditambahkan.";
        header("Location: tabel_guru.php");
        exit; // Pastikan untuk keluar setelah header
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Tambah Data Guru</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="mb-3">
                <label for="nip" class="form-label">NIP</label>
                <input type="text" class="form-control" id="nip" name="nip" required>
            </div>
            <div class="mb-3">
                <label for="gol" class="form-label">Golongan</label>
                <input type="text" class="form-control" id="gol" name="gol" required>
            </div>
            <div class="mb-3">
                <label for="posisi" class="form-label">Jabatan</label>
                <input type="text" class="form-control" id="posisi" name="posisi" required>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="tabel_guru.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>

<?php
// Menutup koneksi
mysqli_close($conn);
?>
