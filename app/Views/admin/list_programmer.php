<?= $this->extend('admin/layout/main'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="page-inner">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title mb-0">Programmer</div>
                <a href="<?= base_url('admin/create-programmer') ?>" class="btn btn-primary">Tambah</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-head-bg-secondary mt-1">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Email</th>
                                <th scope="col">Username</th>
                                <th scope="col">Password</th>
                                <th scope="col">jobdesk</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($programmers as $key => $programmer) : ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= $programmer['email'] ?></td>
                                    <td><?= $programmer['username'] ?></td>
                                    <td><?= strlen($programmer['password_hash']) > 5 ? substr($programmer['password_hash'], 0, 5) . '...' : $programmer['password_hash'] ?></td>
                                    <td>
                                        <a href="<?= base_url('admin/lihat-jobdesk/' . $programmer['id']) ?>" class="lihat btn btn-info btn-sm">Lihat</a>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('admin/edit-programmer/' . $programmer['id']) ?>" class="edit" style="color: #ffc107;"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                                        <a href="<?= base_url('admin/delete-programmer/' . $programmer['id']) ?>" class="delete" style="color: #dc3545;"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
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