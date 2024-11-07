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

// Daftar kolom yang diizinkan untuk sorting
$allowed_columns = ['id', 'nama', 'nip', 'gol', 'posisi'];
$sort_column = isset($_GET['sort']) && in_array($_GET['sort'], $allowed_columns) ? $_GET['sort'] : 'id';

// Menentukan urutan sorting, hanya 'ASC' atau 'DESC' yang diizinkan
$sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

// Cek apakah kolom yang di-sort adalah 'gol' dan gunakan FIELD() untuk sorting custom
if ($sort_column == 'gol') {
    // Urutkan berdasarkan format khusus untuk kolom 'gol'
    $sql = "SELECT * FROM daftar_gtk ORDER BY FIELD(gol, 
        'Pembina Utama / IV/e', 
        'Pembina Utama Madya / IV/d', 
        'Pembina Utama Muda / IV/c', 
        'Pembina Tingkat I / IV/b', 
        'Pembina / IV/a', 
        'Penata Tingkat I / III/d', 
        'Penata / III/c', 
        'Penata Muda Tingkat I / III/b', 
        'Penata Muda / III/a', 
        'Pengatur Tingkat I / II/d', 
        'Pengatur / II/c', 
        'Pengatur Muda Tingkat I / II/b', 
        'Pengatur Muda / II/a', 
        'Juru Tingkat I / I/D', 
        'Juru / I/C', 
        'Juru Muda Tingkat I / I/b', 
        'Juru Muda / I/a', 
        'Ahli Pertama / IX', 
        '') $sort_order";
} else {
    // Query default sorting untuk kolom lain
    $sql = "SELECT * FROM daftar_gtk ORDER BY $sort_column $sort_order";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="">El-Fatras</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/ElFath2">Buat Surat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Daftar GTK</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Kegiatan GTK</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">Data Guru</h2>
        <div class="d-flex justify-content-between mb-3">
            <a href="tambah_guru.php" class="btn btn-primary">Tambah Guru</a>
            <!-- Tombol Print Absensi Guru -->
            <a href="print_absensi.php" target="_blank" class="btn btn-success">Print Absensi Guru</a>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><a href="?sort=id&order=<?php echo $sort_order == 'ASC' ? 'desc' : 'asc'; ?>" style="text-decoration: none; color: black;">No</a></th>
                    <th><a href="?sort=nama&order=<?php echo $sort_order == 'ASC' ? 'desc' : 'asc'; ?>" style="text-decoration: none; color: black;">Nama</a></th>
                    <th><a href="?sort=nip&order=<?php echo $sort_order == 'ASC' ? 'desc' : 'asc'; ?>" style="text-decoration: none; color: black;">NIP</a></th>
                    <th><a href="?sort=gol&order=<?php echo $sort_order == 'ASC' ? 'desc' : 'asc'; ?>" style="text-decoration: none; color: black;">Golongan</a></th>
                    <th><a href="?sort=posisi&order=<?php echo $sort_order == 'ASC' ? 'desc' : 'asc'; ?>" style="text-decoration: none; color: black;">Jabatan</a></th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Menampilkan data dari hasil query
                if (mysqli_num_rows($result) > 0) {
                    $no = 1; // Inisialisasi variabel nomor
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $no . "</td>"; // Menampilkan nomor
                        echo "<td>" . $row['nama'] . "</td>";
                        echo "<td>" . $row['nip'] . "</td>";
                        echo "<td>" . $row['gol'] . "</td>";
                        echo "<td>" . $row['posisi'] . "</td>";
                        echo "<td>
                                <a href='edit_guru.php?id=" . $row['id'] . "' class='btn btn-warning'>Edit</a>
                                <a href='hapus_guru.php?id=" . $row['id'] . "' class='btn btn-danger'>Hapus</a>
                            </td>";
                        echo "</tr>";
                        $no++; // Increment nomor
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>Tidak ada data guru</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Script Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Menutup koneksi
mysqli_close($conn);
?>
