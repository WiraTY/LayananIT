<?= $this->extend('pendaftar/layout/main'); ?>
<?= $this->Section('content'); ?>

<main id="main">

    <!-- ======= Features Section ======= -->
    <section id="features" class="features">

        <div class="container">
            <div class="pt-4 pt-lg-0 d-flex align-items-stretch">
                <div class="content d-flex flex-column justify-content-center aos-init aos-animate" data-aos="fade-left">
                    <h3>Struktur Perusahaan</h3>
                    <img src="<?= base_url('assets/pendaftar/img/icon/struktur19.png') ?>" class="img-fluid" alt="">
                </div><!-- End .content-->
            </div>
        </div>
    </section><!-- End Features Section -->

</main><!-- End #main -->

<?= $this->endSection('content') ?>