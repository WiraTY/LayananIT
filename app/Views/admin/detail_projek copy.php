<?= $this->extend('admin/layout/main'); ?>
<?= $this->section('content'); ?>

<div class="container">
    <div class="page-inner">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title mb-0">Detail Projek</div>
            </div>
            <div class="card-body">
                <!-- <h5 class="card-title"><?= esc($projek['judul_projek']) ?></h5> -->
                <p class="card-text"><strong>Nama Pendaftar:</strong> <?= esc($pendaftar['nama_pendaftar']) ?></p>
                <p class="card-text"><strong>Judul Projek:</strong> <?= esc($projek['judul_projek']) ?></p>
                <p class="card-text"><strong>Nama Paket:</strong> <?= esc($paket['nama_paket']) ?></p>
                <p class="card-text"><strong>Detail Paket:</strong> <?= esc($paket['detail_paket']) ?></p>

                <form action="<?= base_url('admin/editHargaDP/' . $projek['id_projek']) ?>" method="post">
                    <div class="form-group">
                        <label for="harga_projek">Harga Projek</label>
                        <input type="text" name="harga_projek" class="form-control" id="harga_projek" value="<?= esc($projek['harga_projek']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="dp_projek">DP Projek</label>
                        <input type="text" name="dp_projek" class="form-control" id="dp_projek" value="<?= esc($projek['dp_projek']) ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>

                <p class="card-text"><strong>Bukti Pembayaran:</strong></p>
                <?php if ($projek['bukti_pembayaran']) : ?>
                    <img src="<?= base_url('uploads/' . esc($projek['bukti_pembayaran'])) ?>" alt="Bukti Pembayaran" class="img-thumbnail">
                    <form action="<?= base_url('admin/deleteBuktiPembayaran/' . $projek['id_projek']) ?>" method="post" class="mt-2">
                        <button type="submit" class="btn btn-danger">Hapus Bukti Pembayaran</button>
                    </form>
                <?php else : ?>
                    <p>Tidak ada bukti pembayaran.</p>
                <?php endif; ?>

                <form action="<?= base_url('admin/uploadBuktiPembayaran') ?>" method="post" enctype="multipart/form-data" class="mt-2">
                    <input type="hidden" name="projek_id" value="<?= esc($projek['id_projek']) ?>">
                    <div class="form-group">
                        <label for="bukti_pembayaran">Upload Bukti Pembayaran</label>
                        <input type="file" name="bukti_pembayaran" class="form-control-file" id="bukti_pembayaran">
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Upload</button>
                </form>

                <p class="card-text"><strong>File Projek:</strong></p>

                <?php if ($projek['file_projek']) : ?>
                    <p>File: <a href="<?= base_url('uploads/' . esc($projek['file_projek'])) ?>" target="_blank"><?= esc($projek['file_projek']) ?></a></p>
                    <form action="<?= base_url('admin/deleteFileProjek/' . $projek['id_projek']) ?>" method="post">
                        <button type="submit" class="btn btn-danger">Hapus File Projek</button>
                    </form>
                <?php else : ?>
                    <p>Tidak ada file projek.</p>
                <?php endif; ?>

                <form action="<?= base_url('admin/uploadFileProjek') ?>" method="post" enctype="multipart/form-data" class="mt-2">
                    <input type="hidden" name="projek_id" value="<?= esc($projek['id_projek']) ?>">
                    <div class="form-group">
                        <label for="file_projek">Upload File Projek</label>
                        <input type="file" name="file_projek" class="form-control-file" id="file_projek">
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Upload</button>
                </form>

                <p class="card-text"><strong>Status Approval:</strong>
                    <?php if ($projek['approval'] == 0) : ?>
                        <span class="badge badge-warning">Belum Disetujui</span>
                    <?php elseif ($projek['approval'] == 1) : ?>
                        <span class="badge badge-success">Sudah Disetujui</span>
                    <?php elseif ($projek['approval'] == 2) : ?>
                        <span class="badge badge-danger">Tidak Disetujui</span>
                    <?php else : ?>
                        Status tidak diketahui
                    <?php endif; ?>
                </p>
                <!-- 
                <form action="<?= base_url('admin/kirimEmail/' . $projek['id_projek']) ?>" method="post" class="mt-3">
                    <button type="submit" class="btn btn-success">Kirim Email</button>
                </form>

                <form action="<?= base_url('admin/sendWhatsAppMessage/' . $projek['id_projek']) ?>" method="post">
                    <button type="submit">Kirim WhatsApp</button>
                </form> -->

                <form action="<?= base_url('admin/pendaftar/simpan-dan-approve/' . esc($pendaftar['id_pendaftar']) . '/' . esc($projek['id_projek'])) ?>" method="post">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?= esc(str_replace(' ', '', isset($username) ? $username : $pendaftar['nama_pendaftar'] . $pendaftar['id_pendaftar'])) ?>">
                    </div>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" value="<?= esc(isset($password) ? $password : $default_password) ?>">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword"><i class="fa fa-eye"></i></button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success" name="action" value="approve">Setujui Projek</button>
                </form>

                <p class="card-text"><strong>Programmer:</strong></p>
                <form action="<?= base_url('admin/assignProgrammer') ?>" method="post">
                    <input type="hidden" name="projek_id" value="<?= esc($projek['id_projek']) ?>">
                    <select name="programmer_id" class="form-control">
                        <option value="">-- Pilih Programmer --</option>
                        <?php foreach ($programmers as $programmer) : ?>
                            <option value="<?= esc($programmer['id']) ?>" <?= ($programmer['id'] == $selected_programmer_id) ? 'selected' : '' ?>>
                                <?= esc($programmer['username']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-primary mt-2">Assign</button>
                </form>


                <a href="<?= base_url('admin/pendaftar') ?>" class="btn btn-primary mt-3">Kembali</a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    });
</script>

<?= $this->endSection(); ?>