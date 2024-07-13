<?= $this->extend('admin/layout/main'); ?>
<?= $this->section('content'); ?>

<div class="container">
    <div class="page-inner">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title mb-0">Detail Projek</div>
            </div>
            <div class="card-body">

                <?php if (session()->has('error')) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->has('success')) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('info')) : ?>
                    <div class="alert alert-info"><?= session()->getFlashdata('info') ?></div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td><strong>Nama Pendaftar</strong></td>
                                <td colspan="2"><?= esc($pendaftar['nama_pendaftar']) ?></td>

                            </tr>
                            <tr>
                                <td><strong>Judul Projek</strong></td>
                                <td><?= esc($projek['judul_projek']) ?></td>

                            </tr>
                            <tr>
                                <td><strong>Nama Paket</strong></td>
                                <!-- <td>
                                    <div class="form-group">
                                        <select class="form-control" id="id_paket" name="id_paket">
                                            <?php foreach ($all_pakets as $p) : ?>
                                                <option value="<?= $p['id_paket']; ?>" <?= ($p['id_paket'] == $projek['id_paket']) ? 'selected' : '' ?>>
                                                    <?= $p['nama_paket']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </td> -->
                                <td><?= esc($paket['nama_paket']) ?></td>

                            </tr>
                            <tr>
                                <td><strong>Detail Paket</strong></td>
                                <td><?= esc($paket['detail_paket']) ?></td>

                            </tr>
                            <tr>
                                <td><strong>Harga Projek</strong></td>
                                <td>
                                    <?= esc($projek['harga_projek']) ?>
                                    <!-- <form action="<?= base_url('admin/editHargaDP/' . $projek['id_projek']) ?>" method="post">
                                        <div class="form-group">
                                            <input type="text" name="harga_projek" class="form-control" id="harga_projek" value="<?= esc($projek['harga_projek']) ?>">
                                        </div> -->
                                </td>

                            </tr>
                            <tr>
                                <td><strong>DP Projek</strong></td>
                                <td>
                                    <?= esc($projek['dp_projek']) ?>
                                    <!-- <div class="form-group">
                                        <input type="text" name="dp_projek" class="form-control" id="dp_projek" value="<?= esc($projek['dp_projek']) ?>">
                                    </div> -->
                                    </form>
                                </td>
                            </tr>

                            <tr>
                                <td><strong>Bukti Pembayaran</strong></td>
                                <td>
                                    <div>
                                        <?php if ($projek['bukti_pembayaran']) : ?>
                                            <img src="<?= base_url('uploads/' . esc($projek['bukti_pembayaran'])) ?>" alt="Bukti Pembayaran" class="img-thumbnail" style="max-width: 300px;">
                                        <?php else : ?>
                                            Tidak ada bukti pembayaran.
                                        <?php endif; ?>
                                    </div>

                                    <div>
                                        <!-- <form action="<?= base_url('admin/uploadBuktiPembayaran') ?>" method="post" enctype="multipart/form-data" class="mt-2">
                                            <input type="hidden" name="projek_id" value="<?= esc($projek['id_projek']) ?>">
                                            <div class="form-group">
                                                <label for="bukti_pembayaran">Upload Bukti Pembayaran</label>
                                                <input type="file" name="bukti_pembayaran" class="form-control-file" id="bukti_pembayaran">
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-2">Upload</button>
                                        </form>
                                        <form action="<?= base_url('admin/deleteBuktiPembayaran/' . $projek['id_projek']) ?>" method="post" class="mt-2">
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form> -->
                                    </div>

                                </td>

                            </tr>

                            <tr>
                                <td><strong>File Projek</strong></td>
                                <td>
                                    <?php if ($projek['file_projek']) : ?>
                                        File: <a href="<?= base_url('uploads/' . esc($projek['file_projek'])) ?>" target="_blank"><?= esc($projek['file_projek']) ?></a>
                                    <?php else : ?>
                                        Tidak ada file projek.
                                    <?php endif; ?>
                                    <!-- <form action="<?= base_url('admin/uploadFileProjek') ?>" method="post" enctype="multipart/form-data" class="mt-2">
                                        <input type="hidden" name="projek_id" value="<?= esc($projek['id_projek']) ?>">
                                        <div class="form-group">
                                            <label for="file_projek">Upload File Projek</label>
                                            <input type="file" name="file_projek" class="form-control-file" id="file_projek">
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-2">Upload</button>
                                    </form>
                                    <form action="<?= base_url('admin/deleteFileProjek/' . $projek['id_projek']) ?>" method="post">
                                        <button type="submit" class="btn btn-danger mt-2">Hapus</button>
                                    </form> -->
                                </td>

                            </tr>
                            <tr>
                                <td><strong>Status Approval</strong></td>
                                <td>
                                    <?php if ($projek['approval'] == 0) : ?>
                                        <span class="badge bg-warning">Belum Disetujui</span>
                                    <?php elseif ($projek['approval'] == 1) : ?>
                                        <span class="badge bg-success">Sudah Disetujui</span>
                                    <?php elseif ($projek['approval'] == 2) : ?>
                                        <span class="badge bg-danger">Tidak Disetujui</span>
                                    <?php else : ?>
                                        Status tidak diketahui
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Username</strong></td>
                                <td>
                                    <form action="<?= base_url('admin/pendaftar/simpan-dan-approve/' . esc($pendaftar['id_pendaftar']) . '/' . esc($projek['id_projek'])) ?>" method="post">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="username" name="username" value="<?= esc(str_replace(' ', '', isset($username) ? $username : $pendaftar['nama_pendaftar'] . $pendaftar['id_pendaftar'])) ?>">
                                        </div>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password" name="password" value="<?= esc(isset($password) ? $password : $default_password) ?>">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button" id="togglePassword"><i class="fa fa-eye"></i></button>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end mt-2">
                                            <button type="submit" class="btn btn-primary mt-3" name="action" value="approve">Setujui Projek</button>
                                        </div>
                                    </form>
                                </td>

                            </tr>
                            <tr>
                                <td><strong>Programmer</strong></td>
                                <td>
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
                                        <div class="d-flex justify-content-end mt-2">
                                            <button type="submit" class="btn btn-primary">Assign</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
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

<!-- <script>
    // Menggunakan event submit pada form
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form[action="<?= base_url('admin/pendaftar/simpan-dan-approve/' . esc($pendaftar['id_pendaftar']) . '/' . esc($projek['id_projek'])) ?>"]');
        const submitButton = form.querySelector('button[type="submit"]');

        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Menghentikan pengiriman form secara default

            Swal.fire({
                title: 'Setujui Projek?',
                text: "Dengan menyetujui projek ini username dan password akan dikirimkan ke pendaftar",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Setujui!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Pastikan nilai tombol tetap "approve"
                    submitButton.value = 'approve';
                    // Lanjutkan dengan pengiriman form
                    form.submit();
                }
            });
        });
    });
</script> -->


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form[action="<?= base_url('admin/assignProgrammer') ?>"]');

        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Menghentikan pengiriman form secara default

            const programmerName = form.querySelector('select[name="programmer_id"] option:checked').textContent.trim();

            Swal.fire({
                title: `Masukkan projek ini ke jobdesk ${programmerName}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Masukkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Lanjutkan dengan pengiriman form
                    form.submit();
                }
            });
        });
    });
</script>

<?= $this->endSection(); ?>