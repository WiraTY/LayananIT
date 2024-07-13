<?= $this->extend('pendaftar/layout/main'); ?>
<?= $this->Section('content'); ?>

<main id="main">

    <!-- ======= Features Section ======= -->
    <section id="features" class="features">
        <div class="container">
            <div class="section-title" data-aos="fade-down">
                <span><?= $section_title ?></span>
                <h2><?= $section_title ?></h2>
            </div>
            <div class="row">
                <?php if (isset($paket) && !empty($paket)) : ?>
                    <?php foreach ($paket as $item) : ?>
                        <div class="col-lg-4 col-md-6 d-flex justify-content-center mb-4">
                            <div class="card" data-aos="fade-up">
                                <div class="d-flex justify-content-center">
                                    <img style="height: 200px; width: 200px;" src="<?= base_url('assets/pendaftar/img/icon/' . $item['icon_paket']) ?>" class="card-img-top" alt="...">
                                </div>
                                <div class="card-body">
                                    <center>
                                        <h5 class="card-title">
                                            <a href="<?= site_url('pendaftaran/' . $item['id_paket']); ?>">
                                                <?= $item['nama_paket']; ?>
                                            </a>
                                        </h5>
                                        <p class="card-text"><?= $item['detail_paket']; ?></p>
                                        <p class="card-text"><?= $item['harga_paket']; ?></p>
                                    </center>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>Tidak ada layanan yang tersedia saat ini.</p>
                <?php endif; ?>
            </div>

        </div>
    </section><!-- End Features Section -->



</main><!-- End #main -->

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        window.location.hash = 'features';
    });
</script>

<?= $this->endSection('content') ?>