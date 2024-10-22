<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Kopwan-KM</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="{{ asset('backend/assets/img/favicon/logo-koperasi.ico') }}" rel="icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('frontend/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('frontend/assets/css/main.css') }}" rel="stylesheet">
</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container position-relative d-flex align-items-center justify-content-between">

            <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <img src="{{ 'frontend/assets/img/logo-koperasi.png' }}" alt="">
                <h1 class="sitename">Kopwan-KM</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#hero" class="active">Home</a></li>
                    <li><a href="#about">Tentang Kami</a></li>
                    <li><a href="#services">Layanan</a></li>
                    <li><a href="#team">Pengelola</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <a class="cta-btn" href="{{ route('login') }}">Login</a>

        </div>
    </header>

    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section dark-background">

            <img src="{{ asset('frontend/assets/img/hero-bg2.jpg') }}" alt="" data-aos="fade-in">

            <div class="container d-flex flex-column align-items-center text-center">
                <h2 data-aos="fade-up" data-aos-delay="100">Selamat Datang di Kopwan - KM</h2>
                <p data-aos="fade-up" data-aos-delay="200">Kami hadir untuk mendukung kesejahteraan anggota melalui
                    layanan simpan pinjam yang mudah, transparan, dan terpercaya.</p>
            </div>

        </section><!-- /Hero Section -->

        <!-- About Section -->
        <section id="about" class="about section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Tentang Kami</h2>
                <p>Kami berkomitmen untuk memberikan pelayanan terbaik dalam mendukung kesejahteraan anggota melalui
                    layanan keuangan yang transparan dan terpercaya.</p>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-4">

                    <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
                        <p>
                            Koperasi Simpan Pinjam "Kopwan - KM" didirikan dengan tujuan membantu anggota dalam memenuhi
                            kebutuhan finansial melalui sistem simpan pinjam yang adil dan transparan.
                        </p>
                        <ul>
                            <li><i class="bi bi-check2-circle"></i> <span>Layanan simpan pinjam berbasis online yang
                                    mudah diakses.</span></li>
                            <li><i class="bi bi-check2-circle"></i> <span>Transparansi dan akuntabilitas dalam
                                    pengelolaan keuangan anggota.</span></li>
                            <li><i class="bi bi-check2-circle"></i> <span>Memberikan manfaat maksimal bagi seluruh
                                    anggota koperasi.</span></li>
                        </ul>
                    </div>

                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                        <p>Kami terus berinovasi untuk memberikan layanan terbaik kepada anggota dengan memanfaatkan
                            teknologi modern dan mengedepankan prinsip kesejahteraan bersama.</p>
                        <a href="{{ route('register') }}" class="read-more"><span>Daftar Sekarang</span><i
                                class="bi bi-arrow-right"></i></a>
                    </div>

                </div>

            </div>

        </section><!-- /About Section -->

        <!-- Services Section -->
        <section id="services" class="services section light-background">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Layanan</h2>
                <p>Kami menawarkan berbagai layanan untuk mendukung kebutuhan anggota koperasi kami.</p>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-4">

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="bi bi-bank"></i>
                            </div>
                            <a href="#" class="stretched-link">
                                <h3>Simpanan</h3>
                            </a>
                            <p>Kami menyediakan layanan simpanan berupa simpanan pokok, simpanan wajib dan simpanan sukarela.</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="bi bi-cash"></i>
                            </div>
                            <a href="#" class="stretched-link">
                                <h3>Pinjaman</h3>
                            </a>
                            <p>Kami menawarkan pinjaman dengan suku bunga yang kompetitif yaitu sebesar 1%.</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="bi bi-credit-card"></i>
                            </div>
                            <a href="#" class="stretched-link">
                                <h3>Angsuran</h3>
                            </a>
                            <p>Fasilitas angsuran online untuk memudahkan anggota dalam melakukan pembayaran.</p>
                        </div>
                    </div><!-- End Service Item -->

                </div>

            </div>

        </section><!-- /Services Section -->

        <!-- Stats Section -->
        <section id="stats" class="stats section dark-background">

            <img src="{{ asset('frontend/assets/img/stats-bg.jpg') }}" alt="" data-aos="fade-in">

            <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">

                <div class="subheading">
                    <h3>Pencapaian Kami Sejauh Ini</h3>
                    <p>Kami berkomitmen untuk memberikan pelayanan terbaik dan membantu meningkatkan kesejahteraan
                        anggota koperasi.</p>
                </div>

                <div class="row gy-4">

                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="52" data-purecounter-duration="1"
                                class="purecounter"></span>
                            <p>Anggota Aktif</p>
                        </div>
                    </div><!-- End Stats Item -->

                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="103149000"
                                data-purecounter-duration="1" class="purecounter"></span>
                            <p>Pendapatan Tahun 2023</p>
                        </div>
                    </div><!-- End Stats Item -->

                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="682094180"
                                data-purecounter-duration="1" class="purecounter"></span>
                            <p>Keuangan Tahun 2023</p>
                        </div>
                    </div><!-- End Stats Item -->

                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="3" data-purecounter-duration="1"
                                class="purecounter"></span>
                            <p>Pengelola</p>
                        </div>
                    </div><!-- End Stats Item -->

                </div>

            </div>

        </section><!-- /Stats Section -->

        <!-- Team Section -->
        <section id="team" class="team section light-background">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Pengelola</h2>
                <p>Tim pengelola kami berdedikasi untuk memberikan pelayanan terbaik dan memastikan kelancaran
                    operasional koperasi. Dengan keahlian di bidang masing-masing, mereka berkomitmen untuk mengelola
                    keuangan anggota dengan transparan dan profesional.</p>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-4">

                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up"
                        data-aos-delay="100">
                        <div class="team-member">
                            <div class="member-img">
                                <img src="{{ asset('frontend/assets/img/team/eti.png') }}" class="img-fluid"
                                    alt="">
                            </div>
                            <div class="member-info">
                                <h4>Eti Rahmida</h4>
                                <span>Ketua</span>
                            </div>
                        </div>
                    </div><!-- End Team Member -->

                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up"
                        data-aos-delay="200">
                        <div class="team-member">
                            <div class="member-img">
                                <img src="{{ asset('frontend/assets/img/team/eta.png') }}" class="img-fluid"
                                    alt="">
                            </div>
                            <div class="member-info">
                                <h4>Eta Novia</h4>
                                <span>Sekretaris</span>
                            </div>
                        </div>
                    </div><!-- End Team Member -->

                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up"
                        data-aos-delay="300">
                        <div class="team-member">
                            <div class="member-img">
                                <img src="{{ asset('frontend/assets/img/team/refika.png') }}" class="img-fluid"
                                    alt="">
                            </div>
                            <div class="member-info">
                                <h4>Refika Melia</h4>
                                <span>Bendahara</span>
                            </div>
                        </div>
                    </div><!-- End Team Member -->

                </div>

            </div>

        </section><!-- /Team Section -->

        <!-- Faq Section -->
        <section id="faq" class="faq section">

            <div class="container-fluid">

                <div class="row gy-4">

                    <div class="col-lg-7 d-flex flex-column justify-content-center order-2 order-lg-1">

                        <div class="content px-xl-5" data-aos="fade-up" data-aos-delay="100">
                            <h3><span>Pertanyaan yang </span><strong>Sering Diajukan</strong></h3>
                            <p>
                                Berikut adalah beberapa pertanyaan umum yang sering diajukan terkait dengan layanan
                                koperasi simpan pinjam kami. Kami harap ini dapat membantu menjawab sebagian besar
                                pertanyaan Anda.
                            </p>
                        </div>

                        <div class="faq-container px-xl-5" data-aos="fade-up" data-aos-delay="200">

                            <div class="faq-item faq-active">
                                <i class="faq-icon bi bi-question-circle"></i>
                                <h3>Bagaimana cara menjadi anggota koperasi?</h3>
                                <div class="faq-content">
                                    <p>Untuk menjadi anggota koperasi, Anda bisa mengisi formulir pendaftaran online di
                                        situs kami dengan menyertakan KTP dan dokumen pendukung lainnya.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <i class="faq-icon bi bi-question-circle"></i>
                                <h3>Apa saja persyaratan untuk mengajukan pinjaman?</h3>
                                <div class="faq-content">
                                    <p>Untuk mengajukan pinjaman, Anda harus menjadi anggota koperasi minimal 2 tahun,
                                        memiliki simpanan wajib yang aktif, dan melengkapi syarat administrasi seperti
                                        KTP.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <i class="faq-icon bi bi-question-circle"></i>
                                <h3>Bagaimana sistem pembayaran angsuran pinjaman?</h3>
                                <div class="faq-content">
                                    <p>Pembayaran angsuran dilakukan setiap bulan secara online melalui aplikasi
                                        koperasi kami untuk memudahkan anggota. Pembayaran juga dapat dilakukan secara
                                        langsung di kantor koperasi.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                        </div>

                    </div>

                    <div class="col-lg-5 order-1 order-lg-2">
                        <img src="{{ asset('frontend/assets/img/faq.jpg') }}" class="img-fluid" alt=""
                            data-aos="zoom-in" data-aos-delay="100">
                    </div>
                </div>

            </div>

        </section><!-- /Faq Section -->

        <!-- Contact Section -->
        {{-- <section id="contact" class="contact section light-background">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Contact</h2>
                <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade" data-aos-delay="100">

                <div class="row gy-4">

                    <div class="col-lg-4">
                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
                            <i class="bi bi-geo-alt flex-shrink-0"></i>
                            <div>
                                <h3>Address</h3>
                                <p>A108 Adam Street, New York, NY 535022</p>
                            </div>
                        </div><!-- End Info Item -->

                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                            <i class="bi bi-telephone flex-shrink-0"></i>
                            <div>
                                <h3>Call Us</h3>
                                <p>+1 5589 55488 55</p>
                            </div>
                        </div><!-- End Info Item -->

                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                            <i class="bi bi-envelope flex-shrink-0"></i>
                            <div>
                                <h3>Email Us</h3>
                                <p>info@example.com</p>
                            </div>
                        </div><!-- End Info Item -->

                    </div>

                    <div class="col-lg-8">
                        <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up"
                            data-aos-delay="200">
                            <div class="row gy-4">

                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Your Name" required="">
                                </div>

                                <div class="col-md-6 ">
                                    <input type="email" class="form-control" name="email"
                                        placeholder="Your Email" required="">
                                </div>

                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="subject" placeholder="Subject"
                                        required="">
                                </div>

                                <div class="col-md-12">
                                    <textarea class="form-control" name="message" rows="6" placeholder="Message" required=""></textarea>
                                </div>

                                <div class="col-md-12 text-center">
                                    <div class="loading">Loading</div>
                                    <div class="error-message"></div>
                                    <div class="sent-message">Your message has been sent. Thank you!</div>

                                    <button type="submit">Send Message</button>
                                </div>

                            </div>
                        </form>
                    </div><!-- End Contact Form -->

                </div>

            </div>

        </section> --}}
        <!-- /Contact Section -->

    </main>

    <footer id="footer" class="footer dark-background">

        <div class="footer-top">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-5 col-md-12 footer-about">
                        <a href="index.html" class="logo d-flex align-items-center">
                            <img src="{{ 'frontend/assets/img/logo-koperasi.png' }}" alt="">
                            <span class="sitename">Kopwan - KM</span>
                        </a>
                        <p>Kopwan - KM adalah koperasi simpan pinjam yang berkomitmen untuk meningkatkan kesejahteraan
                            anggota melalui layanan keuangan yang transparan dan terpercaya. Kami hadir untuk mendukung
                            perekonomian anggota dengan layanan keuangan berbasis simpan pinjam.</p>
                    </div>

                    <div class="col-lg-2 col-6 footer-links">
                        <h4>Tautan Penting</h4>
                        <ul>
                            <li><a href="#hero">Home</a></li>
                            <li><a href="#about">Tentang Kami</a></li>
                            <li><a href="#services">Layanan</a></li>
                            <li><a href="#team">Pengelola</a></li>
                            <li><a href="#faq">FAQ</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-2 col-6 footer-links">
                        <h4>Layanan Kami</h4>
                        <ul>
                            <li><a href="#">Simpanan</a></li>
                            <li><a href="#">Pinjaman</a></li>
                            <li><a href="#">Pembayaran Angsuran</a></li>
                            <li><a href="#">Laporan Keuangan</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
                        <h4>Hubungi Kami</h4>
                        <p>Jl. Bakri Sulaiman</p>
                        <p>Air Bangis, 26573</p>
                        <p>Indonesia</p>
                        <p class="mt-4"><strong>Telepon:</strong> <span>+6282116535404</span></p>
                        <p><strong>Email:</strong> <span>kopwankm@gmail.com</span></p>
                    </div>

                </div>
            </div>
        </div>

    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('frontend/assets/js/main.js') }}"></script>

</body>

</html>
