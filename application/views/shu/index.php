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
                        <?php if ($this->session->userdata('level') == 2) : ?>
                            <!-- <div class="dropdown inline">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-bs-toggle="dropdown" aria-expanded="true" aria-haspopup="true">
                                    <i class="fa fa-download"></i> Export
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li><a class="dropdown-item" href=" <?= base_url('laporan/printSHU') ?>">PDF</a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('laporan/printExcel') ?>">Excel</a></li>
                                </ul>
                            </div> -->
                            <a class="btn btn-primary btn-rounded btn-md mx-3" href="<?= base_url('laporan/printSHU') ?>">Cetak Laporan</a>
                            <!-- <a class="btn btn-primary btn-rounded btn-md mx-3" href="<?= base_url('laporan/printExcel') ?>">Cetak Laporan</a> -->
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example4" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Username</th>
                                        <th>Simpanan</th>
                                        <th>Pinjaman</th>
                                        <!-- <th>SHU Simpanan</th>
                                        <th>SHU Pinjaman</th>
                                        <th>Total SHU</th> -->

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $sql = "SELECT SUM(`simpanan`) AS simpananshu FROM `simpanan` WHERE `jenis_simpanan` = 'Simpanan Pokok' OR jenis_simpanan = 'Simpanan Wajib'";
                                    $shusimpanan = $this->db->query($sql)->row_array();
                                    $shusimpanan = $shusimpanan['simpananshu'];


                                    $sql = "SELECT SUM(`pinjaman_pokok`) AS pinjamanshu FROM `pinjaman`";
                                    $shupinjaman = $this->db->query($sql)->row_array();
                                    $shupinjaman = $shupinjaman['pinjamanshu'];
                                    if ($this->session->userdata('level') == 2) :
                                        $users = $this->db->get('user')->result_array();



                                        // var_dump($shupinjaman);
                                        // var_dump($shusimpanan);
                                        // die;

                                        foreach ($users as $user) :
                                            $id_anggota = $user['id_anggota'];
                                            $query = " SELECT `id_anggota`, (SELECT SUM(`pinjaman_pokok`) FROM `pinjaman` WHERE `id_anggota` = '$id_anggota' AND keterangan = '2') AS pinjaman,
                                                    (SELECT SUM(`simpanan`) FROM `simpanan`  WHERE `id_anggota` = '$id_anggota' AND status = '2') AS simpanan
                                                    FROM `user` WHERE `id_anggota` = '$id_anggota'";
                                            $total = $this->db->query($query)->row_array();
                                            // simpanan / jumlah seluruh simpanan x 20% x 40000000 = 800000
                                            // echo round(($total['simpanan'] / $shusimpanan['simpananshu']), 3);
                                            // die;
                                            if ($total['simpanan'] == NULL) {
                                                $shus = 0;
                                            } else {
                                                $shus = ($total['simpanan']);
                                                $shus = floor($shus);
                                            }

                                            // (nilai pinjamannya / 20000000) * 25% * 10000000
                                            if ($total['pinjaman'] == NULL) {
                                                $shup = 0;
                                            } else {

                                                $shup = ($total['pinjaman']);
                                                $shup = floor($shup);
                                            }

                                            $totalshu = $shus + $shup;
                                    ?> <?php if ($user['level'] == 1) : ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td class="text"><?= $user['username'] ?></td>
                                                    <?php if ($total['simpanan'] == NULL) : ?>
                                                        <td>-</td>
                                                    <?php else : ?>
                                                        <td><?= "Rp. " . number_format($total['simpanan'], 2, ',', '.'); ?></td>
                                                    <?php endif; ?>

                                                    <?php if ($total['pinjaman'] == NULL) : ?>
                                                        <td>-</td>
                                                    <?php else : ?>
                                                        <td><?= "Rp. " . number_format($total['pinjaman'], 2, ',', '.'); ?></td>
                                                    <?php endif; ?>


                                                </tr>
                                            <?php endif; ?>
                                    <?php endforeach;
                                    endif; ?>
                                    <?php
                                    $no = 1;
                                    if ($this->session->userdata('level') == 1) :

                                        $id_anggota = $this->session->userdata('id_anggota');
                                        $query = " SELECT `id_anggota`, (SELECT SUM(`pinjaman_pokok`) FROM `pinjaman` WHERE `id_anggota` = '$id_anggota' AND keterangan = '2') AS pinjaman,
                                                    (SELECT SUM(`simpanan`) FROM `simpanan`  WHERE `id_anggota` = '$id_anggota' AND status = '2') AS simpanan
                                                    FROM `user` WHERE `id_anggota` = '$id_anggota'";
                                        $total = $this->db->query($query)->row_array();

                                        if ($total['simpanan'] == NULL) {
                                            $shus = 0;
                                        } else {
                                            $shus = ($total['simpanan'] / $shusimpanan) * ((20 / 100) * 10000000);
                                            $shus = floor($shus);
                                        }

                                        // (nilai pinjamannya / 20000000) * 25% * 10000000
                                        if ($total['pinjaman'] == NULL) {
                                            $shup = 0;
                                        } else {

                                            $shup = ($total['pinjaman'] / $shupinjaman) * ((25 / 100) * 10000000);
                                            $shup = floor($shup);
                                        }

                                        $totalshu = $shus + $shup;

                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td class=""><?= $user['username'] ?></td>
                                            <?php if ($total['simpanan'] == NULL) : ?>
                                                <td>-</td>
                                            <?php else : ?>
                                                <td><?= "Rp. " . number_format($total['simpanan'], 2, ',', '.'); ?></td>
                                            <?php endif; ?>

                                            <?php if ($total['pinjaman'] == NULL) : ?>
                                                <td>-</td>
                                            <?php else : ?>
                                                <td><?= "Rp. " . number_format($total['pinjaman'], 2, ',', '.'); ?></td>
                                            <?php endif; ?>

                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>