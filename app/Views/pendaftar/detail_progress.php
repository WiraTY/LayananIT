<?= $this->extend('pendaftar/layout/main-login'); ?>
<?= $this->section('content'); ?>

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

<div class="container">
    <div class="page-inner">
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
                                        <th scope="col">Nama Layanan</th>
                                        <th scope="col">Nama Paket</th>
                                        <th scope="col">Detail Projek</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?= esc($projek['nama_layanan']) ?></td>
                                        <td><?= esc($projek['nama_paket']) ?></td>
                                        <td><?= esc($projek['detail_paket']) ?></td>
                                    </tr>
                                </tbody>
                                <thead>
                                    <tr>
                                        <th scope="col">Judul Projek</th>
                                        <th scope="col">File Projek</th>
                                        <th scope="col">Nama Programmer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?= esc($projek['judul_projek']) ?></td>
                                        <td>
                                            <a href="<?= base_url('uploads/' . esc($projek['file_projek'])) ?>" target="_blank">
                                                <?= esc(substr($projek['file_projek'], 0, 10)) ?>...<?= substr($projek['file_projek'], -4) ?>
                                            </a>
                                        </td>
                                        <td><?= esc($projek['nama_programmer'] ?? 'N/A') ?></td>
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
                                                    <p name="deskripsi_dokumentasi" id="deskripsi_dokumentasi_<?= $file['id_dokumentasi'] ?>" disabled><?= esc($file['deskripsi_dokumentasi']) ?></p>
                                                </td>
                                                <td>
                                                    <?= esc($file['tanggal_dokumentasi']) ?>
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
                <div class="card card-primary card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Progress Projek</div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <div class="mb-4 mt-2">
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="<?= isset($progress['progress_projek']) ? $progress['progress_projek'] : 0 ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= isset($progress['progress_projek']) ? $progress['progress_projek'] : 0 ?>%;"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="progress">Total Progres dalam (%)</label>
                            <input disabled type="number" name="progress" min="0" max="100" value="<?= isset($progress['progress_projek']) ? $progress['progress_projek'] : '' ?>" required class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>