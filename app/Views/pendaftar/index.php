<?= $this->extend('pendaftar/layout/main'); ?>
<?= $this->Section('content'); ?>

<main id="main">

    <!-- ======= Features Section ======= -->
    <section id="features" class="features">

        <div class="container">
            <div class="section-title" data-aos="fade-down">
                <span>6 Layanan Kami</span>
                <h2>6 Layanan Kami</h2>
            </div>
            <div class="row">
                <?php if (isset($layanan) && !empty($layanan)) : ?>
                    <?php foreach ($layanan as $item) : ?>
                        <div class="col-lg-4 col-md-6 d-flex align-items-stretch mb-4">
                            <a href="/layanan/paket/<?= $item['id_layanan']; ?>">
                                <div class="card" data-aos="fade-up">
                                    <div class="d-flex justify-content-center">
                                        <img style="height: 200px; width: 200px;" src="<?= base_url('assets/pendaftar/img/icon/' . $item['icon_layanan']) ?>" class="card-img-top" alt="...">
                                    </div>
                                    <div class="card-body">
                                        <center>
                                            <h5 class="card-title"><a href="/layanan/paket/<?= $item['id_layanan']; ?>"><?= $item['nama_layanan']; ?></a></h5>
                                            <p class="card-text"><?= $item['deskripsi_layanan']; ?></p>
                                        </center>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>Tidak ada layanan yang tersedia saat ini.</p>
                <?php endif; ?>
            </div>

        </div>
    </section><!-- End Features Section -->



</main><!-- End #main -->

<?= $this->endSection('content') ?>