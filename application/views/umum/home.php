<!DOCTYPE html>
<!-- Website - www.codingnepalweb.com -->
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <!-- ===== Link Swiper's CSS ===== -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/images/bpn.png') ?>">
    <!-- ===== Fontawesome CDN Link ===== -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <title>Koperasi Bhumi Karya</title>
    <!-- <link rel="stylesheet" href="style.css" /> -->
    <link rel="stylesheet" href="<?= base_url('assets/css/NewStyle.css') ?>" />
    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
    <!-- Move to up button -->
    <div class="scroll-button">
        <a href="#home"><i class="fas fa-arrow-up"></i></a>
    </div>
    <!-- navgaition menu -->
    <!-- Move to Up Button -->
    <!-- <div class="scroll-button"></div> -->
    <header style="">
        <img src="assets/images/bpn.png" class="logo" alt="logo">
        <nav class="navbar">
            <ul class="nav_links">
                <li class="active"><a href="#umum">Profile</a></li>
                <li><a href="#struktur">Struktur</a></li>
                <li><a href="#tentang">Tentang</a></li>
            </ul>

        </nav>
        <a class="cta" href="<?= base_url('auth/showLogin') ?>"><button>e-Koperasi</button> </a>

    </header>



    <!-- Home Section Start -->
    <section class="home" id="home" style="background-image: url('assets/images/bg1.png');background-attachment: scroll;">

    </section>

    <section class="home" id="umum" style="background-image: url('assets/images/bgKop.png');background-attachment: scroll; ">
        <div class=" home-content">

            <div class="text" style="align:left; justify-content:left;">
                <div class="text-one">Hello,</div>
                <div class="text-two">A-Kopers</div>
                <div class="text-three">Selamat datang!</div>
                <div class="text-four">di Koperasi Bhumi Karya</div>
                <div class="button">
                    <a class="s" href="<?= base_url('auth/showLogin') ?>"><button>e-Koperasi</button> </a>
                </div>
            </div>



        </div>
    </section>

    <!-- About Section Start -->
    <section class="about" id="struktur">
        <div class="content">
            <div class=" title"><span>Struktur Kelembagaan</span></div>
            <div class="container" style="">
                <input type="radio" name="dot" id="one">
                <input type="radio" name="dot" id="two">

                <div class="main-card">
                    <div class="cards">
                        <div class="card">
                            <div class="content">
                                <div class="img">
                                    <img src="assets/images/nora.jpg" alt="">
                                </div>
                                <div class="details">
                                    <div class="name">Nora E. Harahap, S.S.T.</div>
                                    <div class="job">Ketua</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container" style="justify-content:center; align-items:center; gap:5px; ">
                <input type="radio" name="dot" id="one">
                <input type="radio" name="dot" id="two">
                <div class="main-card" style="display: flex; justify-content:space-between;">
                    <div class="cards" style="">
                        <div class="card">
                            <div class="content">
                                <div class="img">
                                    <img src="assets/images/nita.jpg" alt="">
                                </div>
                                <div class="details">
                                    <div class="name">Nita Rita Ningsih, S.A.P.</div>
                                    <div class="job">Sekretaris</div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="content">
                                <div class="img">
                                    <img src="assets/images/yayang.jpg" alt="">
                                </div>
                                <div class="details">
                                    <div class="name">Yayang Gumilang</div>
                                    <div class="job">Bendahara</div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="content">
                                <div class="img">
                                    <img src="assets/images/asep.jpg" alt="">
                                </div>
                                <div class="details">
                                    <div class="name">Asep Saepul Mujahid, S.H., M.Si</div>
                                    <div class="job">Pengawas</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- My Skill Section Start -->
    <!-- Section Tag and Other Div will same where we need to put same CSS -->
    <section class="skills" id="tentang">
        <div class="content">
            <div class="title"><span>Kelembagaan</span></div>
            <div class="skills-details">
                <div class="text">
                    <div class="topic">Susunan Kepengurusan Koperasi</div>
                    <p>Koperasi Pegawai Kantor Pertanahan Kota Bandung Bhumi Karya disingkat Bhumi Karya merupakan lembaga kerjasama ekonomi yang telah berbadan hukum. Anggota Koperasi Bhumi Karya adalah Warga Negara Indonesia yang memenuhi beberapa persyaratan diantaranya bermata pencaharian sebagai Pegawai Kantor Pertanahan Kota Bandung, jumlah anggotanya yaitu 170 orang dengan perincian susunan kepengurusan seperti pada gambar diatas.</p>
                    <div class="experience">
                        <div class="num">170</div>
                        <div class="exp">
                            Anggota
                        </div>
                    </div>
                </div>
                <div class="boxes">
                    <div class="topic">Tujuan</div>
                    <p>Untuk mengembangkan kesejahteraan anggota maka koperasi menyelenggarakan usaha. Jenis usaha Koperasi Bhumi Karya menurut aneka ragam unit usahanya merupakan jenis Koperasi Usaha Majemuk (Multipurpose) yang memberikan pelayanan atau usaha dengan berbagai jenis usaha atau berbagai bidang kegiatan yang diharapkan dapat lebih meningkatkan kemampuan koperasi. Adapun jenis usaha Koperasi Bhumi Karya, terdiri dari unit usaha.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- My Services Section Start
    <section class="services" id="services">
        <div class="content">
            <div class="title"><span>My Services</span></div>
            <div class="boxes">
                <div class="box">
                    <div class="icon">
                        <i class="fas fa-desktop"></i>
                    </div>
                    <div class="topic">Web Devlopment</div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia autem quam odio, qui voluptatem eligendi?</p>
                </div>
                <div class="box">
                    <div class="icon">
                        <i class="fas fa-paint-brush"></i>
                    </div>
                    <div class="topic">Graphic Design</div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia autem quam odio, qui voluptatem eligendi?</p>
                </div>
                <div class="box">
                    <div class="icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="topic">Digital Marketing</div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia autem quam odio, qui voluptatem eligendi?</p>
                </div>
                <div class="box">
                    <div class="icon">
                        <i class="fab fa-android"></i>
                    </div>
                    <div class="topic">Icon Design</div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia autem quam odio, qui voluptatem eligendi?</p>
                </div>
                <div class="box">
                    <div class="icon">
                        <i class="fas fa-camera-retro"></i>
                    </div>
                    <div class="topic">Photography</div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia autem quam odio, qui voluptatem eligendi?</p>
                </div>
                <div class="box">
                    <div class="icon">
                        <i class="fas fa-tablet-alt"></i>
                    </div>
                    <div class="topic">Apps Devlopment</div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia autem quam odio, qui voluptatem eligendi?</p>
                </div>
            </div>
        </div>
    </section>


    <!-- Footer Section Start -->
    <footer>
        <div class="text">
            <span>Created By <a href="">Itenas</a> | &#169; 2023 All Rights Reserved</span>
        </div>
    </footer>

    <script src="script.js"></script>
</body>

</html>