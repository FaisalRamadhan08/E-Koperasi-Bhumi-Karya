<!--**********************************
            Content body start
        ***********************************-->
<style>
    @keyframes fadeInOut {
        0% {
            opacity: 0;
        }

        50% {
            opacity: 0.5;
        }

        100% {
            opacity: 1;
        }
    }

    .toggle-password {
        cursor: pointer;
        animation: fadeInOut 0.5s ease;
    }
</style>

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)"><?= $title ?></a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?= $sub_title ?></a></li>
            </ol>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="profile card card-body px-3 pt-3 pb-0">
                    <div><br><br> <br></div>
                    <div class="profile-head">
                        <div class="photo-content">
                            <!-- <div class="cover-photo rounded"></div> -->
                        </div>
                        <div class="profile-info">
                            <div class="profile-photo">
                                <img src="<?= base_url('assets/images/profile/') . $userdata['profil'] ?>" class="img-fluid rounded-circle" alt="">
                            </div>
                            <div class="profile-details">
                                <div class="profile-name px-3 pt-2">
                                    <h4 class="text-primary mb-0"><?= $userdata['nama_lengkap'] ?></h4>
                                    <p><?= $userdata['alamat'] ?></p>
                                </div>
                                <div class="profile-email px-2 pt-2">
                                    <h4 class="text-muted mb-0"><?= $userdata['username'] ?></h4>
                                    <p><?= $userdata['no_hp'] ?></p>
                                </div>
                                <!-- <div style="display: flex; justify-content:right; margin-left:500px;">
                                    <a href="<?= base_url('pengguna/change_pass') ?>">
                                        <button class="btn btn-primary">Change Pass</button>
                                    </a>
                                </div> -->
                                <!-- <div style="display: flex; justify-content:right; margin-left:500px;">
                                    <a href="<?= base_url('pengguna/change_pass') ?>">
                                        <button class="btn btn-primary">Change Pass</button>
                                    </a>
                                </div> -->

                            </div>
                        </div>
                        <div class="col-xl-12 col-xxl-12">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title mt-2">Total Simpanan</h4>
                                            <div class="d-flex align-items-center mt-3 mb-2">
                                                <h2 class="fs-25 mb-0 me-3">
                                                    <?php
                                                    if ($total_simpanan == null) {
                                                        echo 'Rp. ' . number_format(0, 2, ',', '.');
                                                    } else {
                                                        echo 'Rp. ' . number_format($total_simpanan, 2, ',', '.');
                                                    } ?></h2>
                                                <!-- <span class="badge badge-success badge-xl">+0.5%</span> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title mt-2">Total Pinjaman</h4>
                                            <div class="d-flex align-items-center mt-3 mb-2">
                                                <h2 class="fs-25 mb-0 me-3">
                                                    <?php
                                                    if ($total_pinjaman == null) {
                                                        echo 'Rp. ' . number_format(0, 2, ',', '.');
                                                    } else {
                                                        echo 'Rp. ' . number_format($total_pinjaman, 2, ',', '.');
                                                    } ?></h2>
                                                <!-- <span class="badge badge-danger badge-xl">+6.4%</span> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-xxl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?= $sub_title ?></h4>
                    </div>
                    <div class="col-xl-12 col-lg-12">
                        <div class="card-body">
                            <div class="basic-form">
                                <?= form_open_multipart('pengguna/edit_profile'); ?>
                                <?= $this->session->flashdata('alert_message') ?>
                                <input type="text" class="form-control" placeholder="id_anggota" value="<?= $userdata['id_anggota']; ?>" name="id_anggota" id="id_anggota" hidden>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">NIP</label>
                                    <div class="col-sm-9">
                                        <!-- <input type="text" class="form-control" placeholder="Username" value="<?= $userdata['username']; ?>" name="username" id="username"> -->
                                        <input type="text" class="form-control" placeholder="NIP" value="<?= $userdata['nip']; ?>" name="nip" id="nip">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Username</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="Username" value="<?= $userdata['username']; ?>" name="username" id="username">
                                    </div>
                                </div>
                                <!-- <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Password</label>
                                    <div class="col-sm-9 input group">
                                        <input type="password" class="form-control" placeholder="Password" value="<?= $userdata['password']; ?>" name="password" id="password">
                                        <span class="" id="togglePassword">
                                            <i class="bi bi-eye" onclick="togglePasswordVisibility()"></i>
                                        </span>
                                    </div>
                                </div> -->
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Password</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="password" class="form-control" placeholder="Password" value="<?= $userdata['password']; ?>" name="password" id="password">
                                            <div class="input-group-append">
                                                <span class="input-group-text" style="margin-left: 20px; margin-top:10px;">
                                                    <i class="toggle-password fa fa-eye" onclick="togglePasswordVisibility()"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Nama Lengkap</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="Nama Lengkap" value="<?= $userdata['nama_lengkap']; ?>" name="nama_lengkap" id="nama_lengkap">
                                    </div>
                                </div>
                                <!-- <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Tempat Lahir</label>
                                    <div class="col-sm-9">

                                        <input type="text" class="form-control" placeholder="Tempat Lahir" name="tempat_lahir" id="tempat_lahir" value="<?= $user['tempat_lahir']; ?>">

                                        <?php if (form_error('tempat_lahir')) : ?>
                                            <?= form_error('tempat_lahir', '<div class="invalid-feedback-active">', '</div>') ?>
                                        <?php endif; ?>
                                    </div>
                                </div> -->
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Tanggal Lahir</label>
                                    <div class="col-sm-9">

                                        <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" value="<?= $userdata['tanggal_lahir']; ?>">


                                        <?php if (form_error('tanggal_lahir')) : ?>
                                            <?= form_error('tanggal_lahir', '<div class="invalid-feedback-active">', '</div>') ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Jenis Kelamin</label>
                                    <div class="col-sm-9">

                                        <select class="default-select form-control wide" name="jenis_kelamin" id="jenis_kelamin" value="<?= $userdata['jenis_kelamin']; ?>">
                                            <?php if ($user['jenis_kelamin'] == 'Laki - Laki') : ?>
                                                <option data-display="<?= $user['jenis_kelamin'] ?>">Laki - Laki
                                                </option>
                                                <option value="Perempuan">Perempuan</option>
                                            <?php else : ?>
                                                <option data-display="<?= $user['jenis_kelamin'] ?>">Perempuan
                                                </option>
                                                <option value="Laki - Laki">Laki - Laki</option>
                                            <?php endif; ?>
                                        </select>
                                        <?php if (form_error('jenis_kelamin')) : ?>
                                            <?= form_error('jenis_kelamin', '<div class="invalid-feedback-active">', '</div>') ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Alamat</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="Alamat" name="alamat" id="alamat" value="<?= $userdata['alamat']; ?>">

                                        <?php if (form_error('alamat')) : ?>
                                            <?= form_error('alamat', '<div class="invalid-feedback-active">', '</div>') ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">No HP</label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" placeholder="No HP" name="no_hp" id="no_hp" value="<?= $userdata['no_hp']; ?>">

                                        <?php if (form_error('no_hp')) : ?>
                                            <?= form_error('no_hp', '<div class="invalid-feedback-active">', '</div>') ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Foto Profile</label>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-file-input form-control" name="profil" id="profil">
                                    </div>
                                </div>
                                <!-- <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Jenis Bank</label>
                                    <div class="col-sm-9">
                                        <select class="default-select form-control wide mb-4" name="bank" required>

                                            <option selected disabled value=""><?= $userdata['bank'] ?></option>
                                            <option>BNI</option>
                                            <option>BCA</option>
                                            <option>BRI</option>
                                            <option>BJB</option>
                                            <option>Mandiri</option>
                                        </select>
                                    </div>
                                </div> -->
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">No Rekening</label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" placeholder="No Rekening" value="<?= $userdata['no_rek']; ?>" name="no_rek" id="no_rek">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById("password");
        var toggleIcon = document.querySelector(".toggle-password");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleIcon.classList.remove("fa-eye");
            toggleIcon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            toggleIcon.classList.remove("fa-eye-slash");
            toggleIcon.classList.add("fa-eye");
        }
    }
</script>
<!--**********************************
            Content body end
        ***********************************-->