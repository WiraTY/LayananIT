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
                    <p>
                        Bimbingan dan Konsultasi Via Zoom dengan Research Staff silakan klik <a href="https://zoom.us/j/4945497174?pwd=MVJ4b1hEZmxWZXR5cHZ4ME5EQXVWZz09" target="_blank">disini</a>
                    </p>
                </div><!-- End .content-->
            </div>
        </div>
    </section><!-- End Features Section -->



</main><!-- End #main -->

<?= $this->endSection('content') ?>