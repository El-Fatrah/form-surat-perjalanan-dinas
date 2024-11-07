<form method="POST" action="process2.php">
    <input type="hidden" name="form_type" value="form2">

    <div class="mb-3">
        <label for="surat_dari2" class="form-label">Surat Dari:</label>
        <input type="text" class="form-control" id="surat_dari2" name="surat_dari" placeholder="Masukkan asal surat" required>
    </div>

    <div class="mb-3">
        <label for="nomor_surat2" class="form-label">Nomor Surat:</label>
        <input type="text" class="form-control" id="nomor_surat2" name="nomor_surat" placeholder="Masukkan nomor surat" required>
    </div>

    <div class="mb-3">
        <label for="tanggal_dasarsurat2" class="form-label">Tanggal Surat:</label>
        <input type="date" class="form-control" id="tanggal_dasarsurat2" name="tanggal_dasarsurat" required>
    </div>

    <div class="mb-3">
        <label for="perihal2" class="form-label">Perihal Surat:</label>
        <input type="text" class="form-control" id="perihal2" name="perihal" placeholder="Masukkan perihal surat" required>
    </div>

    <div class="mb-3">
        <label for="nama2" class="form-label">Nama:</label>
        <input type="text" class="form-control" id="nama2" name="nama" placeholder="Masukkan nama pelaksana tugas" required>
    </div>

    <div class="mb-3">
        <label for="jabatan2" class="form-label">Jabatan :</label>
        <input type="text" class="form-control" id="jabatan2" name="jabatan" placeholder="Masukkan jabatannya" required>
    </div>

    <div class="mb-3">
        <label for="maksud_perjalanan2" class="form-label">Maksud Perjalanan:</label>
        <input type="text" class="form-control" id="maksud_perjalanan2" name="maksud_perjalanan" placeholder="Masukkan maksud perjalanan" required>
    </div>

    <div class="mb-3">
        <label for="tempat_tujuan2" class="form-label">Tempat Tujuan:</label>
        <input type="text" class="form-control" id="tempat_tujuan2" name="tempat_tujuan" placeholder="Masukkan tempat tujuan" required>
    </div>

    <!-- Waktu Mulai dan Berakhir -->
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="waktu_mulai2" class="form-label">Waktu Mulai:</label>
            <input type="text" class="form-control" id="waktu_mulai2" name="waktu_mulai" placeholder="Masukkan waktu mulai" required>
        </div>
        <div class="col-md-6">
            <label for="waktu_berakhir2" class="form-label">Waktu Berakhir:</label>
            <input type="text" class="form-control" id="waktu_berakhir2" name="waktu_berakhir" placeholder="Masukkan waktu berakhir" required>
        </div>
    </div>

    <div class="mb-3">
        <label for="tanggal_berangkat2" class="form-label">Tanggal Berangkat:</label>
        <input type="date" class="form-control" id="tanggal_berangkat2" name="tanggal_berangkat" required>
    </div>

    <div class="mb-3">
        <label for="tanggal_pulang2" class="form-label">Tanggal Pulang:</label>
        <input type="date" class="form-control" id="tanggal_pulang2" name="tanggal_pulang" required>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-primary btn-lg w-100">Buat Surat Tugas</button>
    </div>
</form>