<!--**********************************
            Content body start
        ***********************************-->
<div class="content-body">
    <div class="container-fluid">

        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)"><?= $title ?></a></li>
            </ol>
        </div>
        <!-- row -->


        <div class="row">
            <!-- PENGURUS -->
            <div class="col-12" id="pengurus">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Pengurus</h4>
                        <button class="btn btn-primary btn-rounded btn-md mx-3" data-bs-toggle="modal" data-bs-target="#basicModal1">Tambah Pengurus</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Status</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Tanggal lahir</th>
                                        <th>Jenis kelamin</th>
                                        <th>Alamat</th>
                                        <th>No HP</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($userdataPengurus as $ud) :
                                    ?>
                                        <tr>

                                            <td><img class="rounded-circle" width="35" src="<?= base_url('assets/images/profile/') . $ud['profil'] ?>" alt="">
                                            </td>
                                            <td>
                                                <?php if ($ud['aktif'] == 2) : ?>
                                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modal<?= $ud['username'] ?>"><span class="badge light badge-success">Aktif</span></a>
                                                <?php elseif ($ud['aktif'] == 1) : ?>
                                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modal<?= $ud['username'] ?>"><span class="badge light badge-warning">Pending</span></a>
                                                <?php else : ?>
                                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modal<?= $ud['username'] ?>"><span class="badge light badge-danger">Belum Aktif</span></a>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= $ud['nama_lengkap'] ?></td>
                                            <td><?= $ud['username'] ?></td>
                                            <!-- <td><?= $ud['tempat_lahir'] ?></td> -->
                                            <td><?= $ud['tanggal_lahir'] ?></td>
                                            <td><a href="javascript:void(0);"><?= $ud['jenis_kelamin'] ?></a></td>
                                            <td><a href="javascript:void(0);"><?= $ud['alamat'] ?></a></td>
                                            <td><?= $ud['no_hp'] ?></td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="<?= base_url('pengguna/edit_form/' . $ud['id_anggota']); ?>" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                                                    <a href="<?= base_url('pengguna/hapus/' . $ud['id_anggota']); ?>" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <div class="bootstrap-modal">
                                            <!-- Modal -->
                                            <div class="modal fade" id="modal<?= $ud['id_anggota'] ?>">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Ubah Status</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">Ubah status untuk mengaktifkan user yang
                                                            sedang mendaftar.</div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-sm btn-danger light" data-bs-dismiss="modal">Close</button>
                                                            <?php if ($ud['aktif'] == 2) : ?>
                                                                <a href="<?= base_url('pengguna/nonaktif/') . $ud['id_anggota']; ?>"><button type="button" class="btn btn-sm btn-primary">Nonaktifkan</button></a>
                                                            <?php elseif ($user['aktif'] == 1) : ?>
                                                                <a href="<?= base_url('pengguna/aktif/') . $ud['id_anggota']; ?>"><button type="button" class="btn btn-sm btn-primary">Aktifkan</button></a>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </tbody>
                                <div class="modal fade" id="basicModal1">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Tambah Pengurus</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="<?= base_url('pengguna/tambahAdmin') ?>" method="POST">
                                                    <input type="text" class="form-control" placeholder="id_anggota" value="<?= $user['id_anggota']; ?>" name="id_anggota" id="id_anggota" hidden>
                                                    <div class="mb-3">
                                                        <label class="form-label">NIP</label>
                                                        <input type="text" class="form-control" placeholder="nip" value="<?= $user['nip']; ?>" name="nip" id="nip" required oninvalid="this.setCustomValidity('NIP harus di isi!')" oninput="this.setCustomValidity('')">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Nama Lengkap</label>
                                                        <input type="text" class="form-control" name="nama_lengkap" required oninvalid="this.setCustomValidity('Nama Lengkap harus di isi!')" oninput="this.setCustomValidity('')">
                                                    </div>
                                                    <!-- <input type="text" class="form-control" name="id_user" hidden> -->

                                                    <div class="mb-3">
                                                        <label class="form-label">Username</label>
                                                        <input type="text" class="form-control" name="username" required oninvalid="this.setCustomValidity('Username harus di isi!')" oninput="this.setCustomValidity('')">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Password</label>
                                                        <input type="password" class="form-control" name="password" required oninvalid="this.setCustomValidity('Password harus di isi!')" oninput="this.setCustomValidity('')">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-primary">Tambah</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <!-- ANGGOTA -->
            <div class="col-12" id="anggota">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Anggota</h4>
                        <button class="btn btn-primary btn-rounded btn-md mx-3" data-bs-toggle="modal" data-bs-target="#basicModal">Tambah Anggota</button>
                    </div>
                    <div class="card-body">
                        <?= $this->session->flashdata('alert_message') ?>
                        <div class="table-responsive">
                            <table id="example3" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>NIP</th>
                                        <th>Status</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <!-- <th>Jenis Bank</th> -->
                                        <th>No Rekening</th>

                                        <th>Tanggal lahir</th>
                                        <th>Jenis kelamin</th>
                                        <th>Alamat</th>
                                        <th>No HP</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($userdataPengguna as $ud) :
                                    ?>
                                        <tr>

                                            <td><img class="rounded-circle" width="35" src="<?= base_url('assets/images/profile/') . $ud['profil'] ?>" alt="">
                                            </td>
                                            <td><?= $ud['nip'] ?></td>
                                            <td>
                                                <?php if ($ud['aktif'] == 2) : ?>
                                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modal<?= $ud['id_anggota'] ?>"><span class="badge light badge-success">Aktif</span></a>
                                                <?php elseif ($ud['aktif'] == 1) : ?>
                                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modal<?= $ud['id_anggota'] ?>"><span class="badge light badge-warning">Pending</span></a>
                                                <?php else : ?>
                                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modal<?= $ud['id_anggota'] ?>"><span class="badge light badge-danger">Belum Aktif</span></a>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= $ud['nama_lengkap'] ?></td>
                                            <td><?= $ud['username'] ?></td>
                                            <!-- <td><?= $ud['bank'] ?></td> -->
                                            <td><?= $ud['no_rek'] ?></td>

                                            <td><?= $ud['tanggal_lahir'] ?></td>
                                            <td><a href="javascript:void(0);"><?= $ud['jenis_kelamin'] ?></a></td>
                                            <td><a href="javascript:void(0);"><?= $ud['alamat'] ?></a></td>
                                            <td><?= $ud['no_hp'] ?></td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="<?= base_url('pengguna/edit_form/' . $ud['id_anggota']); ?>" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                                                    <a href="<?= base_url('pengguna/hapus/' . $ud['id_anggota']); ?>" class="btn btn-danger shadow btn-xs sharp" onclick="return confirm('Anda yakin mau menghapus item ini ?')"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <div class="bootstrap-modal">
                                            <!-- Modal -->
                                            <div class="modal fade" id="modal<?= $ud['id_anggota'] ?>">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Ubah Status</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">Ubah status untuk mengaktifkan user yang
                                                            sedang mendaftar.</div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-sm btn-danger light" data-bs-dismiss="modal">Close</button>
                                                            <?php if ($ud['aktif'] == 2) : ?>
                                                                <a href="<?= base_url('pengguna/nonaktif/') . $ud['id_anggota']; ?>"><button type="button" class="btn btn-sm btn-primary">Nonaktifkan</button></a>
                                                            <?php elseif ($ud['aktif'] == 1) : ?>
                                                                <a href="<?= base_url('pengguna/aktif/') . $ud['id_anggota']; ?>"><button type="button" class="btn btn-sm btn-primary">Aktifkan</button></a>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="basicModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Anggota</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="<?= base_url('pengguna/tambah') ?>" method="POST">
                                <input type="text" class="form-control" placeholder="id_anggota" value="<?= $user['id_anggota']; ?>" name="id_anggota" id="id_anggota" hidden>
                                <div class="mb-3">
                                    <label class="form-label">NIP</label>
                                    <input type="text" class="form-control" placeholder="nip" value="<?= $user['nip']; ?>" name="nip" id="nip" required oninvalid="this.setCustomValidity('NIP harus di isi!')" oninput="this.setCustomValidity('')">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="nama_lengkap" required oninvalid="this.setCustomValidity('Nama Lengkap harus di isi!')" oninput="this.setCustomValidity('')">
                                </div>
                                <!-- <input type="text" class="form-control" name="id_user" hidden> -->

                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control" name="username" required oninvalid="this.setCustomValidity('Username harus di isi!')" oninput="this.setCustomValidity('')">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" required oninvalid="this.setCustomValidity('Password harus di isi!')" oninput="this.setCustomValidity('')">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--**********************************
            Content body end
        ***********************************-->