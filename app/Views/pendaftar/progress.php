<?= $this->extend('pendaftar/layout/main-login'); ?>
<?= $this->section('content'); ?>

<div class="container">
    <div class="page-inner">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title mb-0">Projek Anda yang Sedang Dikerjakan</div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-head-bg-secondary mt-1">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Layanan</th>
                                <th scope="col">Nama Paket</th>
                                <th scope="col">Judul Projek</th>
                                <th scope="col">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($projek as $key => $projekItem) : ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= esc($projekItem['nama_layanan']) ?></td>
                                    <td><?= esc($projekItem['nama_paket']) ?></td>
                                    <td><?= esc($projekItem['judul_projek']) ?></td>
                                    <td>
                                        <div class="d-grid gap-2">
                                            <a href="<?= base_url('pendaftar/progress-detail/' . $projekItem['id_projek']) ?>" class="btn btn-info btn-sm mb-2">Progress</a>
                                            <a href="<?= base_url('pendaftar/detail-pembayaran/' . $projekItem['id_projek']) ?>" class="btn btn-warning btn-sm mt-2">Pembayaran</a>
                                        </div>
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