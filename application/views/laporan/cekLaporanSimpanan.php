<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="<?= base_url('assets/js/jquery.table2excel.js') ?>"></script>
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
                        <div class="btn-group" role="group" style="display: flex; justify-content:space-between;">
                            <!-- <a class="" href="<?= base_url('laporan/printSimpanan/pdf/' . $tgl_awal . '/' . $tgl_akhir . '/' . $jenis_laporan) ?>">
                                <button type="button" class="btn btn-primary">Cetak</button>
                            </a> -->

                            <a class="" href="<?= base_url('laporan/printSimpanan') ?>">
                                <button type="button" class="btn btn-warning btn-sm" style="margin :0 5px;"><i class='fas fa-download' style="margin-left: -5px;"></i> Cetak</button>
                            </a>

                            <a class="" href="<?= base_url('laporan/export') ?>">
                                <button type="button" class="btn btn-primary btn-sm" style="size:20px 50px; margin :0 10px;"><i class='fas fa-print' style="margin-left: -5px;"></i> Excel</button>
                            </a>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="myTable">
                                <thead>
                                    <tr>
                                        <th class="center">No Simpanan</th>
                                        <th class="center">NIP</th>
                                        <th>Nama Anggota</th>
                                        <th class="center">Simpanan</th>
                                        <th class="center">Tanggal Simpanan</th>
                                        <th class="center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($simpanan as $sm) : ?>
                                        <tr>
                                            <td>SM-<?= $sm['no_simpanan'] ?></td>
                                            <td><?= $sm['nip'] ?></td>
                                            <td><?= $sm['nama_lengkap'] ?></td>
                                            <td><?= 'Rp. ' . number_format($sm['simpanan'], 2, ',', '.') ?></td>
                                            <td><?= $sm['tgl_simpanan'] ?></td>
                                            <td><?php if ($sm['status'] == 2) {
                                                    echo 'Aktif';
                                                } elseif ($sm['status'] == 1) {
                                                    echo 'Pending';
                                                } else {
                                                    echo 'Ditolak';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-sm-5"> </div>
                            <div class="col-lg-4 col-sm-5 ms-auto">
                                <table class="table table-clear">
                                    <tbody>
                                        <tr>
                                            <td class="left fs-18"><strong>Total Simpanan</strong></td>
                                            <td class="right fs-18">
                                                <!-- <strong><?= 'Rp. ' . number_format($totalSimpanan, 2, ',', '.') ?></strong> -->
                                                <?php
                                                if ($totalSimpanan !== null) {
                                                    echo '<strong>' . 'Rp. ' . number_format($totalSimpanan, 2, ',', '.') . '</strong>';
                                                } else {
                                                    echo '<strong>Simpanan Tidak Tersedia</strong>';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal fade" id="basicModal">
                            <div class="modal-dialog" role="document">
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
                                            <input type="text" class="form-control" value="<?= $user['username'] ?>" readonly name="username" hidden>
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
    </div>

    <script>
        $("button").click(function() {
            $("#myTable").table2excel();
        });
    </script>