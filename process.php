<?php
// Memasukkan PHPWord ke dalam proyek
require_once 'vendor/autoload.php';

use PhpOffice\PhpWord\TemplateProcessor;

// Koneksi ke database
require_once 'database.php';

// Memeriksa apakah form sudah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pastikan file template ada
    $templateFile = 'template/template.docx';
    if (!file_exists($templateFile)) {
        die("File template tidak ditemukan!");
    }

    // Mengambil data dari form
    $nama = $_POST['nama'];

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

    // Mengambil data dari form
    $suratdari = $_POST['surat_dari'];
    $nomorsurat = $_POST['nomor_surat'];
    $tanggalsurat = $_POST['tanggal_dasarsurat'];
    $perihal = $_POST['perihal'];
    $tempatTujuan = $_POST['tempat_tujuan'];
    $waktuMulai = $_POST['waktu_mulai'] . ' WIB';
    $maksudPerjalanan = $_POST['maksud_perjalanan'] . ' ' . $_POST['maksud_perjalanan_keterangan'];
    $maksudPerjalananKeterangan = $_POST['maksud_perjalanan_keterangan'];

    // Memeriksa apakah waktu mulai dan waktu berakhir sama atau tidak
    $waktuBerakhir = ($_POST['waktu_mulai'] == $_POST['waktu_berakhir'] || empty($_POST['waktu_berakhir']))
        ? 'selesai' // Jika waktu berakhir kosong atau sama dengan waktu mulai
        : $_POST['waktu_berakhir'] . ' WIB'; // Jika tidak, tambahkan WIB

    $berangkat = $_POST['tanggal_berangkat'];
    $kembali = $_POST['tanggal_pulang'];

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

    // Menentukan format NIP berdasarkan golongan
    $ni = ($golongan == "") ? "" : (($golongan == "Ahli Pertama / IX") ? "NI PPPK. " : "NIP. ");
    $nip = ($nip == "") ? "-" : $nip;
    $golongan = ($golongan == "") ? "-" : $golongan;
    $nip2 = "$ni$nip";

    // Menginisialisasi TemplateProcessor
    $templateProcessor = new TemplateProcessor($templateFile);

    // Mengisi variabel di dalam template
    $templateProcessor->setValue('surat_dari', $suratdari);
    $templateProcessor->setValue('nomor_surat', $nomorsurat);
    $templateProcessor->setValue('tanggal_dasarsurat', tanggal_indonesia($tanggalsurat));
    $templateProcessor->setValue('perihal', $perihal);
    $templateProcessor->setValue('nama', $nama);
    $templateProcessor->setValue('nip', $nip);
    $templateProcessor->setValue('nip2', $nip2);
    $templateProcessor->setValue('golongan', $golongan);
    $templateProcessor->setValue('jabatan', $jabatan);
    $templateProcessor->setValue('maksud_perjalanan', $maksudPerjalanan);
    $templateProcessor->setValue('maksud_perjalanan_keterangan', $maksudPerjalananKeterangan);
    $templateProcessor->setValue('tempat_tujuan', $tempatTujuan);
    $templateProcessor->setValue('tanggal_undangan', $tanggalUndangan);
    $templateProcessor->setValue('waktu_mulai', $waktuMulai);
    $templateProcessor->setValue('waktu_berakhir', $waktuBerakhir);
    $templateProcessor->setValue('tanggal_berangkat', tanggal_indonesia($berangkat));
    $templateProcessor->setValue('tanggal_pulang', tanggal_indonesia($kembali));
    $templateProcessor->setValue('hari', $hari);
    $templateProcessor->setValue('hari_undangan', $hariUndangan);

    // Menyimpan file hasil yang sudah diisi
    $namaArray = explode(",", $nama); 
    $outputFile = 'Surat Perintah Tugas ' . $maksudPerjalananKeterangan . ' a.n ' . trim($namaArray[0]) . '.docx';
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
