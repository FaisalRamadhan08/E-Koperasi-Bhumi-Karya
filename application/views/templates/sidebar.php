<!--**********************************
            Sidebar start
        ***********************************-->
<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="dropdown header-profile">
                <a class="nav-link" href="<?= base_url('pengguna/profile') ?>">

                    <img src="<?= base_url('assets/images/profile/') . $user['profil'] ?>" width="20" alt="">
                    <div class="header-info ms-3">
                        <span class="font-w600 ">Hi, <b style="font-size: 14px;"><?= $user['nama_lengkap'] ?></b></span>
                        <small class=" font-w400"><?= $user['username'] ?></small>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a href="<?= base_url('pengguna/profile') ?>" class="dropdown-item ai-icon">
                        <svg id="icon-user1" xmln s="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <span class="ms-2">Profile </span>
                    </a>
                    <a href="<?= base_url('logout') ?>" class="dropdown-item ai-icon">
                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        <span class="ms-2">Logout </span>
                    </a>
                </div>
            </li>

            <?php
            $level = $this->session->userdata('level');
            $queryMenu = "SELECT `user_menu`.`id`, `menu`, `icon`
									FROM `user_menu` JOIN `user_access_menu`
									ON `user_menu`.`id` = `user_access_menu`.`menu_id`
									WHERE `user_access_menu`.`role_id` = $level
									ORDER BY `user_access_menu`.`menu_id` ASC";

            $menu = $this->db->query($queryMenu)->result_array();
            ?>

            <?php if ($level == 2) : ?>
                <li>
                    <?php if ($level == 2) : ?>
                        <a href="<?= base_url('admin') ?>" class="ai-icon" aria-expanded="false">
                        <?php else : ?>
                            <a href="<?= base_url('user') ?>" class="ai-icon" aria-expanded="false">
                            <?php endif; ?>
                            <i class="flaticon-024-dashboard"></i>
                            <span class="nav-text">Dashboard</span>
                            </a>

                </li>

                <li>
                    <a href="<?= base_url('pengguna') ?>" class="ai-icon" aria-expanded="false">
                        <i class="flaticon-381-user-9"></i>
                        <span class="nav-text">Pengguna</span>
                    </a>
                </li>
                <li class="mm-active">
                    <!-- <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="true"> -->
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-381-add-3"></i>
                        <span class="nav-text">Pinjaman</span>
                    </a>
                    <ul aria-expanded="false">
                        <ul aria-expanded="false">
                            <li><a href="<?= base_url('pinjaman') ?>">Data Pinjaman</a></li>
                            <li><a href="<?= base_url('pinjaman/tagihan') ?>">Tagihan Pinjaman</a></li>

                            <!-- <li><a href="<?= base_url($sm['url']) ?>"><?= $sm['title'] ?></a></li> -->

                        </ul>
                    </ul>

                </li>

                <li>
                    <a href="<?= base_url('simpanan/') ?>" class="ai-icon" aria-expanded="false">
                        <i class="flaticon-381-add-1"></i>
                        <span class="nav-text">Simpanan</span>
                    </a>
                </li>


                <li>
                    <a href="<?= base_url('shu') ?>" class="ai-icon" aria-expanded="false">
                        <i class="flaticon-381-clock"></i>
                        <span class="nav-text">Riwayat</span>
                    </a>
                </li>

                <li>
                    <a href="<?= base_url('laporan') ?>" class="ai-icon" aria-expanded="false">
                        <i class="flaticon-072-printer"></i>
                        <span class="nav-text">Laporan</span>
                    </a>
                </li>

                <li>
                    <a href="<?= base_url('simulasi') ?>" class="ai-icon" aria-expanded="false">
                        <i class="flaticon-381-calculator-1"></i>
                        <span class="nav-text">Simulasi</span>
                    </a>
                </li>


            <?php else : ?>
                <li>
                    <?php if ($level == 2) : ?>
                        <a href="<?= base_url('admin') ?>" class="ai-icon" aria-expanded="false">
                        <?php else : ?>
                            <a href="<?= base_url('user') ?>" class="ai-icon" aria-expanded="false">
                            <?php endif; ?>
                            <i class="flaticon-024-dashboard"></i>
                            <span class="nav-text">Dashboard</span>
                            </a>

                </li>
                <li class="mm-active">
                    <!-- <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="true"> -->
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-381-add-3"></i>
                        <span class="nav-text">Pinjaman</span>
                    </a>
                    <ul aria-expanded="false">
                        <ul aria-expanded="false">
                            <li><a href="<?= base_url('pinjaman') ?>">Data Pinjaman</a></li>
                            <li><a href="<?= base_url('pinjaman/tagihan_User') ?>">Tagihan Pinjaman</a></li>

                            <!-- <li><a href="<?= base_url($sm['url']) ?>"><?= $sm['title'] ?></a></li> -->

                        </ul>
                    </ul>
                </li>
                <li>
                    <a href="<?= base_url('simpanan/user') ?>" class="ai-icon" aria-expanded="false">
                        <i class="flaticon-381-add-1"></i>
                        <span class="nav-text">Simpanan</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('shu') ?>" class="ai-icon" aria-expanded="false">
                        <i class="flaticon-381-clock"></i>
                        <span class="nav-text">Riwayat</span>
                    </a>
                </li>

                <li>
                    <a href="<?= base_url('simulasi') ?>" class="ai-icon" aria-expanded="false">
                        <i class="flaticon-381-calculator-1"></i>
                        <span class="nav-text">Simulasi</span>
                    </a>
                </li>




            <?php endif; ?>




        </ul>
        </li>


        </ul>
        <!-- <div class="copyright">
    <p><strong><?= $corp_name . ' ' . $status . ' ' . $sub_title ?></strong> © 2023 All Rights Reserved</p>
    <p class="fs-12">Made with <span class="heart"></span> <?= $kelompok ?></p>
</div> -->
    </div>
</div>
<!--**********************************
            Sidebar end
        ***********************************-->