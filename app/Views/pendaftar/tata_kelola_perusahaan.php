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
                    <h3>Tata Kelola Perusahaan</h3>
                    <p style="text-align: justify;">
                        Sebagai perusahaan publik, penerapan Tata Kelola Perusahaan adalah landasan bagi operasional NAMA PERUSAHAAN agar pengelolaan dapat berjalan secara efisien, efektif dan profesional sehingga tercipta citra perusahaan yang positif serta dapat meningkatkan kinerja secara optimal. NAMA PERUSAHAAN secara konsisten mengoptimalkan penerapan Tata Kelola Perusahaan melalui penguatan infrastruktur untuk mencapai praktik terbaik, dengan melakukan penyesuaian sistem dan prosedur yang diperlukan untuk mendukung pelaksanaan Tata Kelola Perusahaan agar semakin efektif. Hal ini mengacu pada 4 (empat) prinsip dasar yang menjadi pedoman bagi setiap langkah yang diambil oleh Manajemen NAMA PERUSAHAAN atau karyawan di segala tingkatan divisi. Keempat prinsip dasar ini adalah:
                    </p>
                    <ul>
                        <li class="checked" style="font-weight: bold;">Transparasi</li>
                        <p style="text-align: justify;">
                            Transparansi merupakan komitmen untuk memastikan tersedianya informasi penting yang dapat diakses oleh pihak-pihak yang memiliki kepentingan. Informasi ini bisa berupa keuangan perusahaan dan manajemen perusahaan. Semuanya harus tersedia secara akurat, jelas dan tepat waktu.
                        </p>
                        <li class="checked" style="font-weight: bold;">Akuntabilitas</li>
                        <p style="text-align: justify;">
                            Akuntabilitas menjamin adanya mekanisme, peran dan tanggung jawab sebuah manajemen profesional atas semua keputusan dan kebijakan yang diambil yang berdampak pada kegiatan-kegiatan operasional perusahaan.
                        </p>
                        <li class="checked" style="font-weight: bold;">Tanggung Jawab</li>
                        <p style="text-align: justify;">
                            Tanggung jawab adalah penjabaran yang jelas mengenai peran setiap pihak dalam meraih sasaran bersama, termasuk kepastian bahwa semua regulasi dan semua norma sosial telah dipenuhi.
                        </p>
                        <li class="checked" style="font-weight: bold;">Kelayakan</li>
                        <p style="text-align: justify;">
                            Kelayakan menjamin bahwa setiap keputusan dan kebijakan yang diambil diselaraskan dengan kepentingan pihak-pihak terkait, termasuk para pelanggan, pemilik perusahaan dan publik pada umumnya.
                        </p>
                    </ul>
                </div><!-- End .content-->
            </div>
        </div>
    </section><!-- End Features Section -->

</main><!-- End #main -->

<?= $this->endSection('content') ?>