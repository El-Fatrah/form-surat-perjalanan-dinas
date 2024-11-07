<?php
require('fpdf.php');

// Membuat koneksi ke database
$servername = "localhost";
$database = "smpn4sda";
$username = "root";
$password = "";
$conn = mysqli_connect($servername, $username, $password, $database);

// Periksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Query data guru
$sql = "SELECT * FROM daftar_gtk";
$result = mysqli_query($conn, $sql);

// Periksa apakah query berhasil
if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}

// Fungsi untuk menambahkan kop surat
function HeaderPDF($pdf) {
    // Logo
    $pdf->Image('logo.png', 20, 11, 32); // Ganti 'logo.png' ke lokasi logo Anda
    $pdf->SetFont('Arial', '', 14); // Ukuran font lebih kecil
    
    // Mengatur posisi kursor ke kanan
    $pdf->SetX(25); // Geser ke kanan (misalnya 20)
    $pdf->Cell(0, 6, 'PEMERINTAH KABUPATEN SIDOARJO', 0, 1, 'C'); 
    $pdf->Ln(1); 
    $pdf->SetFont('Arial', 'B', 14);
    
    $pdf->SetX(25); // Geser ke kanan
    $pdf->Cell(0, 6, 'DINAS PENDIDIKAN DAN KEBUDAYAAN', 0, 1, 'C'); 
    $pdf->Ln(1); 
    $pdf->SetFont('Arial', 'B', 18);
    
    $pdf->SetX(25); // Geser ke kanan
    $pdf->Cell(0, 6, 'SMP NEGERI 4 SIDOARJO', 0, 1, 'C'); 
    $pdf->Ln(1); 
    $pdf->SetFont('Arial', '', 10);
    
    $pdf->SetX(25); // Geser ke kanan
    $pdf->Cell(0, 5, 'Jalan Suko Telp. 031 8963734 Sidoarjo 61224', 0, 1, 'C'); 
    $pdf->Ln(1); 
    $pdf->SetX(25); // Geser ke kanan
    $pdf->Cell(0, 5, 'Email: smpn4sidoarjo1@gmail.com Website: www.smpn4sda.sch.id', 0, 1, 'C'); 
    $pdf->SetLineWidth(1);
    $pdf->Ln(2);
    $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY()); // Menggambar garis dari kiri ke kanan
    $pdf->Ln(6); 
}

// Membuat objek FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetMargins(10, 10, 10); // Set margin kiri, atas, dan kanan

// Panggil fungsi untuk menambahkan kop surat
HeaderPDF($pdf);
$pdf->SetLineWidth(0.2); 

// Judul
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 6, 'Daftar Absensi Guru', 0, 1, 'C');
$pdf->Ln(3); // Jarak sebelum header tabel

// Header tabel
$pdf->SetFont('Arial', 'B', 10); // Ukuran font lebih kecil
$pdf->Cell(10, 8, 'No', 1, 0, 'C');
$pdf->Cell(65, 8, 'Nama', 1, 0, 'C');
$pdf->Cell(40, 8, 'NIP', 1, 0, 'C'); 
$pdf->Cell(40, 8, 'Jabatan', 1, 0, 'C'); 
$pdf->Cell(35, 8, 'TTD', 1, 1, 'C'); 

// Isi tabel
$pdf->SetFont('Arial', '', 10); // Ukuran font lebih kecil
$no = 1;

while ($row = mysqli_fetch_assoc($result)) {
    $pdf->Cell(10, 8, $no . '.', 1, 0, 'C'); // Menambahkan titik setelah nomor
    
    // Cell untuk Nama (rata kiri)
    $pdf->Cell(65, 8, $row['nama'], 1, 0, 'L'); 
    
    // Cell untuk NIP (rata tengah)
    $pdf->Cell(40, 8, $row['nip'], 1, 0, 'C'); 

    // Cell untuk Jabatan (rata tengah)
    $pdf->Cell(40, 8, $row['posisi'], 1, 0, 'C'); 

    // Cell untuk TTD dengan nomor ganjil di kiri, genap di tengah
    if ($no % 2 == 1) {
        // Nomor ganjil
        $pdf->Cell(35, 8, $no . '.', 1, 1, 'L'); // Kosong untuk tanda tangan ganjil
    } else {
        // Nomor genap
        $pdf->Cell(35, 8, $no . '.', 1, 1, 'C'); // Kosong untuk tanda tangan genap
    }

    $no++; // Increment nomor
}

// Output file PDF sebagai preview di browser
$pdf->Output('I');

// Menutup koneksi
mysqli_close($conn);
?>
