<form method="POST" action="process3.php">
    <input type="hidden" name="form_type" value="form3">

    <div class="mb-3">
        <label for="nama" class="form-label">Nama:</label>
        <select name="nama" class="form-select" required>
            <?php
                // Query menampilkan nama pegawai ke dalam combobox
                $query = mysqli_query($conn, "SELECT * FROM daftar_gtk ORDER BY nama");
                while ($data = mysqli_fetch_array($query)) {
                    echo "<option value=\"{$data['nama']}\">{$data['nama']}</option>";
                }
            ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="maksud_perjalanan" class="form-label">Maksud Perjalanan:</label>
        <input type="text" class="form-control" id="maksud_perjalanan" name="maksud_perjalanan" placeholder="Masukkan maksud perjalanan" required>
    </div>

    <div class="mb-3">
        <label for="tempat_tujuan" class="form-label">Tempat Tujuan:</label>
        <input type="text" class="form-control" id="tempat_tujuan" name="tempat_tujuan" placeholder="Masukkan tempat tujuan" required>
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
        <button type="submit" class="btn btn-primary btn-lg w-100">Buat SPPD</button>
    </div>
</form>