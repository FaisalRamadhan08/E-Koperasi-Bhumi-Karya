<div>
    <div class="row">
        <div class="col-lg-12">

            <div>
                <div class="card-header"> Invoice <strong><?= $tanggal->format('d-m-Y') ?></strong> <span class="float-end">
                        <strong>Status:</strong> Pending</span> </div>
                <div class="card-body">
                    <div class="d-flex mb-5 justify-content-center">
                        <div class="d-flex align-items-center flex-column col-xl-3 col-lg-3 col-md-6 col-sm-12">
                            <img src="<?= base_url('assets/images/bpn.png') ?>" style="width: 100px; heigth: 100px; display:flex; float:left; margin-left: -600px;" alt="">
                            <img src="<?= base_url('assets/images/kopbpn.png') ?>" style="width: 100px; heigth: 100px; display:flex; float:left; margin-left:600px; margin-top:-90px;" alt="">
                            <div>
                                <h6 style="font-family:monsterat; font-size:30px; font-weight:bold; display: flex; margin-top:-80px;">LAPORAN SIMPANAN PER- KOPERASI</h6>

                            </div>
                            <div style="font-family:monsterat; font-size:20px; font-weight:bold; display: flex; margin-top:-40px; color:gray;">
                                BPN KOTA BANDUNG

                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="center">No Simpanan</th>
                                    <th>Nama Anggota</th>
                                    <th class="center">Simpanan</th>
                                    <th class="center">Tanggal Simpanan</th>
                                    <th class="center">Jenis Simpanan</th>
                                    <th class="center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($simpanan as $sm) : ?>
                                    <tr>
                                        <td>SM-<?= $sm['no_simpanan'] ?></td>
                                        <td><?= $sm['nama_lengkap'] ?></td>
                                        <td><?= 'Rp. ' . number_format($sm['simpanan'], 2, ',', '.') ?></td>
                                        <td><?= $sm['tgl_simpanan'] ?></td>
                                        <td><?= $sm['jenis_simpanan'] ?></td>
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
                                            <strong><?= 'Rp. ' . number_format($totalSimpanan, 2, ',', '.') ?></strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--**********************************
        Scripts
    ***********************************-->
<!-- Required vendors -->
<script src="<?= base_url(); ?>assets/vendor/global/global.min.js"></script>
<!-- Datatable -->
<script src="<?= base_url(); ?>assets/vendor/datatables/js/jquery.dataTables.min.js">
</script>
<script src="<?= base_url(); ?>assets/js/plugins-init/datatables.init.js"></script>

<script src="<?= base_url(); ?>assets/js/custom.min.js"></script>
<script src="<?= base_url(); ?>assets/js/dlabnav-init.js"></script>
<script src="<?= base_url(); ?>assets/js/demo.js"></script>

<script>
    var delayInMilliseconds = 1000; //1 second

    setTimeout(function() {
        window.print();
    }, delayInMilliseconds);
</script>

</body>

</html>