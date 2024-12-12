<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Simpanan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        if ($this->session->userdata('login') != 1) {
            $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Maaf! </strong>Anda belum login.</div>');
            redirect('auth');
        } else {
            if ($this->session->userdata('aktif') < 2) {
                if ($this->session->userdata('level') < 2) {
                    if ($this->session->userdata('level') < 2) {
                        redirect('user');
                    }
                }
            }
        }
    }

    public function index()
    {
        if ($this->session->userdata('level') == 1) {
            redirect('simpanan/user');
        }
        $data['title'] = 'Simpanan';
        $data['sub_title'] = 'Data Simpanan';
        $data['status'] = 'Admin';
        $data['corp_name'] = 'BPN';
        $data['kelompok'] = 'Itenas';


        $data['user'] = $this->app_models->getUserTable('user');
        $data['userdata'] = $this->app_models->getUserTable('user');
        $data['validasiSimpanan'] = $this->app_models->validasiSimpanan();
        $data['tanggal'] = new DateTime();
        // Tambahkan baris berikut untuk mendapatkan dataSimpanan
        $data['dataSimpanan'] = $this->app_models->getDataSimpanan();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('simpanan/index', $data);
        $this->load->view('templates/footer');
    }

    public function user()
    {
        $data['title'] = 'Simpanan';
        $data['sub_title'] = 'Detail Simpanan';
        $data['status'] = 'User';
        $data['corp_name'] = 'BPN';
        $data['kelompok'] = 'Itenas';


        $data['user'] = $this->app_models->getUserTable('user');
        $data['userdata'] = $this->app_models->getUserTable('user');

        $id_anggota = $this->session->userdata('id_anggota');
        $data['tanggal'] = new DateTime();

        $data['validasiSimpanan'] = $this->app_models->validasiSimpanan();
        $data['simpanan_pokok'] = $this->app_models->getSimpananPokok($id_anggota);
        $data['simpanan_wajib'] = $this->app_models->getSimpananWajib($id_anggota);
        $data['simpanan_sukarela'] = $this->app_models->getSimpananSukarela($id_anggota);

        $data['dataSimpanan'] = $this->app_models->getDataSimpananUser();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('simpanan/user', $data);
        $this->load->view('templates/footer');
    }

    // public function tambah()
    // {
    //     $data = [
    //         'id_anggota' => htmlspecialchars($this->input->post('id_anggota', true)),
    //         'username' => htmlspecialchars($this->input->post('username', true)),
    //         'tgl_simpanan' => $this->input->post('tgl_simpanan'),
    //         'simpanan' => htmlspecialchars($this->input->post('simpanan', true)),
    //         'jenis_simpanan' => htmlspecialchars($this->input->post('jenis_simpanan', true)),
    //         'status' => 2
    //     ];
    //     $this->db->insert('simpanan', $data);

    //     $this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible fade show"><strong>Berhasil menambah simpanan! </strong>Periksa kembali bukti bayar anda.</div>');
    //     redirect('simpanan');
    // }
    public function tambah()
    {
        $data = [
            'id_anggota' => htmlspecialchars($this->input->post('id_anggota', true)),
            'tgl_simpanan' => $this->input->post('tgl_simpanan'),
            'simpanan' => htmlspecialchars($this->input->post('simpanan', true)),
            'jenis_simpanan' => htmlspecialchars($this->input->post('jenis_simpanan', true)),
            'status' => 2
        ];
        $this->db->insert('simpanan', $data);

        $this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible fade show"><strong>Berhasil menambah simpanan! </strong>Periksa kembali bukti bayar anda.</div>');
        redirect('simpanan');
    }




    public function GetDataSimpanan($no_simpanan)
    {
        $this->db->Where('no_simpanan', $no_simpanan);
        $Query = $this->db->Get('simpanan');
        return $Query->Row();
    }

    public function UpdateDataSimpanan($no_simpanan, $data)
    {
        $this->db->Where('no_simpanan', $no_simpanan);
        $this->db->Update('simpanan', $data);
    }

    public function edit()
    {
        $no_simpanan = $this->input->post('no_simpanan');
        // $this->db->Where('no_simpanan', $no_simpanan);
        $data = [
            // 'username' => htmlspecialchars($this->input->post('username', true)),
            'tgl_simpanan' => $this->input->post('tgl_simpanan'),
            'simpanan' => htmlspecialchars($this->input->post('simpanan', true)),
            'jenis_simpanan' => htmlspecialchars($this->input->post('jenis_simpanan', true)),
            'status' => 2
        ];
        // $this->db->insert('simpanan', $data);

        // $this->db->where('no_simpanan', $no_simpanan);
        // $this->db->update('simpanan', $data);
        $this->UpdateDataSimpanan($no_simpanan, $data);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible fade show"><strong>Berhasil Mengubah simpanan! </strong>Periksa kembali bukti bayar anda.</div>');
        } else {
            $error = $this->db->error();
            $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal mengedit simpanan! </strong>Periksa kembali data yang diinput. Error: ' . $error['message'] . '</div>');
        }
        // $this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible fade show"><strong>Berhasil Mengubah simpanan! </strong>Periksa kembali bukti bayar anda.</div>');
        redirect('simpanan');
    }

    public function tambah_user()
    {
        $data = [
            'id_anggota' => htmlspecialchars($this->input->post('id_anggota', true)),
            'tgl_simpanan' => $this->input->post('tgl_simpanan'),
            'simpanan' => htmlspecialchars($this->input->post('simpanan', true)),
            'jenis_simpanan' => htmlspecialchars($this->input->post('jenis_simpanan', true)),
            'status' => 1
        ];

        // Log the data for debugging
        log_message('debug', 'Inserting simpanan data: ' . print_r($data, true));

        // Perform the insertion
        $this->db->insert('simpanan', $data);

        $this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible fade show"><strong>Berhasil menambah simpanan! </strong>Periksa kembali bukti bayar anda.</div>');
        redirect('simpanan/user');
    }


    public function hapus($no_simpanan)
    {
        $this->db->delete('simpanan', ['no_simpanan' => $no_simpanan]);

        $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Berhasil! </strong>Data dihapus.</div>');
        redirect('simpanan');
    }


    public function tolak($no_simpanan)
    {
        $query = "UPDATE `simpanan` 
                SET `status`    = 0
                WHERE `no_simpanan` = '$no_simpanan'
                ";

        $this->db->query($query);
        $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Berhasil! </strong>Menolak pembayaran user.</div>');
        redirect('simpanan');
    }

    public function setuju($no_simpanan)
    {
        $query = "UPDATE `simpanan` 
                SET `status`    = 2
                WHERE `no_simpanan` = '$no_simpanan'
                ";

        $this->db->query($query);
        $this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible fade show"><strong>Berhasil! </strong>Mengonfirmasi pembayaran user.</div>');
        redirect('simpanan');
    }
}
