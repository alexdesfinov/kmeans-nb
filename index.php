<html class="no-js" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SD NEGERI 16 TIMBALUN</title>
    <link rel="icon" href="assets/img/favicon.png">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
</head>

<body>
    <div id="scrollUp" title="Scroll To Top">
        <i class="fas fa-arrow-up"></i>
    </div>
    <div class="main">
        <header class="navbar navbar-sticky navbar-expand-lg navbar-dark">
            <div class="container position-relative">
                <a class="navbar-brand" href="?">
                    <div class="row">
                        <div class="col-xs-12">
                            <img class="navbar-brand-regular" width="100px" src="assets/img/logo/logo-white.png" alt="brand-logo">
                            <img class="navbar-brand-sticky" width="100px" src="assets/img/logo/logo-white.png" alt="sticky brand-logo">
                        </div>
                        <div class="col-xs-12" style="border-left: 1px solid white; padding-left: 12px;">
                            <h5 class="mt-4 text-white">Dinas Pendidikan dan Kebudayaan Kota Padang<br>SD NEGERI 16 TIMBALUN</h5>
                        </div>
                    </div>
                </a>
                <button class="navbar-toggler d-lg-none" type="button" data-toggle="navbarToggler" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-inner">
                    <button class="navbar-toggler d-lg-none" type="button" data-toggle="navbarToggler" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <nav>
                        <ul class="navbar-nav" id="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="?">Beranda</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="?page=profile">Profil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="portal">Masuk</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>
        <?php include 'page/' . (isset($_GET['page']) ? strtolower($_GET['page']) . '.php' : 'landing.php'); ?>
        <div class="height-emulator d-none d-lg-block"></div>
        <footer class="footer-area footer-fixed">
            <div class="footer-top ptb_100">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="footer-items">
                                <a class="navbar-brand" href="#">
                                    <img class="logo" src="assets/img/logo/logo.png" alt="">
                                </a>
                                <p class="mt-2 mb-3">
                                    Teknik Informatika Penentuan Tingkat Kecanduan Internet pada SD Negeri 16 Timbalun
                                </p>
                                <div class="social-icons d-flex">
                                    <a class="facebook" href="#">
                                        <i class="fab fa-facebook-f"></i>
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a class="twitter" href="#">
                                        <i class="fab fa-twitter"></i>
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a class="google-plus" href="#">
                                        <i class="fab fa-google-plus-g"></i>
                                        <i class="fab fa-google-plus-g"></i>
                                    </a>
                                    <a class="vine" href="#">
                                        <i class="fab fa-vine"></i>
                                        <i class="fab fa-vine"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="footer-items">
                                <h3 class="footer-title mb-2">Useful Links</h3>
                                <ul>
                                    <li class="py-2"><a href="#">Home</a></li>
                                    <li class="py-2"><a href="#">About Us</a></li>
                                    <li class="py-2"><a href="#">Services</a></li>
                                    <li class="py-2"><a href="#">Blog</a></li>
                                    <li class="py-2"><a href="#">Contact</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="footer-items">
                                <h3 class="footer-title mb-2">Product Help</h3>
                                <ul>
                                    <li class="py-2"><a href="#">FAQ</a></li>
                                    <li class="py-2"><a href="#">Privacy Policy</a></li>
                                    <li class="py-2"><a href="#">Support</a></li>
                                    <li class="py-2"><a href="#">Terms &amp; Conditions</a></li>
                                    <li class="py-2"><a href="#">Contact</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="copyright-area d-flex flex-wrap justify-content-center justify-content-sm-between text-center py-4">
                                <div class="copyright-left">&copy; Copyrights 2026 @ Human</div>
                                <div class="copyright-right">Made with By <a href="#">Human</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <script src="assets/js/jquery/jquery.min.js"></script>
    <script src="assets/js/bootstrap/popper.min.js"></script>
    <script src="assets/js/bootstrap/bootstrap.min.js"></script>
    <script src="assets/js/plugins/plugins.min.js"></script>
    <script src="assets/js/active.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatablesDataset').DataTable();
        });
    </script>
</body>

</html>