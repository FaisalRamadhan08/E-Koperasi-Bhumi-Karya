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
                        <button class="btn btn-primary btn-rounded btn-md mx-3" data-bs-toggle="modal" data-bs-target="#basicModal">Tambah Simpanan</button>

                    </div>
                    <div class="card-body">
                        <?= $this->session->flashdata('alert_message') ?>
                        <div class="table-responsive">
                            <table id="example4" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>No Simpanan</th>
                                        <th>NIP</th>
                                        <th>Username</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Simpanan</th>
                                        <th>Jenis Simpanan</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    // $dataSimpanan = $this->db->get('simpanan')->result_array();
                                    $dataSimpanan = $this->db->select('simpanan.*, user.username as user_username,user.nip')->from('simpanan')->join('user', 'simpanan.id_anggota = user.id_anggota', 'left')->get()->result_array();


                                    foreach ($dataSimpanan as $ds) :
                                    ?>
                                        <tr>
                                            <td>SM-<?= $ds['no_simpanan'] ?></td>
                                            <td><?= $ds['nip'] ?></td>
                                            <!-- <td><?= $ds['username'] ?></td> -->
                                            <td><?= $ds['user_username'] ?? 'N/A'; ?></td>
                                            <td><?= $ds['tgl_simpanan'] ?></td>
                                            <!-- <td><?= "Rp. " . number_format($ds['simpanan'], 2, ',', '.'); ?></td> -->
                                            <td>
                                                <?php
                                                if ($ds['simpanan'] !== null) {
                                                    echo '<span class="fs-16 text-black font-w600">' . 'Rp. ' . number_format($ds['simpanan'], 2, ',', '.') . '</span>';
                                                } else {
                                                    echo '<span class="fs-16 text-black font-w600">Rp. 0,00</span>'; // Atau nilai default lainnya
                                                }
                                                ?>
                                            </td>

                                            <td><?= $ds['jenis_simpanan'] ?></td>
                                            <td>
                                                <?php if ($ds['status'] == 2) : ?>
                                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modal<?= $ds['no_simpanan'] ?>"><span class="badge light badge-success">Disetujui</span></a>
                                                <?php elseif ($ds['status'] == 1) : ?>
                                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modal<?= $ds['no_simpanan'] ?>"><span class="badge light badge-warning">Pending</span></a>
                                                <?php else : ?>
                                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modal<?= $ds['no_simpanan'] ?>"><span class="badge light badge-danger">Ditolak</span></a>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <!-- <a href="<?= base_url('pengguna/edit_form/' . $ds['no_simpanan']); ?>" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a> -->

                                                    <button class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#myModal<?= $ds['no_simpanan'] ?>"><i class="fas fa-pencil-alt"></i></button>

                                                    <a href="<?= base_url('simpanan/hapus/' . $ds['no_simpanan']); ?>" class="btn btn-danger shadow btn-xs sharp" onclick="return confirm('Anda yakin mau menghapus item ini ?')"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>

                                        <div class="bootstrap-modal">
                                            <!-- Modal -->
                                            <div class="modal fade" id="modal<?= $ds['no_simpanan'] ?>">
                                                <div class="modal-dialog " role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Konfirmasi Simpanan</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">Konfirmasi apakah impanan anggota diterima
                                                            atau ditolak.</div>
                                                        <div class="modal-footer">
                                                            <a href="<?= base_url('simpanan/tolak/') . $ds['no_simpanan']; ?>"><button type="button" class="btn btn-sm btn-danger light">Tolak</button></a>
                                                            <a href="<?= base_url('simpanan/setuju/') . $ds['no_simpanan']; ?>"><button type="button" class="btn btn-sm btn-primary">Setuju</button></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="bootstrap-modal">
                                            <div class="modal" id="myModal<?= $ds['no_simpanan'] ?>">
                                                <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Simpanan</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= base_url('simpanan/edit') ?>" method="POST">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Username</label>
                                                                    <input type="text" class="form-control" value="<?= $ds['user_username'] ?>" name="username" readonly>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Tanggal</label>
                                                                    <input type="date" class="form-control" value="<?= $tanggal->format('Y-m-d') ?>" name="tgl_simpanan">
                                                                </div>
                                                                <input type="text" class="form-control" value="<?= $user['username'] ?>" readonly name="username" hidden>
                                                                <input type="text" class="form-control" value="<?= $user['id_anggota'] ?>" readonly name="id_anggota" hidden>
                                                                <input type="text" class="form-control" value="<?= $ds['no_simpanan'] ?>" readonly name="no_simpanan" hidden>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Simpanan</label>
                                                                    <input type="number" class="form-control" value="<?= $ds['simpanan'] ?>" name="simpanan">
                                                                </div>

                                                                <?php if (set_value('username')) {
                                                                    var_dump(set_value('username'));
                                                                    die;
                                                                } ?>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Jenis Simpanan</label>
                                                                    <select class="default-select form-control wide mb-3" name="jenis_simpanan">
                                                                        <option selected disabled value="">Pilih Simpanan</option>
                                                                        <option>Simpanan Pokok</option>
                                                                        <option>Simpanan Wajib</option>
                                                                        <!-- <option>Simpanan Sukarela</option> -->
                                                                    </select>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Tutup</button>
                                                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                            </form>
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
                    <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="contoh" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="contoh">Tambah Simpanan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="<?= base_url('simpanan/tambah') ?>" method="POST">
                                        <div class="mb-3">
                                            <label class="form-label">Tanggal</label>
                                            <input type="date" class="form-control" value="<?= $tanggal->format('Y-m-d') ?>" name="tgl_simpanan">
                                        </div>
                                        <input type="text" class="form-control" value="<?= $user['username'] ?>" readonly name="username" hidden>
                                        <input type="text" class="form-control" value="<?= $user['id_anggota'] ?>" readonly name="id_anggota" hidden>
                                        <div class="mb-3">
                                            <label class="form-label">Simpanan</label>
                                            <input type="number" class="form-control" placeholder="Rp" name="simpanan" required oninvalid="this.setCustomValidity('Simpanan harus di isi!')" oninput="this.setCustomValidity('')">
                                        </div>
                                        <!-- <div class="mb-3">
                                            <label class="form-label">User</label>
                                            <select class="default-select form-control wide mb-3" name="username" required>
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

                                        <?php if (set_value('username')) {
                                            var_dump(set_value('username'));
                                            die;
                                        } ?>
                                        <div class="mb-3">
                                            <label class="form-label">Jenis Simpanan</label>
                                            <select class="default-select form-control wide mb-3" name="jenis_simpanan" required>
                                                <option selected disabled value="">Pilih Simpanan</option>
                                                <option>Simpanan Pokok</option>
                                                <option>Simpanan Wajib</option>
                                                <!-- <option>Simpanan Sukarela</option> -->
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-primary">Tambah Simpanan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Edit -->


                </div>

            </div>
            <script>
                var exampleModal = document.getElementById('myModal')
                exampleModal.addEventListener('show.bs.modal', function(event) {
                    // Button that triggered the modal
                    var button = event.relatedTarget
                    // Extract info from data-bs-* attributes
                    // var recipient = button.getAttribute('data-bs-whatever')
                    // If necessary, you could initiate an AJAX request here
                    // and then do the updating in a callback.
                    //
                    // Update the modal's content.
                    var modalTitle = exampleModal.querySelector('.modal-title')
                    var modalBodyInput = exampleModal.querySelector('.modal-body input')

                    modalTitle.textContent = 'New message to ' + recipient
                    // modalBodyInput.value = recipient
                })
            </script>

        </div>