<form method="POST" action="process.php">
    <input type="hidden" name="form_type" value="form1">

    <div class="mb-3">
        <label for="surat_dari" class="form-label">Surat Dari:</label>
        <input type="text" class="form-control" id="surat_dari" name="surat_dari" placeholder="Masukkan asal surat" required>
    </div>

    <div class="mb-3">
        <label for="nomor_surat" class="form-label">Nomor Surat:</label>
        <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" placeholder="Masukkan nomor surat" required>
    </div>

    <div class="mb-3">
        <label for="tanggal_dasarsurat" class="form-label">Tanggal Surat:</label>
        <input type="date" class="form-control" id="tanggal_dasarsurat" name="tanggal_dasarsurat" required>
    </div>

    <div class="mb-3">
        <label for="perihal" class="form-label">Perihal Surat:</label>
        <input type="text" class="form-control" id="perihal" name="perihal" placeholder="Masukkan perihal surat" required>
    </div>

    <div class="mb-3">
        <label for="nama" class="form-label">Nama:</label>
        <select name="nama" class="form-select" required>
            <?php
                $query = mysqli_query($conn, "SELECT * FROM daftar_gtk ORDER BY nama");
                while ($data = mysqli_fetch_array($query)) {
                    echo "<option value=\"" . htmlspecialchars($data['nama']) . "\">" . htmlspecialchars($data['nama']) . "</option>";
                }
            ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="maksud_perjalanan" class="form-label">Maksud Perjalanan:</label>
        <div class="d-flex">
            <div class="form-check me-3">
                <input class="form-check-input" type="radio" id="mengikuti_kegiatan" name="maksud_perjalanan" value="mengikuti kegiatan">
                <label class="form-check-label" for="mengikuti_kegiatan">Mengikuti Kegiatan</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" id="mendampingi_siswa" name="maksud_perjalanan" value="mendampingi siswa pada kegiatan">
                <label class="form-check-label" for="mendampingi_siswa">Mendampingi Siswa pada Kegiatan</label>
            </div>
        </div>
        <input type="text" class="form-control mt-2" id="maksud_perjalanan_keterangan" name="maksud_perjalanan_keterangan" placeholder="Masukkan keterangan lain" required>
    </div>


    <div class="mb-3">
        <label for="tempat_tujuan" class="form-label">Tempat Tujuan:</label>
        <input type="text" class="form-control" id="tempat_tujuan" name="tempat_tujuan" placeholder="Masukkan tempat tujuan" required>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="waktu_mulai" class="form-label">Waktu Mulai:</label>
            <input type="text" class="form-control" id="waktu_mulai" name="waktu_mulai" placeholder="Masukkan waktu mulai" required>
        </div>
        <div class="col-md-6">
            <label for="waktu_berakhir" class="form-label">Waktu Berakhir:</label>
            <input type="text" class="form-control" id="waktu_berakhir" name="waktu_berakhir" placeholder="Masukkan waktu berakhir" required>
        </div>
    </div>

    <div class="mb-3">
        <label for="tanggal_berangkat" class="form-label">Tanggal Berangkat:</label>
        <input type="date" class="form-control" id="tanggal_berangkat" name="tanggal_berangkat" required>
    </div>

    <div class="mb-3">
        <label for="tanggal_pulang" class="form-label">Tanggal Pulang:</label>
        <input type="date" class="form-control" id="tanggal_pulang" name="tanggal_pulang" required>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-primary btn-lg w-100">Buat Surat Tugas</button>
    </div>
</form>