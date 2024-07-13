<?= $this->extend('pendaftar/layout/main-login'); ?>
<?= $this->section('content'); ?>

<div class="container">
    <div class="page-inner">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Profil Pendaftar</div>
            </div>
            <div class="card-body">

                <?php if (session()->has('error')) : ?>
                    <div class="alert alert-danger"><?= session('error') ?></div>
                <?php endif; ?>

                <?php if (session()->has('success')) : ?>
                    <div class="alert alert-success"><?= session('success') ?></div>
                <?php endif; ?>

                <form action="<?= base_url('pendaftar/updateProfile') ?>" method="post">
                    <div class="form-group">
                        <label for="nama_pendaftar">Nama Pendaftar</label>
                        <input type="text" class="form-control" id="nama_pendaftar" name="nama_pendaftar" value="<?= esc($pendaftar['nama_pendaftar']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat_pendaftar">Alamat Pendaftar</label>
                        <input type="text" class="form-control" id="alamat_pendaftar" name="alamat_pendaftar" value="<?= esc($pendaftar['alamat_pendaftar']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nomor_pendaftar">Nomor Pendaftar</label>
                        <input type="text" class="form-control" id="nomor_pendaftar" name="nomor_pendaftar" value="<?= esc($pendaftar['no_pendaftar']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email_pendaftar">Email Pendaftar</label>
                        <input type="email" class="form-control" id="email_pendaftar" name="email_pendaftar" value="<?= esc($pendaftar['email_pendaftar']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?= esc($pendaftar['username']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password_lama">Password Lama</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password_lama" name="password_lama" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary toggle-password" type="button"><i class="fa fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password_baru">Password Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password_baru" name="password_baru" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary toggle-password" type="button"><i class="fa fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ulangi_password">Ulangi Password Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="ulangi_password" name="ulangi_password" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary toggle-password" type="button"><i class="fa fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
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