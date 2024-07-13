<?= $this->extend('admin/layout/main'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    Edit Programmer
                </div>
                <div class="card-body">
                    <form action="<?= base_url('/admin/update-programmer/' . $programmer['id']) ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= $programmer['email'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= $programmer['username'] ?>" required>
                        </div>
                        <!-- Add other fields as needed -->

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
