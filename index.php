<?php
// Aktifkan error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Memasukkan PHPWord ke dalam proyek
require_once 'vendor/autoload.php';
// Koneksi ke database
require_once 'database.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Data Surat</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="style.css" rel="stylesheet">
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
                        <a class="nav-link active" aria-current="page" href="#">Buat Surat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/ElFath2/tabel_guru.php">Daftar GTK</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Kegiatan GTK</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="header-form">
                        <h2>Form Input Data Surat</h2>
                    </div>
                    <div class="card-body p-4">
                        <!-- Navigasi Tab -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="form1-tab" data-bs-toggle="tab" href="#form1" role="tab" aria-controls="form1" aria-selected="true">Surat Tugas GTK</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="form2-tab" data-bs-toggle="tab" href="#form2" role="tab" aria-controls="form2" aria-selected="false">Surat Tugas non-GTK</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="form3-tab" data-bs-toggle="tab" href="#form3" role="tab" aria-controls="form3" aria-selected="false">SPPD Saja</a>
                            </li>
                        </ul>

                        <!-- Konten Tab -->
                        <div class="tab-content" id="myTabContent">
                            <!-- Form 1 -->
                            <div class="tab-pane fade show active" id="form1" role="tabpanel" aria-labelledby="form1-tab">
                                <?php include 'form1.php'; ?>
                            </div>

                            <!-- Form 2 -->
                            <div class="tab-pane fade" id="form2" role="tabpanel" aria-labelledby="form2-tab">
                                <?php include 'form2.php'; ?>
                            </div>

                            <!-- Form 3 -->
                            <div class="tab-pane fade" id="form3" role="tabpanel" aria-labelledby="form3-tab">
                                <?php include 'form3.php'; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Inisialisasi Flatpickr -->
    <script>
        flatpickr("#waktu_mulai", { enableTime: true, noCalendar: true, dateFormat: "H.i", time_24hr: true });
        flatpickr("#waktu_berakhir", { enableTime: true, noCalendar: true, dateFormat: "H.i", time_24hr: true });
        flatpickr("#waktu_mulai2", { enableTime: true, noCalendar: true, dateFormat: "H.i", time_24hr: true });
        flatpickr("#waktu_berakhir2", { enableTime: true, noCalendar: true, dateFormat: "H.i", time_24hr: true });
    </script>
</body>
</html>

<?php
// Menutup koneksi
mysqli_close($conn);
?>
