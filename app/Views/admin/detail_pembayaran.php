<?= $this->extend('admin/layout/main'); ?>
<?= $this->section('content'); ?>

<div class="container">
    <div class="page-inner">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title mb-0">Detail Pembayaran</div>
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
                                <th>Aksi</th>
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
                                    <td class="d-grid gap-2 justify-content-md-center">
                                        <a href="<?= base_url('admin/setujui-pembayaran/' . $item['id_pembayaran']) ?>" class="btn btn-success btn-sm">Setujui</a>
                                        <a href="<?= base_url('admin/batalkan-pembayaran/' . $item['id_pembayaran']) ?>" class="btn btn-danger btn-sm">Batal Setujui</a>
                                    </td>
                                    <!-- <td>
                                        <?php if ($item['approval_pembayaran'] == 0) : ?>
                                            <a href="<?= base_url('admin/setujui-batalkan-pembayaran/' . $item['id_pembayaran']) ?>" class="btn btn-success btn-sm">Setujui</a>
                                        <?php elseif ($item['approval_pembayaran'] == 1) : ?>
                                            <a href="<?= base_url('admin/setujui-batalkan-pembayaran/' . $item['id_pembayaran']) ?>" class="btn btn-danger btn-sm">Batal Setujui</a>
                                        <?php endif; ?>
                                    </td> -->
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