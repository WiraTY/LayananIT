<?= $this->extend('pendaftar/layout/main-login'); ?>
<?= $this->section('content'); ?>

<div class="container">
    <div class="page-inner">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title mb-0">Detail Pembayaran</div>
                <a href="<?= base_url("pendaftar/tambah-pembayaran/{$id_projek}") ?>" class="btn btn-primary btn-sm">Tambah Riwayat Pembayaran</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nama Projek</th>
                                <th>Nama Pendaftar</th>
                                <th>Harga Projek</th>
                                <th>Total Dibayar</th>
                                <th>Sisa Tagihan</th>
                                <th>Status Projek</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= esc($nama_projek) ?></td>
                                <td><?= esc($nama_pendaftar) ?></td>
                                <td><?= esc($harga_projek) ?></td>
                                <td><?= esc($total_dibayar) ?></td>
                                <td><?= esc($sisa_tagihan) ?></td>
                                <td>
                                    <?php if ($status_pembayaran == 0) : ?>
                                        <span class="badge badge-warning">Belum Lunas</span>
                                    <?php elseif ($status_pembayaran == 1) : ?>
                                        <span class="badge badge-success">Lunas</span>
                                    <?php else : ?>
                                        <span class="badge badge-danger">Status Tidak Diketahui</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-title mb-0">Tambah Riwayat Pembayaran</div>
            </div>
            <div class="card-body">
                <form action="<?= base_url("pendaftar/tambah-riwayat-pembayaran/{$id_projek}") ?>" method="post" enctype="multipart/form-data">
                    <!-- Input Total Pembayaran -->
                    <div class="form-group">
                        <label for="total_pembayaran">Total Pembayaran</label>
                        <input type="number" class="form-control" id="total_pembayaran" name="total_pembayaran" required>
                    </div>
                    <!-- Upload Bukti Pembayaran -->
                    <div class="form-group">
                        <label for="bukti_pembayaran">Bukti Pembayaran</label>
                        <input type="file" class="form-control-file" id="bukti_pembayaran" name="bukti_pembayaran" required>
                    </div>
                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Tambah Riwayat Pembayaran</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title mb-0">Riwayat Pembayaran</div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Total Pembayaran</th>
                                <th>Bukti Pembayaran</th>
                                <th>Waktu Pembayaran</th>
                                <th>Status Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pembayaran as $item) : ?>
                                <tr>
                                    <td><?= esc($item['total_pembayaran']) ?></td>
                                    <td>
                                        <a href="<?= base_url('uploads/' . $item['bukti_pembayaran']) ?>" target="_blank">
                                            <img src="<?= base_url('uploads/' . $item['bukti_pembayaran']) ?>" alt="Bukti Pembayaran" class="img-fluid" style="max-width: 200px;">
                                        </a>
                                    </td>
                                    <td>
                                        <?php
                                        $timestamp = strtotime($item['created_at']);
                                        $date = date('Y-m-d', $timestamp);
                                        $time = date('H:i:s', $timestamp);
                                        ?>
                                        <?= esc($date) ?><br>
                                        <small><?= esc($time) ?></small>
                                    </td>
                                    <td>
                                        <?php if (isset($item['approval_pembayaran'])) : ?>
                                            <?php if ($item['approval_pembayaran'] == 0) : ?>
                                                <span class="badge badge-warning">Belum Disetujui</span>
                                            <?php elseif ($item['approval_pembayaran'] == 1) : ?>
                                                <span class="badge badge-success">Sudah Disetujui</span>
                                            <?php else : ?>
                                                <span class="badge badge-danger">Tidak Disetujui</span>
                                            <?php endif; ?>
                                        <?php else : ?>
                                            <span class="badge badge-secondary">Data tidak lengkap</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>