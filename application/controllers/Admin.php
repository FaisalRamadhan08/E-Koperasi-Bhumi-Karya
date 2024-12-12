<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        if ($this->session->userdata('login') != 1) {
            $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Maaf! </strong>Anda belum login.</div>');
            redirect('auth');
        } else {
            if ($this->session->userdata('aktif') <= 2) {
                if ($this->session->userdata('level') == 1) {
                    redirect('user');
                }
            }
        }
    }

    public function index()
    {
        // TITTLE
        $data['title'] = 'Home';
        $data['sub_title'] = 'Dashboard';
        $data['status'] = 'Admin';
        $data['corp_name'] = 'BPN';
        $data['kelompok'] = 'Itenas';

        $data['user'] = $this->app_models->getUserTable('user');
        $data['userdata'] = $this->app_models->getUserTable('user');
        $data['total_anggota'] = $this->db->get_where('user', ['aktif' => 2])->num_rows();
        $data['anggota_pending'] = $this->db->get_where('user', ['aktif' => 1])->num_rows();

        $data['transaksi_pinjaman'] = $this->app_models->getTransaksi('pinjaman');
        $data['total_peminjam'] = $this->app_models->getNumRow('pinjaman');
        // $data['total_penyimpan'] = $this->app_models->getNumRow('simpanan');
        $data['total_penyimpan'] = $this->app_models->getNumRow('simpanan');
        $data['transaksi_simpanan'] = $this->app_models->getTransaksi('simpanan');

        // $total = $this->app_models->getTotalSP();
        // $persen = $total['simpanan'] + $total['pinjaman'];
        // // $pinjam = ($total_pinjaman - $total_simpanan) * 100;

        // $data['total'] = $total['simpanan'] + $total['pinjaman'];
        // $data['total_simpanan'] = $total['simpanan'];
        // $data['total_pinjaman'] = $total['pinjaman'];
        // $data['simpanan'] = round(($total['simpanan'] / $persen) * 100);
        // $data['pinjaman'] = round(($total['pinjaman'] / $persen) * 100);

        $total = $this->app_models->getTotalSP();
        $persen = $total['simpanan'] + $total['pinjaman'];

        $data['total'] = $total['simpanan'] + $total['pinjaman'];
        $data['total_simpanan'] = $total['simpanan'];
        $data['total_pinjaman'] = $total['pinjaman'];

        // Check if $persen is not zero before performing the division
        $data['simpanan'] = ($persen != 0) ? round(($total['simpanan'] / $persen) * 100) : 0;
        $data['pinjaman'] = ($persen != 0) ? round(($total['pinjaman'] / $persen) * 100) : 0;




        // $total = $this->app_models->getTotalSP();
        // $persen = $total['simpanan'] + $total['pinjaman'];

        // Periksa apakah $persen tidak sama dengan nol sebelum melakukan pembagian
        // if ($persen != 0) {
        //     $data['total'] = $total['simpanan'] + $total['pinjaman'];
        //     $data['total_simpanan'] = $total['simpanan'];
        //     $data['total_pinjaman'] = $total['pinjaman'];
        //     $data['simpanan'] = round(($total['simpanan'] / $persen) * 100);
        //     $data['pinjaman'] = round(($total['pinjaman'] / $persen) * 100);
        // } else {
        //     // Tangani kasus khusus jika $persen sama dengan nol
        //     $data['total'] = 0;
        //     $data['total_simpanan'] = 0;
        //     $data['total_pinjaman'] = 0;
        //     $data['simpanan'] = 0;
        //     $data['pinjaman'] = 0;
        //     // Atau Anda bisa menetapkan nilai default atau memberikan pesan kesalahan
        // }


        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }
}
