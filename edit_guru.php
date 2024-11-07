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

// Cek apakah id diberikan dan valid
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
} else {
    die("ID tidak valid.");
}

// Mengambil data guru berdasarkan id
$sql = "SELECT * FROM daftar_gtk WHERE id='$id'";
$result = mysqli_query($conn, $sql);
$guru = mysqli_fetch_assoc($result);

// Memproses form ketika disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengamankan input
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $nip = mysqli_real_escape_string($conn, $_POST['nip']);
    $gol = mysqli_real_escape_string($conn, $_POST['gol']);
    $posisi = mysqli_real_escape_string($conn, $_POST['posisi']);

    // Query update data guru
    $sql_update = "UPDATE daftar_gtk SET nama='$nama', nip='$nip', gol='$gol', posisi='$posisi' WHERE id='$id'";

    if (mysqli_query($conn, $sql_update)) {
        header("Location: tabel_guru.php");
        exit(); // Pastikan skrip berhenti setelah redirect
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
    <title>Edit Data Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Edit Data Guru</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($guru['nama']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="nip" class="form-label">NIP</label>
                <input type="text" class="form-control" id="nip" name="nip" value="<?php echo htmlspecialchars($guru['nip']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="gol" class="form-label">Golongan</label>
                <input type="text" class="form-control" id="gol" name="gol" value="<?php echo htmlspecialchars($guru['gol']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="posisi" class="form-label">Jabatan</label>
                <input type="text" class="form-control" id="posisi" name="posisi" value="<?php echo htmlspecialchars($guru['posisi']); ?>" required>
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
