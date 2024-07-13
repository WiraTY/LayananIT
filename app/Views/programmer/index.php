<?= $this->extend('programmer/layout/main'); ?>
<?= $this->section('content'); ?>

<div class="container">
    <div class="page-inner">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title mb-0">Jobdesk Projek</div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-head-bg-secondary mt-1">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Pendaftar</th>
                                <th scope="col">Nama Layanan</th>
                                <th scope="col">Nama Paket</th>
                                <th scope="col">Judul Projek</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($projek as $key => $projekItem) : ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= esc($projekItem['nama_pendaftar']) ?></td>
                                    <td><?= esc($projekItem['nama_layanan']) ?></td>
                                    <td><?= esc($projekItem['nama_paket']) ?></td>
                                    <td><?= esc($projekItem['judul_projek']) ?></td>
                                    <td>
                                        <a href="<?= base_url('programmer/progress/' . $projekItem['id_projek']) ?>" class="btn btn-info btn-sm">Progress</a>
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