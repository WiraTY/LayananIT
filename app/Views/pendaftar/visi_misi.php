<?= $this->extend('pendaftar/layout/main'); ?>
<?= $this->Section('content'); ?>

<style>
    ul {
        list-style-type: none;
    }

    .checked::before {
        content: "\2713\0020";
        /* Centang (✓) */
    }
</style>

<main id="main">

    <!-- ======= Features Section ======= -->
    <section id="features" class="features">

        <div class="container">
            <div class="pt-4 pt-lg-0 d-flex align-items-stretch">
                <div class="content d-flex flex-column justify-content-center aos-init aos-animate" data-aos="fade-left">
                    <ul>
                        <h3>Visi</h3>
                        <li class="checked">
                            NAMA PERUSAHAAN bertekad untuk menjadi sebuah sentra pembuatan software (website, mobile Android & iOS, desktop), hardware (alat electronics otomatis) dengan kualifikasi dan kompetensi internasional, serta berorientasi bisnis secara profesional.
                        </li>
                        <br>
                        <h3>Misi</h3>
                        <li class="checked">
                            Mengembangkan industri software (berbasis website, mobile Android & iOS, desktop), hardware (alat electronics otomatis) dengan orientasi bisnis dan kultur profesional.
                        </li>
                        <li class="checked">
                            Mengakomodasi sumber daya, potensi dan peluang bisnis di Indonesia.
                        </li>
                        <li class="checked">
                            Mengembangkan riset yang terpadu, berkesinambungan dan terarah secara jelas untuk meningkatkan kompetensi di dalam industri software & hardware.
                        </li>
                        <li class="checked">
                            Meningkatkan dan mengembangkan peluang-peluang kerjasama dengan pihak luar.
                        </li>
                        <li class="checked">
                            Meningkatkan branding dengan menjaga kualitas produk, layanan dan purna jual.
                        </li>
                    </ul>
                </div><!-- End .content-->
            </div>
        </div>
    </section><!-- End Features Section -->



</main><!-- End #main -->

<?= $this->endSection('content') ?>