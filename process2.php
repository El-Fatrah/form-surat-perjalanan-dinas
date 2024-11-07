<?php
// Memasukkan PHPWord ke dalam proyek
require_once 'vendor/autoload.php';

use PhpOffice\PhpWord\TemplateProcessor;

// Memastikan form sudah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pastikan file template ada
    $templateFile = 'template/template2.docx';
    if (!file_exists($templateFile)) {
        die("File template tidak ditemukan!");
    }

    // Mengambil data dari form dan melakukan sanitasi
    $nama = htmlspecialchars(trim($_POST['nama'])); // Nama pelaksana tugas diambil dari input form
    $jabatan = htmlspecialchars(trim($_POST['jabatan'])); // Jabatan diambil dari input form
    $suratdari = htmlspecialchars(trim($_POST['surat_dari']));
    $nomorsurat = htmlspecialchars(trim($_POST['nomor_surat']));
    $tanggalsurat = htmlspecialchars(trim($_POST['tanggal_dasarsurat']));
    $perihal = htmlspecialchars(trim($_POST['perihal']));
    $maksudPerjalanan = htmlspecialchars(trim($_POST['maksud_perjalanan']));
    $tempatTujuan = htmlspecialchars(trim($_POST['tempat_tujuan']));
    
    // Ambil jam mulai dan jam akhir dan tambahkan WIB
    $waktuMulai = htmlspecialchars(trim($_POST['waktu_mulai'])) . ' WIB';
    // Memeriksa apakah waktu mulai dan waktu berakhir sama atau tidak
    if ($_POST['waktu_mulai'] == $_POST['waktu_berakhir'] || empty($_POST['waktu_berakhir'])) {
        $waktuBerakhir = 'selesai'; // Jika waktu berakhir kosong atau sama dengan waktu mulai, atur "selesai"
    } else {
        $waktuBerakhir = $_POST['waktu_berakhir'] . ' WIB'; // Jika tidak, tambahkan WIB
    }

    $berangkat = htmlspecialchars(trim($_POST['tanggal_berangkat']));
    $kembali = htmlspecialchars(trim($_POST['tanggal_pulang']));

    // Menghitung jumlah hari perjalanan
    $tgl1 = strtotime($berangkat);
    $tgl2 = strtotime($kembali);
    $hari = (($tgl2 - $tgl1) / 86400) + 1; // 86400 detik = 1 hari

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


    // Menginisialisasi TemplateProcessor
    $templateProcessor = new TemplateProcessor($templateFile);

    // Mengisi variabel di dalam template
    $templateProcessor->setValue('surat_dari', $suratdari);
    $templateProcessor->setValue('nomor_surat', $nomorsurat);
    $templateProcessor->setValue('tanggal_dasarsurat', tanggal_indonesia($tanggalsurat));
    $templateProcessor->setValue('perihal', $perihal);
    $templateProcessor->setValue('nama', $nama);
    $templateProcessor->setValue('jabatan', $jabatan);
    $templateProcessor->setValue('maksud_perjalanan', $maksudPerjalanan);
    $templateProcessor->setValue('tempat_tujuan', $tempatTujuan);
    $templateProcessor->setValue('tanggal_undangan', $tanggalUndangan);
    
    // Menambahkan pengisian jam mulai dan jam akhir
    $templateProcessor->setValue('waktu_mulai', $waktuMulai);
    $templateProcessor->setValue('waktu_berakhir', $waktuBerakhir);

    $templateProcessor->setValue('tanggal_berangkat', tanggal_indonesia($berangkat));
    $templateProcessor->setValue('tanggal_pulang', tanggal_indonesia($kembali));
    $templateProcessor->setValue('hari', $hari);
    $templateProcessor->setValue('hari_undangan', $hariUndangan);

    // Menyimpan file hasil yang sudah diisi
    $outputFile = 'Surat Perintah Tugas ' . $maksudPerjalanan . ' a.n ' . trim($nama) . '.docx';
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
