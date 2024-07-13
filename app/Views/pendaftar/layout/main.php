<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>NAMA PERUSAHAAN</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/pendaftar/img/favicon.png" rel="icon">
    <link href="assets/pendaftar/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?= base_url('assets/pendaftar/vendor/aos/aos.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/pendaftar/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/pendaftar/vendor/bootstrap-icons/bootstrap-icons.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/pendaftar/vendor/boxicons/css/boxicons.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/pendaftar/vendor/glightbox/css/glightbox.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/pendaftar/vendor/swiper/swiper-bundle.min.css') ?>" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="<?= base_url('assets/pendaftar/css/style.css') ?>" rel="stylesheet">

</head>

<body>
    <div class="wrap">

        <!-- ======= Hero Section ======= -->
        <section id="hero">
            <div class="hero-container" data-aos="fade-up">
                <h1>NAMA PERUSAHAAN</h1>
                <h2>Konsultasi dan Riset IT, Software & Hardware Developer</h2>
            </div>
        </section><!-- End Hero -->

        <!-- ======= Header ======= -->
        <header id="header" class="d-flex align-items-center">
            <div class="container d-flex align-items-center justify-content-between">

                <div class="logo">
                    <h5 class="text-light"><a href=""><span>NAMA PERUSAHAAN</span></a></h4>
                </div>

                <nav id="navbar" class="navbar">
                    <ul>
                        <li><a id="homeLink" class="nav-link scrollto <?= (uri_string() == '/' || uri_string() == 'layanan') ? 'active' : '' ?>" href="/">Home</a></li>
                        <li class="dropdown"><a href="#" class="<?= (uri_string() == 'profil-perusahaan' || uri_string() == 'struktur-perusahaan' || uri_string() == 'tata-kelola-perusahaan' || uri_string() == 'visi-misi') ? 'active' : '' ?>"><span>Tentang Kami</span> <i class="bi bi-chevron-down"></i></a>
                            <ul>
                                <li><a class="<?= (uri_string() == 'profil-perusahaan') ? 'active' : '' ?>" href="/profil-perusahaan">Profil Perusahaan</a></li>
                                <li><a class="<?= (uri_string() == 'struktur-perusahaan') ? 'active' : '' ?>" href="/struktur-perusahaan">Struktur Perusahaan</a></li>
                                <li><a class="<?= (uri_string() == 'tata-kelola-perusahaan') ? 'active' : '' ?>" href="/tata-kelola-perusahaan">Tata Kelola Perusahaan</a></li>
                                <li><a class="<?= (uri_string() == 'visi-misi') ? 'active' : '' ?>" href="/visi-misi">Visi & Misi</a></li>
                            </ul>
                        </li>
                        <li class="dropdown"><a href="#" class="<?= (strpos(uri_string(), 'layanan/paket') !== false || strpos(uri_string(), 'pendaftaran') !== false) ? 'active' : '' ?>"><span>Pendaftaran</span> <i class="bi bi-chevron-down"></i></a>
                            <ul>
                                <?php foreach ($layanan as $item) : ?>
                                    <li><a class="<?= (uri_string() == 'layanan/paket/' . $item['id_layanan']) ? 'active' : '' ?>" href="/layanan/paket/<?= $item['id_layanan']; ?>"><?= $item['nama_layanan']; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <li><a class="nav-link scrollto <?= (uri_string() == 'karir') ? 'active' : '' ?>" href="">Karir</a></li>
                        <li><a class="nav-link scrollto <?= (uri_string() == 'link-zoom') ? 'active' : '' ?>" href="/link-zoom">Link Zoom</a></li>
                        <li><a class="nav-link scrollto <?= (uri_string() == 'pendaftar/login') ? 'active' : '' ?>" href="/pendaftar/login">Log in</a></li>
                    </ul>
                    <i class="bi bi-list mobile-nav-toggle"></i>
                </nav><!-- .navbar -->


            </div>
        </header><!-- End Header -->

        <?= $this->renderSection('content'); ?>

        <!-- ======= Footer ======= -->
        <footer id="footer">

            <div class="footer-top">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-4 col-md-6 footer-contact">
                            <h4>NAMA PERUSAHAAN</h4>
                            <p>
                                <a href="" target="”_blank”">Alamat</a> <br><br>
                                <strong>Info Pendaftaran:</strong><a href="" target="”_blank”"> No WhatsApp</a><br>
                                <strong>Jam Buka:</strong> Senin s/d Jum'at : 08.00 - 16.00 WIB
                                Sabtu : 08.00 - 13.00 WIB
                                Hari minggu dan hari libur nasional tutup<br>
                            </p>
                        </div>

                        <div class="col-lg-4 col-md-6 footer-links">
                            <h4>Nomer Rekening</h4>
                            <ul class="feature-element" style="font-size: 12px;">
                                <!-- Item feature-element  -->
                                <li class="">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <img src="<?= base_url('assets/pendaftar/img/icon/bri.png') ?>" height="50px" width="50px">
                                        </div>
                                        <div class="col-md-9">
                                            BRI:
                                            No. Rekening a/n NAMA PERUSAHAAN
                                        </div>
                                    </div>
                                </li>

                                <!-- Item feature-element  -->
                                <li class="">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <img src="<?= base_url('assets/pendaftar/img/icon/bca.png') ?>" height="50px" width="50px">
                                        </div>
                                        <div class="col-md-9">
                                            BCA:
                                            No. Rekening a/n NAMA PERUSAHAAN
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="col-lg-4 col-md-6 footer-links">
                            <h3>Instagram & Youtube</h3>
                            <div class="row">
                                <div class="col-md-1">
                                    <img src="<?= base_url('assets/pendaftar/img/icon/ig.png') ?>" height="30px" width="30px">
                                </div>
                                <div class="col-md-7">
                                    <a href="" target=”_blank”>Nama Perusahaan</a>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-1">
                                    <img src="<?= base_url('assets/pendaftar/img/icon/yt.png') ?>" height="20px" width="25px">
                                </div>
                                <div class="col-md-7">
                                    <a href="" target=”_blank”>Nama Perusahaan</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="container py-4">
                <div class="copyright">
                    <p>© 2024 NAMA PERUSAHAAN. All Rights Reserved 2015
                        - 2024</p>
                </div>
            </div>
        </footer><!-- End Footer -->

    </div>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="<?= base_url('assets/pendaftar/vendor/aos/aos.js') ?>"></script>
    <script src="<?= base_url('assets/pendaftar/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/pendaftar/vendor/glightbox/js/glightbox.min.js') ?>"></script>
    <script src="<?= base_url('assets/pendaftar/vendor/isotope-layout/isotope.pkgd.min.js') ?>"></script>
    <script src="<?= base_url('assets/pendaftar/vendor/swiper/swiper-bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/pendaftar/vendor/php-email-form/validate.js') ?>"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Template Main JS File -->
    <script src="<?= base_url('assets/pendaftar/js/main.js') ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            window.location.hash = 'features';
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var currentPath = window.location.pathname;
            var homeLink = document.getElementById('homeLink');

            if (currentPath === '/' || currentPath === '/layanan') {
                homeLink.classList.add('active');
            }
        });
    </script>

</body>

</html>