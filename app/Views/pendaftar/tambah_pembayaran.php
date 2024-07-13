<!-- admin/tambah_pembayaran.php -->

<?= $this->extend('pendaftar/layout/main-login'); ?>
<?= $this->section('content'); ?>

<div class="container">
    <div class="page-inner">
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
    </div>
</div>

<?= $this->endSection(); ?>