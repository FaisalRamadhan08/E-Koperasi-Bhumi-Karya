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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?= $sub_title ?></h4>
                        <div class="d-flex">
                            <button class="btn btn-primary btn-block btn-rounded" data-bs-toggle="modal" data-bs-target="#basicModal">Tambah Pinjaman</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?= $this->session->flashdata('alert_message') ?>
                        <div class="table-responsive">
                            <table id="example4" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>No Pinjaman</th>
                                        <th>Keterangan</th>
                                        <th>NIP</th>
                                        <th>Username</th>
                                        <th>Pinjaman Pokok</th>
                                        <th>Bunga</th>
                                        <th>Jangka Waktu</th>
                                        <th>Tanggal Pinjaman</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Angsuran</th>
                                        <th>Status</th>
                                        <?php if ($user['level'] == 2) : ?>
                                            <th>
                                                Action
                                            </th>
                                        <?php else : ?>
                                            <th hidden>
                                                Action
                                            </th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // if ($user['level'] == 2) {
                                    //     $datapinjaman;
                                    // } else {
                                    //     // $datapinjaman = $this->db->get_where('pinjaman', ['id_anggota' => $user['id_anggota']])->result_array();
                                    // }


                                    foreach ($datapinjaman as $dp) :
                                    ?>
                                        <tr>
                                            <td>PJ-<?= $dp['no_pinjaman'] ?></td>
                                            <?php if ($user['level'] == 2) : ?>
                                                <td>
                                                    <?php if ($dp['keterangan'] == 2) : ?>
                                                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modal<?= $dp['no_pinjaman'] ?>"><span class="badge light badge-success">Disetujui</span></a>
                                                    <?php elseif ($dp['keterangan'] == 1) : ?>
                                                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modal<?= $dp['no_pinjaman'] ?>"><span class="badge light badge-warning">Pending</span></a>
                                                    <?php else : ?>
                                                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modal<?= $dp['no_pinjaman'] ?>"><span class="badge light badge-danger">Ditolak</span></a>
                                                    <?php endif; ?>
                                                </td>
                                            <?php else : ?>
                                                <td>
                                                    <?php if ($dp['keterangan'] == 2) : ?>
                                                        <span class="badge light badge-success">Disetujui</span>
                                                    <?php elseif ($dp['keterangan'] == 1) : ?>
                                                        <span class="badge light badge-warning">Pending</span>
                                                    <?php else : ?>
                                                        <span class="badge light badge-danger">Ditolak</span>
                                                    <?php endif; ?>
                                                </td>
                                            <?php endif; ?>
                                            <td><?= $dp['nip'] ?></td>
                                            <td><?= $dp['username'] ?></td>
                                            <td><?= "Rp. " . number_format($dp['pinjaman_pokok'], 1, ',', '.') ?></td>
                                            <td><?= $dp['bunga'] . '%' ?></td>
                                            <td><?= $dp['jangka_waktu'] . ' Bulan' ?></td>
                                            <td><?= $dp['tgl_pinjaman'] ?></td>
                                            <td><?= $dp['tgl_selesai'] ?></td>
                                            <td><?= "Rp. " . number_format($dp['angsuran'], 2, ',', '.') ?></td>
                                            <td>
                                                <?php if ($dp['status'] == 1) : ?>
                                                    <span class="badge light badge-success">Lunas</span>
                                                <?php else : ?>
                                                    <span class="badge light badge-danger">Belum Lunas</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($user['level'] == 2) : ?>
                                                    <div class="d-flex">
                                                        <!-- <a href="<?= base_url('pinjaman/edit/' . $dp['no_pinjaman']); ?>" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a> -->
                                                        <button class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#myModal<?= $dp['no_pinjaman'] ?>"><i class="fas fa-pencil-alt"></i></button>
                                                        <a href="<?= base_url('pinjaman/hapus/' . $dp['no_pinjaman']); ?>" class="btn btn-danger shadow btn-xs sharp" onclick="return confirm('Anda yakin mau menghapus item ini ?')"><i class="fa fa-trash"></i></a>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <div class="bootstrap-modal">
                                            <!-- Modal -->
                                            <div class="modal fade" id="modal<?= $dp['no_pinjaman'] ?>">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Konfirmasi Pinjaman</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">Konfirmasi apakah pinjaman anggota diterima
                                                            atau ditolak.</div>
                                                        <div class="modal-footer">
                                                            <a href="<?= base_url('pinjaman/tolak/') . $dp['no_pinjaman']; ?>"><button type="button" class="btn btn-sm btn-danger light">Tolak</button></a>
                                                            <a href="<?= base_url('pinjaman/setuju/') . $dp['no_pinjaman']; ?>"><button type="button" class="btn btn-sm btn-primary">Setuju</button></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Edit Pinjaman -->
                                        <div class="modal fade" id="myModal<?= $dp['no_pinjaman'] ?>">
                                            <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Pinjaman</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="<?= base_url('pinjaman/edit') ?>" method="POST">
                                                            <input type="text" class="form-control" value="<?= $dp['no_pinjaman'] ?>" readonly name="no_pinjaman" hidden>
                                                            <!-- <div class="mb-3">
                                                                <label class="form-label">Tanggal</label>
                                                                <input type="date" class="form-control" value="<?= $tanggal->format('Y-m-d') ?>" readonly name="tgl_pinjaman">
                                                            </div> -->
                                                            <div class="mb-3">
                                                                <label class="form-label">Tanggal</label>
                                                                <input type="date" class="form-control" value="<?= $tanggal->format('Y-m-d') ?>" readonly name="tgl_pinjaman">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Username</label>
                                                                <input type="text" class="form-control" value="<?= $dp['username'] ?>" readonly name="username">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Jumlah</label>
                                                                <input type="number" class="form-control" name="pinjaman_pokok" value="<?= $dp['pinjaman_pokok'] ?>">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Bunga (%)</label>
                                                                <input type="number" class="form-control" placeholder="%" name="bunga" value="1" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Jangka Waktu</label>
                                                                <input type="number" class="form-control" placeholder="Bulan" name="jangka_waktu" required oninvalid="this.setCustomValidity('Jangka Waktu harus diisi!')" oninput="this.setCustomValidity('')">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Tutup</button>
                                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal fade" id="basicModal">
                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Pinjaman</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="<?= base_url('pinjaman/tambah') ?>" method="POST">
                                        <div class="mb-3">
                                            <label class="form-label">Tanggal</label>
                                            <input type="date" class="form-control" value="<?= $tanggal->format('Y-m-d') ?>" readonly name="tgl_pinjaman">
                                        </div>
                                        <!-- <div class="mb-3">
                                            <label class="form-label">Tanggal</label>
                                            <input type="date" class="form-control" value="<?= $tanggal->format('Y-m-d') ?>" readonly name="tgl_pinjaman">
                                        </div> -->
                                        <input type="text" class="form-control" value="<?= $user['username'] ?>" readonly name="username" hidden>
                                        <input type="text" class="form-control" value="<?= $user['id_anggota'] ?>" readonly name="id_anggota" hidden>
                                        <?php if ($user['level'] == 2) : ?>
                                            <!-- <input type="text" class="form-control" value="<?= $user['username'] ?>" readonly name="username" hidden>
                                            <div class="mb-3">
                                                <label class="form-label">User</label>
                                                <select class="default-select form-control wide mb-3" id="username" name="username" required>
                                                    <option selected disabled value="">Pilih Username</option>
                                                    <?php $users = $this->db->get('user')->result_array();
                                                    foreach ($users as $user) : ?>
                                                        <option><?= $user['username'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div> -->
                                            <div class="mb-3">
                                                <label class="form-label">User</label>
                                                <select class="default-select form-control wide mb-3" name="id_anggota" required>
                                                    <option selected disabled value="">Pilih Anggota</option>
                                                    <?php foreach ($users as $userOption) : ?>
                                                        <option value="<?= $userOption['id_anggota'] ?>"><?= $userOption['username'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        <?php else : ?>
                                            <div class="mb-3">
                                                <label class="form-label">User</label>
                                                <input type="text" class="form-control" value="<?= $user['username'] ?>" readonly name="username">
                                            </div>
                                        <?php endif; ?>
                                        <?php if (set_value('username')) {
                                            var_dump(set_value('username'));
                                            die;
                                        } ?>
                                        <div class="mb-3">
                                            <label class="form-label">Jumlah</label>
                                            <input type="number" class="form-control" placeholder="Rp" name="pinjaman_pokok" required oninvalid="this.setCustomValidity('Jumlah harus di isi!')" oninput="this.setCustomValidity('')">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Bunga (%)</label>
                                            <input type="number" class="form-control" placeholder="%" name="bunga" value="1" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Jangka Waktu</label>
                                            <input type="number" class="form-control" placeholder="Bulan" name="jangka_waktu" required oninvalid="this.setCustomValidity('Jangka Waktu harus diisi!')" oninput="this.setCustomValidity('')">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-primary">Tambah Pinjaman</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <script type="text/javascript">
        $(document).ready(function() {
            $('#username').select2();
        });
    </script> -->
</div>