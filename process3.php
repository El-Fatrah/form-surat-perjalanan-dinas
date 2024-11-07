<?php
// Memasukkan PHPWord ke dalam proyek
require_once 'vendor/autoload.php';

use PhpOffice\PhpWord\TemplateProcessor;

// Koneksi ke database
require_once 'database.php'; 

// Memeriksa apakah form sudah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $templateFile = 'template/template3.docx';
    if (!file_exists($templateFile)) {
        die("File template tidak ditemukan!");
    }

    // Mengambil dan memvalidasi data dari form
    $nama = $_POST['nama'];
    $maksudPerjalanan = mysqli_real_escape_string($conn, $_POST['maksud_perjalanan']);
    $tempatTujuan = mysqli_real_escape_string($conn, $_POST['tempat_tujuan']);
    $berangkat = mysqli_real_escape_string($conn, $_POST['tanggal_berangkat']);
    $kembali = mysqli_real_escape_string($conn, $_POST['tanggal_pulang']);

    // Menggunakan prepared statement untuk query
    $stmt = $conn->prepare("SELECT * FROM daftar_gtk WHERE nama=?");
    $stmt->bind_param("s", $nama);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        die("Data pegawai tidak ditemukan!");
    }

    // Mengambil data dari hasil query
    $tpeg = $result->fetch_assoc();
    $nip = $tpeg['nip'];
    $golongan = $tpeg['gol'];
    $jabatan = $tpeg['posisi'];

    // Menentukan format NIP berdasarkan golongan
    $ni = ($golongan == "") ? "-" : (($golongan == "Ahli Pertama / IX") ? "NI PPPK. " : "NIP. ");

    // Menghitung jumlah hari perjalanan
    $tgl1 = strtotime($berangkat);
    $tgl2 = strtotime($kembali);
    $hari = (($tgl2 - $tgl1) / 86400) + 1;

    // Fungsi untuk memformat tanggal ke format Indonesia
    function tanggal_indonesia($tanggal, $format = 'dmy') {
        $bulan = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        $pecahkan = explode('-', $tanggal);
        
        // Jika format 'dmy', kembalikan "Tanggal Bulan Tahun"
        if ($format === 'm') {
            return $bulan[(int)$pecahkan[1]];
        }
        // Jika format 'dm', kembalikan "Tanggal Bulan"
        else if ($format === 'dm') {
            return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]];
        }
        
        return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
    }

    // Konversi hari berangkat dan pulang ke dalam bahasa Indonesia
    $hariIndonesia = [
        'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
    ];
    $hariBerangkat = $hariIndonesia[date('l', $tgl1)];
    $hariPulang = $hariIndonesia[date('l', $tgl2)];


    // Format tanggal berangkat dan pulang
    if ($tgl1 == $tgl2) {
        $tanggalUndangan = tanggal_indonesia(date('Y-m-d', $tgl1));
        $hariUndangan = $hariBerangkat;
    } else {
        if (tanggal_indonesia(date('Y-m-d', $tgl1), 'm') == tanggal_indonesia(date('Y-m-d', $tgl2), 'm')) {
            $tanggalUndangan = date('d', $tgl1) . ' - ' . tanggal_indonesia(date('Y-m-d', $tgl2));
            $hariUndangan = $hariBerangkat . ' - ' . $hariPulang;
        } else {
            $tanggalUndangan = tanggal_indonesia(date('Y-m-d', $tgl1), 'dm') . ' - ' . tanggal_indonesia(date('Y-m-d', $tgl2));
            $hariUndangan = $hariBerangkat . ' - ' . $hariPulang;
        }
    }
    
    // Penggabungan NIP dan penomoran surat
    $nip2 = "$ni$nip";

    // Menginisialisasi TemplateProcessor
    $templateProcessor = new TemplateProcessor($templateFile);

    // Mengisi variabel di dalam template
    $templateProcessor->setValue('maksud_perjalanan', $maksudPerjalanan);
    $templateProcessor->setValue('tempat_tujuan', $tempatTujuan);
    $templateProcessor->setValue('tanggal_berangkat', tanggal_indonesia($berangkat));
    $templateProcessor->setValue('tanggal_pulang', tanggal_indonesia($kembali));
    $templateProcessor->setValue('tanggal_surat', tanggal_indonesia(date('Y-m-d')));    
    $templateProcessor->setValue('hari', $hari);
    $templateProcessor->setValue('hari_undangan', $hariUndangan);
    $templateProcessor->setValue('nama', $nama);
    $templateProcessor->setValue('nip', $nip);
    $templateProcessor->setValue('nip2', $nip2);
    $templateProcessor->setValue('golongan', $golongan);
    $templateProcessor->setValue('jabatan', $jabatan);
    
    // Menyimpan file hasil yang sudah diisi
    $outputFile = 'SPPD ' . $maksudPerjalanan . ' a.n ' . trim($nama) . '.docx';
    $templateProcessor->saveAs($outputFile);

    // Menyiapkan file untuk di-download
    header("Content-Description: File Transfer");
    header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
    header("Content-Disposition: attachment; filename=\"" . basename($outputFile) . "\"");
    header("Content-Transfer-Encoding: binary");
    header("Expires: 0");
    header("Cache-Control: must-revalidate");
    header("Pragma: public");
    header("Content-Length: " . filesize($outputFile));

    // Mengirim file ke browser untuk di-download
    readfile($outputFile);

    // Menghapus file sementara setelah di-download
    unlink($outputFile);

    exit;
}
?>
