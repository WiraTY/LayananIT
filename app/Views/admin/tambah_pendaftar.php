<?= $this->extend('admin/layout/main'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="page-inner">
        <div class="card">
            <div class="card-header">
                Tambah Pendaftar
            </div>
            <div class="card-body">
                <form action="<?= base_url('admin/pendaftar/simpan') ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nama">Nama Pendaftar</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" required>
                    </div>
                    <div class="form-group">
                        <label for="telp">Nomor Telepon</label>
                        <input type="text" class="form-control" id="telp" name="telp" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <!-- Dropdown untuk memilih paket -->
                    <div class="form-group">
                        <label for="id_paket">Pilih Paket</label>
                        <select class="form-control" id="id_paket" name="id_paket">
                            <option value="">-- Pilih Paket --</option>
                            <?php foreach ($paket as $p) : ?>
                                <option value="<?= $p['id_paket']; ?>">
                                    <?= $p['nama_paket']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Input untuk harga -->
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="number" class="form-control" id="harga" name="harga" placeholder="Harga">
                    </div>

                    <!-- Input untuk bukti transfer -->
                    <div class="form-group">
                        <label for="uploadBukti">BUKTI TRANSFER PEMBAYARAN</label>
                        <input class="form-control mb-2" type="file" id="uploadBukti" name="uploadBukti">
                    </div>

                    <!-- Input untuk nominal pembayaran DP -->
                    <div class="form-group">
                        <label for="dp">Nominal pembayaran DP</label>
                        <input type="number" class="form-control" id="dp" name="dp" placeholder="Nominal pembayaran DP">
                    </div>

                    <!-- Input untuk judul dan upload proposal -->
                    <div class="form-group">
                        <label for="judul">Judul</label>
                        <textarea type="text" class="form-control" id="judul" name="judul" placeholder="Judul"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="uploadFile">Upload Proposal yang telah disetujui (jika ada)</label>
                        <input class="form-control mb-2" type="file" id="uploadFile" name="uploadFile">
                        <p class="card-text mb-2">File type (docx, pdf, excel, atau rar jika lebih dari satu)</p>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>