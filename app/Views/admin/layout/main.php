<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Admin</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="<?= base_url('assets/admin/img/kaiadmin/favicon.ico') ?>" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="<?= base_url('assets/admin/js/plugin/webfont/webfont.min.js') ?>"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["<?= base_url('assets/admin/css/fonts.min.css') ?>"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/bootstrap.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/plugins.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/kaiadmin.min.css') ?>" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.4/dist/sweetalert2.min.css" rel="stylesheet">


    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/demo.css') ?>" />
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="dark">
            <div class="sidebar-logo">
                <!-- Logo Header -->
                <div class="logo-header" data-background-color="dark">
                    <!-- <a href="index.html" class="logo">
                        <img src="<?= base_url('assets/admin/img/kaiadmin/logo_light.svg') ?>" alt="navbar brand" class="navbar-brand" height="20" />
                    </a> -->
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar">
                            <i class="gg-menu-right"></i>
                        </button>
                        <button class="btn btn-toggle sidenav-toggler">
                            <i class="gg-menu-left"></i>
                        </button>
                    </div>
                    <button class="topbar-toggler more">
                        <i class="gg-more-vertical-alt"></i>
                    </button>
                </div>
                <!-- End Logo Header -->
            </div>
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <ul class="nav nav-secondary">
                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">ADMIN</h4>
                        </li>
                        <li class="nav-item <?= (uri_string() == 'admin/index' || uri_string() == 'admin/pendaftar' || uri_string() == 'admin/pendaftar/tambah' || strpos(uri_string(), 'admin/pendaftar/edit') !== false || strpos(uri_string(), 'admin/pendaftar/delete') !== false || strpos(uri_string(), 'admin/projek') !== false || strpos(uri_string(), 'admin/detail-pembayaran') !== false) ? 'active' : '' ?>">
                            <a href="<?= base_url('admin/index') ?>" class="nav-link">
                                <i class="fas fa-pen-square"></i>
                                <span>Pendaftar</span>
                            </a>
                        </li>
                        <li class="nav-item <?= (uri_string() == 'admin/list-programmer' || uri_string() == 'admin/create-programmer' || strpos(uri_string(), 'admin/edit-programmer') || strpos(uri_string(), 'admin/lihat-jobdesk') !== false) ? 'active' : '' ?>">
                            <a href="<?= base_url('admin/list-programmer') ?>" class="nav-link">
                                <i class="fas fa-desktop"></i>
                                <span>Programmer</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url("/logout") ?>">
                                <i class="fas fa-sign-out-alt"></i>
                                <p>Logout</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <!-- Logo Header -->
                    <div class="logo-header" data-background-color="dark">
                        <a href="index.html" class="logo">
                            <img src="<?= base_url('assets/admin/img/kaiadmin/logo_light.svg') ?>" alt="navbar brand" class="navbar-brand" height="20" />
                        </a>
                        <div class="nav-toggle">
                            <button class="btn btn-toggle toggle-sidebar">
                                <i class="gg-menu-right"></i>
                            </button>
                            <button class="btn btn-toggle sidenav-toggler">
                                <i class="gg-menu-left"></i>
                            </button>
                        </div>
                        <button class="topbar-toggler more">
                            <i class="gg-more-vertical-alt"></i>
                        </button>
                    </div>
                    <!-- End Logo Header -->
                </div>
                <!-- Navbar Header -->
                <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                    <div class="container-fluid">

                        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                            <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false" aria-haspopup="true">
                                    <i class="fa fa-search"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-search animated fadeIn">
                                    <form class="navbar-left navbar-form nav-search">
                                        <div class="input-group">
                                            <input type="text" placeholder="Search ..." class="form-control" />
                                        </div>
                                    </form>
                                </ul>
                            </li>

                            <li class="nav-item topbar-user dropdown hidden-caret">
                                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                                    <!-- <div class="avatar-sm">
                                        <img src="<?= base_url('assets/admin/img/profile.jpg') ?>" alt="..." class="avatar-img rounded-circle" />
                                    </div> -->
                                    <span class="profile-username">
                                        <span class="op-7">Hi,</span>
                                        <span class="fw-bold"><?= user()->username ?></span>
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-user animated fadeIn">
                                    <div class="dropdown-user-scroll scrollbar-outer">
                                        <li>
                                            <a class="dropdown-item" href="<?= base_url('logout') ?>">Logout</a>
                                        </li>
                                    </div>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
                <!-- End Navbar -->
            </div>

            <?= $this->renderSection('content'); ?>

            <footer class="footer">
                <div class="container-fluid d-flex justify-content-between">

                </div>
            </footer>
        </div>

        <!-- Custom template | don't include it in your project! -->
        <div class="custom-template">
            <div class="title">Settings</div>
            <div class="custom-content">
                <div class="switcher">
                    <div class="switch-block">
                        <h4>Logo Header</h4>
                        <div class="btnSwitch">
                            <button type="button" class="selected changeLogoHeaderColor" data-color="dark"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="blue"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="purple"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="light-blue"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="green"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="orange"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="red"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="white"></button>
                            <br />
                            <button type="button" class="changeLogoHeaderColor" data-color="dark2"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="blue2"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="purple2"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="light-blue2"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="green2"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="orange2"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="red2"></button>
                        </div>
                    </div>
                    <div class="switch-block">
                        <h4>Navbar Header</h4>
                        <div class="btnSwitch">
                            <button type="button" class="changeTopBarColor" data-color="dark"></button>
                            <button type="button" class="changeTopBarColor" data-color="blue"></button>
                            <button type="button" class="changeTopBarColor" data-color="purple"></button>
                            <button type="button" class="changeTopBarColor" data-color="light-blue"></button>
                            <button type="button" class="changeTopBarColor" data-color="green"></button>
                            <button type="button" class="changeTopBarColor" data-color="orange"></button>
                            <button type="button" class="changeTopBarColor" data-color="red"></button>
                            <button type="button" class="selected changeTopBarColor" data-color="white"></button>
                            <br />
                            <button type="button" class="changeTopBarColor" data-color="dark2"></button>
                            <button type="button" class="changeTopBarColor" data-color="blue2"></button>
                            <button type="button" class="changeTopBarColor" data-color="purple2"></button>
                            <button type="button" class="changeTopBarColor" data-color="light-blue2"></button>
                            <button type="button" class="changeTopBarColor" data-color="green2"></button>
                            <button type="button" class="changeTopBarColor" data-color="orange2"></button>
                            <button type="button" class="changeTopBarColor" data-color="red2"></button>
                        </div>
                    </div>
                    <div class="switch-block">
                        <h4>Sidebar</h4>
                        <div class="btnSwitch">
                            <button type="button" class="changeSideBarColor" data-color="white"></button>
                            <button type="button" class="selected changeSideBarColor" data-color="dark"></button>
                            <button type="button" class="changeSideBarColor" data-color="dark2"></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="custom-toggle">
                <i class="icon-settings"></i>
            </div> -->
        </div>
        <!-- End Custom template -->
    </div>
    <!--   Core JS Files   -->
    <script src="<?= base_url('assets/admin/js/core/jquery-3.7.1.min.js') ?>"></script>
    <script src="<?= base_url('assets/admin/js/core/popper.min.js') ?>"></script>
    <script src="<?= base_url('assets/admin/js/core/bootstrap.min.js') ?>"></script>

    <!-- jQuery Scrollbar -->
    <script src="<?= base_url('assets/admin/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') ?>"></script>

    <!-- Chart JS -->
    <script src="<?= base_url('assets/admin/js/plugin/chart.js/chart.min.js') ?>"></script>

    <!-- jQuery Sparkline -->
    <script src="<?= base_url('assets/admin/js/plugin/jquery.sparkline/jquery.sparkline.min.js') ?>"></script>

    <!-- Chart Circle -->
    <script src="<?= base_url('assets/admin/js/plugin/chart-circle/circles.min.js') ?>"></script>

    <!-- Datatables -->
    <script src="<?= base_url('assets/admin/js/plugin/datatables/datatables.min.js') ?>"></script>

    <!-- Bootstrap Notify -->
    <script src="<?= base_url('assets/admin/js/plugin/bootstrap-notify/bootstrap-notify.min.js') ?>"></script>

    <!-- jQuery Vector Maps -->
    <script src="<?= base_url('assets/admin/js/plugin/jsvectormap/jsvectormap.min.js') ?>"></script>
    <script src="<?= base_url('assets/admin/js/plugin/jsvectormap/world.js') ?>"></script>

    <!-- Sweet Alert -->
    <!-- Include SweetAlert CSS -->

    <!-- Include SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.4/dist/sweetalert2.all.min.js"></script>


    <!-- Kaiadmin JS -->
    <script src="<?= base_url('assets/admin/js/kaiadmin.min.js') ?>"></script>

    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <!-- <script src="<?= base_url('assets/admin/js/setting-demo.js') ?>"></script>
    <script src="<?= base_url('assets/admin/js/demo.js') ?>"></script> -->

    <script>
        $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#177dff",
            fillColor: "rgba(23, 125, 255, 0.14)",
        });

        $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#f3545d",
            fillColor: "rgba(243, 84, 93, .14)",
        });

        $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#ffa534",
            fillColor: "rgba(255, 165, 52, .14)",
        });
    </script>

    <script>
        // Menggunakan jQuery untuk mendapatkan URL saat ini
        $(document).ready(function() {
            var currentUrl = window.location.href;

            // Periksa setiap tautan di navigasi
            $('.nav-item').each(function() {
                var navLink = $(this).find('a').attr('href');

                // Jika URL saat ini cocok dengan tautan navigasi, tambahkan kelas 'active'
                if (currentUrl.includes(navLink)) {
                    $(this).addClass('active');
                }
            });
        });
    </script>
</body>

</html>