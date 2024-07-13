<?= $this->extend('admin/layout/main'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <?php if (session()->getFlashdata('errors')) : ?>
                    <div>
                        <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                            <p><?= esc($error) ?></p>
                        <?php endforeach ?>
                    </div>
                <?php endif ?>
                <div class="card-header">
                    Tambah Programmer
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/store-programmer') ?>" method="post">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>