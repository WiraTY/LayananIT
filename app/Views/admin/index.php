<?= $this->extend('admin/layout/main'); ?>
<?= $this->section('content'); ?>

<div class="container">
    <div class="page-inner">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title mb-0">Pendaftar</div>
                <a href="/admin/pendaftar/tambah" class="btn btn-primary">Tambah</a>
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

                <div class="table-responsive">
                    <table class="table table-head-bg-secondary mt-1">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Pendaftar</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">Nomor Telepon</th>
                                <th scope="col">Email</th>
                                <th scope="col">username</th>
                                <th scope="col">password</th>
                                <th scope="col">Detail</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pendaftar as $key => $pendaftarItem) : ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= $pendaftarItem['nama_pendaftar'] ?></td>
                                    <td><?= $pendaftarItem['alamat_pendaftar'] ?></td>
                                    <td><?= $pendaftarItem['no_pendaftar'] ?></td>
                                    <td><?= $pendaftarItem['email_pendaftar'] ?></td>

                                    <td><?= $pendaftarItem['username'] ?></td>
                                    <td><?= strlen($pendaftarItem['password']) > 5 ? substr($pendaftarItem['password'], 0, 5) . '...' : $pendaftarItem['password'] ?></td>

                                    <td class="d-grid gap-2 justify-content-md-center">
                                        <a href="<?= base_url('admin/projek/' . $pendaftarItem['id_pendaftar']) ?>" class="btn btn-info btn-sm">Projek</a>
                                        <a href="<?= base_url('admin/detail-pembayaran/' . $pendaftarItem['id_pendaftar']) ?>" class="btn btn-primary btn-sm">Pembayaran</a>
                                    </td>

                                    <td>
                                        <a href="<?= base_url('admin/pendaftar/edit/' . $pendaftarItem['id_pendaftar']) ?>" class="edit" style="color: #ffc107;" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                                        <a href="#" class="delete" style="color: #dc3545;" data-id="<?= $pendaftarItem['id_pendaftar'] ?>" data-nama="<?= $pendaftarItem['nama_pendaftar'] ?>"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const pendaftarId = this.getAttribute('data-id');
                const namaPendaftar = this.getAttribute('data-nama');

                Swal.fire({
                    title: 'Yakin menghapus ' + namaPendaftar + '?',
                    text: "Anda tidak dapat mengembalikannya!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `<?= base_url('admin/pendaftar/delete') ?>/${pendaftarId}`;
                    }
                });
            });
        });
    });
</script>


<?= $this->endSection(); ?>