<?= $this->extend('programmer/layout/main'); ?>
<?= $this->section('content'); ?>

<div class="container">
    <div class="page-inner">
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
        <style>
            .table {
                border: none;
                /* Menghilangkan border dari tabel */
                border-collapse: collapse;
                /* Menggabungkan garis tepi sel untuk memastikan tidak ada jarak di antara sel */
            }

            .table th,
            .table td {
                border: none;
                /* Menghilangkan border dari sel header dan sel data */
                padding: 8px;
                /* Padding untuk memisahkan isi dari tepi sel */
                text-align: left;
                /* Aligment teks ke kiri */
            }

            textarea[disabled] {
                background-color: #f8f9fa;
                border: none;
            }
        </style>
        <div class="row">
            <div class="col-md-8">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-title">Detail Projek</div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Nama Pendaftar</th>
                                        <th scope="col">Nama Layanan</th>
                                        <th scope="col">Nama Paket</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?= esc($projek['nama_pendaftar']) ?></td>
                                        <td><?= esc($projek['nama_layanan']) ?></td>
                                        <td><?= esc($projek['nama_paket']) ?></td>
                                    </tr>
                                </tbody>
                                <thead>
                                    <tr>
                                        <th scope="col">Detail Projek</th>
                                        <th scope="col">Judul Projek</th>
                                        <th scope="col">File Projek</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?= esc($projek['detail_paket']) ?></td>
                                        <td><?= esc($projek['judul_projek']) ?></td>
                                        <td>
                                            <a href="<?= base_url('uploads/' . esc($projek['file_projek'])) ?>" target="_blank">
                                                <?= esc(substr($projek['file_projek'], 0, 10)) ?>...<?= substr($projek['file_projek'], -4) ?>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                                <thead>
                                    <tr>
                                        <th scope="col">File Progress</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="font-weight: bold;">
                                        <td>File</td>
                                        <td>Deskripsi</td>
                                        <td>Tanggal</td>
                                        <td>Aksi</td>
                                    </tr>
                                    <?php if (!empty($dokumentasi)) : ?>
                                        <?php foreach ($dokumentasi as $file) : ?>
                                            <tr>
                                                <td>
                                                    <a href="<?= base_url('uploads/' . esc($file['file_dokumentasi'])) ?>" target="_blank">
                                                        <?= esc(substr($file['file_dokumentasi'], 0, 10)) ?>...<?= esc(substr($file['file_dokumentasi'], -4)) ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <textarea name="deskripsi_dokumentasi" id="deskripsi_dokumentasi_<?= $file['id_dokumentasi'] ?>" disabled><?= esc($file['deskripsi_dokumentasi']) ?></textarea>
                                                </td>
                                                <td><?= esc($file['tanggal_dokumentasi']) ?></td>
                                                <td class="d-grid gap-2 justify-content-md-center">
                                                    <button type="button" class="btn btn-warning btn-sm" id="editButton_<?= $file['id_dokumentasi'] ?>" onclick="editDeskripsi(<?= $file['id_dokumentasi'] ?>)">Edit</button>
                                                    <form action="<?= base_url('programmer/deleteDokumentasi/' . $file['id_dokumentasi']) ?>" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumentasi ini?');">
                                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="3">Belum ada file progress yang diupload.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Progress Projek</div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <div class="mb-4 mt-2">
                            <p>Progress saat ini <?= isset($progress['progress_projek']) ? $progress['progress_projek'] : '0' ?>%, kurang <?= isset($progress['progress_projek']) ? 100 - $progress['progress_projek'] : 100 ?>%</p>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="<?= isset($progress['progress_projek']) ? $progress['progress_projek'] : 0 ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= isset($progress['progress_projek']) ? $progress['progress_projek'] : 0 ?>%;"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="progress">Tambah Progres dalam (%)</label>
                            <form action="<?= base_url('programmer/simpanProgress/' . $projek['id_projek']) ?>" method="post">
                                <div class="mb-3">
                                    <input type="hidden" id="currentProgress" value="<?= isset($progress['progress_projek']) ? $progress['progress_projek'] : 0 ?>">
                                    <input type="number" id="inputProgress" name="progress" min="1" max="<?= isset($progress['progress_projek']) ? 100 - $progress['progress_projek'] : 100 ?>" placeholder="1 - <?= isset($progress['progress_projek']) ? 100 - $progress['progress_projek'] : 100 ?>" required class="form-control">
                                </div>
                                <button type="submit" class="btn btn-primary">Tambah Progress</button>
                            </form>
                        </div>
                        <div class="pull-in">
                        </div>
                    </div>
                </div>
                <div class="card rounded">
                    <div class="card-body pb-0">
                        <h5 class="card-title">Upload File Progress</h5>
                        <div class="mt-3">
                            <div class="form-group">

                                <form action="<?= base_url('programmer/uploadProgressFile/' . $projek['id_projek']) ?>" method="post" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="file_dokumentasi" class="form-label">File Dokumentasi</label>
                                        <input type="file" name="file_dokumentasi" class="form-control" id="file_dokumentasi" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="deskripsi_dokumentasi" class="form-label">Deskripsi Dokumentasi</label>
                                        <textarea name="deskripsi_dokumentasi" class="form-control" id="deskripsi_dokumentasi" rows="3" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Upload File Progress</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function editDeskripsi(id_dokumentasi) {
        var textarea = document.getElementById('deskripsi_dokumentasi_' + id_dokumentasi);
        var button = document.getElementById('editButton_' + id_dokumentasi);
        var isDisabled = textarea.disabled;
        var originalText = textarea.value;

        textarea.disabled = !isDisabled;

        if (!isDisabled) {
            // If it's currently enabled, then save the changes
            var form = document.createElement('form');
            form.method = 'post';
            form.action = '<?= base_url('programmer/updateDokumentasi') ?>/' + id_dokumentasi;
            var hiddenField = document.createElement('input');
            hiddenField.type = 'hidden';
            hiddenField.name = 'deskripsi_dokumentasi';
            hiddenField.value = textarea.value;
            form.appendChild(hiddenField);
            document.body.appendChild(form);
            form.submit();
        } else {
            // If it's currently disabled, then change button text to "Simpan" and focus the textarea
            button.textContent = "Simpan";
            textarea.focus();
        }

        // Toggle button text
        button.textContent = isDisabled ? "Simpan" : "Edit";

        // Add event listener for the Esc key
        textarea.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                textarea.value = originalText;
                textarea.disabled = true;
                button.textContent = "Edit";
            }
        });
    }
</script>


<?= $this->endSection(); ?>