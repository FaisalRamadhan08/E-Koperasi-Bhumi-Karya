<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // if ($this->session->userdata('login') != 1) {
        //     $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Maaf! </strong>Anda belum login.</div>');
        //     redirect('auth');
        // } else {
        //     if ($this->session->userdata('aktif') < 2) {
        //         redirect('daftar');
        //     }
        // }
    }

    public function index()
    {
        // TITLE
        $data['title'] = 'Home';
        $data['sub_title'] = 'Dashboard';
        $data['status'] = 'User';
        $data['corp_name'] = 'BPN';
        $data['kelompok'] = 'Itenas';

        // QUERY
        $id_anggota = $this->session->userdata('id_anggota');

        $data['user'] = $this->app_models->getUserTable('user');
        $data['userdata'] = $this->app_models->getUserTable('user');
        $data['jumlah_pinjaman'] = $this->app_models->getWhereNumRow('pinjaman');
        $data['jumlah_simpanan'] = $this->app_models->getWhereNumRow('simpanan');

        $data['transaksi_simpanan'] = $this->app_models->getUserTransaksi('simpanan', $id_anggota);
        $data['transaksi_pinjaman'] = $this->app_models->getUserTransaksi('pinjaman', $id_anggota);

        $query = " SELECT `id_anggota`, (SELECT SUM(`pinjaman_pokok`) FROM `pinjaman` WHERE `id_anggota` = '$id_anggota') AS pinjaman, (SELECT SUM(`simpanan`) FROM `simpanan`  WHERE `id_anggota` = '$id_anggota') AS simpanan FROM `user` WHERE `id_anggota` = '$id_anggota' ";
        $total = $this->app_models->getUserTotalSP($id_anggota);
        $persen = $total['simpanan'] + $total['pinjaman'];


        $data['total'] = $total['simpanan'] + $total['pinjaman'];
        $data['total_simpanan'] = $total['simpanan'];
        $data['total_pinjaman'] = $total['pinjaman'];
        $data['total'] = $total['simpanan'] + $total['pinjaman'];
        if ($persen != 0) {
            $data['simpanan'] = round(($total['simpanan'] / $persen) * 100);
            $data['pinjaman'] = round(($total['pinjaman'] / $persen) * 100);
        } else {
            $data['simpanan'] = 0;
            $data['pinjaman'] = 0;
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer', $data);
    }
}
