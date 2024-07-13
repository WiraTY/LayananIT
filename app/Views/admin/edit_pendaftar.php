<?= $this->extend('admin/layout/main'); ?>
<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    Edit Pendaftar
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/pendaftar/update/' . $pendaftar['id_pendaftar']) ?>" method="post">
                        <div class="form-group">
                            <label for="nama">Nama Pendaftar</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?= $pendaftar['nama_pendaftar'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" value="<?= $pendaftar['alamat_pendaftar'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="telp">Nomor Telepon</label>
                            <input type="text" class="form-control" id="telp" name="telp" value="<?= $pendaftar['no_pendaftar'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= $pendaftar['email_pendaftar'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= $pendaftar['username'] ?>">
                        </div>
                        <!-- <div class="form-group">
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" value="<?= $pendaftar['password'] ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary toggle-password" type="button"><i class="fa fa-eye"></i></button>
                                </div>
                            </div>
                        </div> -->
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.querySelectorAll('.toggle-password');

        togglePassword.forEach(button => {
            button.addEventListener('click', function() {
                const inputField = this.closest('.input-group').querySelector('input');
                const type = inputField.getAttribute('type') === 'password' ? 'text' : 'password';
                inputField.setAttribute('type', type);
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        });
    });
</script>

<?= $this->endSection(); ?>