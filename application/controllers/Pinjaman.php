<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pinjaman extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');

        if ($this->session->userdata('login') != 1) {
            $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Maaf! </strong>Anda belum login.</div>');
            redirect('auth');
        } else {
            if ($this->session->userdata('aktif') < 0) {
                redirect('user');
            }
        }
    }

    public function index()
    {
        $data['title'] = 'Pinjaman';
        $data['sub_title'] = 'Data Pinjaman';
        $data['status'] = 'User';
        $data['corp_name'] = 'BPN';
        $data['kelompok'] = 'Itenas';
        $data['user'] = $this->app_models->getUserTable('user');
        $data['userdata'] = $this->app_models->getUserTable('user');
        $data['tanggal'] = new DateTime();
        $data['userdataPengguna'] = $this->app_models->getAnggota();
        // Tambahkan baris berikut untuk mendapatkan dataSimpanan
        $id_anggota = $this->session->userdata('id_anggota');

        $level = $this->app_models->getLevel($id_anggota);

        if ($level == 2) {
            $data['datapinjaman'] = $this->app_models->getDataPinjamanAdmin();
        } else {
            $data['datapinjaman'] = $this->app_models->getDataPinjaman();
        }


        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pinjaman/index', $data);
        $this->load->view('templates/footer');
    }

    public function tagihan()
    {
        $data['title'] = 'Pinjaman';
        $data['sub_title'] = 'Tagihan Pinjaman';
        $data['status'] = 'Admin';
        $data['corp_name'] = 'BPN';
        $data['kelompok'] = 'Itenas';
        $data['user'] = $this->app_models->getUserTable('user');
        $data['userdata'] = $this->app_models->getUserTable('user');
        $data['tanggal'] = new DateTime();
        $data['userdataPengguna'] = $this->app_models->getAnggota();

        // $data['angsuran'] = $this->app_models->getDataAngsuran();
        $id_anggota = $this->session->userdata('id_anggota');
        $level = $this->app_models->getLevel($id_anggota);

        if ($level == 2) {
            $data['angsuran'] = $this->app_models->getDataAngsuran();
        } else {
            $data['angsuran'] = $this->app_models->getDataAngsuranUser();
        }
        // $user = $this->db->get_where('pinjaman', ['username' => $username])->row_array();
        // $data['username'] = $user;
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pinjaman/tagihan', $data);
        $this->load->view('templates/footer');
    }
    public function tagihan_User()
    {
        $data['title'] = 'Pinjaman';
        $data['sub_title'] = 'Tagihan Pinjaman';
        $data['status'] = 'User';
        $data['corp_name'] = 'BPN';
        $data['kelompok'] = 'Itenas';
        $data['user'] = $this->app_models->getUserTable('user');
        $data['userdata'] = $this->app_models->getUserTable('user');
        $data['tanggal'] = new DateTime();
        $data['userdataPengguna'] = $this->app_models->getAnggota();

        // $data['angsuran'] = $this->app_models->getDataAngsuran();
        $id_anggota = $this->session->userdata('id_anggota');
        $level = $this->app_models->getLevel($id_anggota);


        $data['angsuran'] = $this->app_models->getDataAngsuranUser();
        // $user = $this->db->get_where('pinjaman', ['username' => $username])->row_array();
        // $data['username'] = $user;
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pinjaman/tagihan_User', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data['userdata'] = $this->app_models->getUserTable('user');
        $userdata1 = $data['userdata'];

        $simpanan = $this->app_models->getTotalSP();
        $statusPinjaman = $this->app_models->getStatusPinjaman();
        $jumlahPinjaman = $this->app_models->getJumlahStatusPinjaman();

        // if ($simpanan['simpanan'] < $this->input->post('pinjaman_pokok')) {
        //     echo "Tidak bisa pinjam";
        //     $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal Pinjam! </strong>Maaf simpananmu kurang dari pinjamanmu.</div>');
        //     redirect('pinjaman');
        // } else {
        //     $simpanan = "Boleh pinjam";
        // }

        if ($jumlahPinjaman > 0) {
            if ($statusPinjaman == 0) {
                $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal meminjam! </strong>Silahkan selesaikan pinjaman sebelumnya.</div>');
                redirect('pinjaman');
            }
        }


        $tanggal = $this->input->post('tgl_pinjaman');
        $jangka_waktu = '+' . $this->input->post('jangka_waktu') . ' months';
        $tgl_selesai = date('Y-m-d', strtotime($tanggal . $jangka_waktu));

        $angsuran = $this->input->post('pinjaman_pokok') / $this->input->post('jangka_waktu') + ($this->input->post('pinjaman_pokok') * ($this->input->post('bunga') / 100));
        if ($userdata1['level'] == 2) {
            $data = [
                'id_anggota' => htmlspecialchars($this->input->post('id_anggota', true)),
                // 'username' => htmlspecialchars($this->input->post('username', true)),
                'pinjaman_pokok' => htmlspecialchars($this->input->post('pinjaman_pokok', true)),
                'bunga' => htmlspecialchars($this->input->post('bunga', true)),
                'tgl_pinjaman' => htmlspecialchars($this->input->post('tgl_pinjaman', true)),
                'jangka_waktu' => htmlspecialchars($this->input->post('jangka_waktu', true)),
                'tgl_selesai' => $tgl_selesai,
                'keterangan' => 2,
                'angsuran' => $angsuran
            ];
        } else {
            $data = [
                'id_anggota' => htmlspecialchars($this->input->post('id_anggota', true)),
                // 'username' => htmlspecialchars($this->input->post('username', true)),
                'pinjaman_pokok' => htmlspecialchars($this->input->post('pinjaman_pokok', true)),
                'bunga' => htmlspecialchars($this->input->post('bunga', true)),
                'tgl_pinjaman' => htmlspecialchars($this->input->post('tgl_pinjaman', true)),
                'jangka_waktu' => htmlspecialchars($this->input->post('jangka_waktu', true)),
                'tgl_selesai' => $tgl_selesai,
                'keterangan' => 1,
                'angsuran' => $angsuran
            ];
        }

        $this->db->insert('pinjaman', $data);

        $this->_angsuran();
    }

    public function GetDataPinjaman($no_pinjaman)
    {
        $this->db->Where('no_pinjaman', $no_pinjaman);
        $Query = $this->db->Get('pinjaman');
        return $Query->Row();
    }

    public function UpdateDataPinjaman($no_pinjaman, $data)
    {
        $this->db->Where('no_pinjaman', $no_pinjaman);
        $this->db->Update('pinjaman', $data);
    }

    public function GetDataAngsuran($no_pinjaman)
    {
        $this->db->Where('no_pinjaman', $no_pinjaman);
        $Query = $this->db->Get('pinjaman');
        return $Query->Row();
    }

    public function edit()
    {
        $simpanan = $this->app_models->getTotalSP();
        $statusPinjaman = $this->app_models->getStatusPinjaman();
        $jumlahPinjaman = $this->app_models->getJumlahStatusPinjaman();

        // if ($simpanan['simpanan'] < $this->input->post('pinjaman_pokok')) {
        //     echo "Tidak bisa pinjam";
        //     $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal Pinjam! </strong>Maaf simpananmu kurang dari pinjamanmu.</div>');
        //     redirect('pinjaman');
        // } else {
        //     $simpanan = "Boleh pinjam";
        // }

        // if ($jumlahPinjaman > 0) {
        //     if ($statusPinjaman == 0) {
        //         $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal meminjam! </strong>Silahkan selesaikan pinjaman sebelumnya.</div>');
        //         redirect('pinjaman');
        //     }
        // }
        $no_pinjaman = $this->input->post('no_pinjaman');


        $tanggal = $this->input->post('tgl_pinjaman');
        $jangka_waktu = '+' . $this->input->post('jangka_waktu') . ' months';
        $tgl_selesai = date('Y-m-d', strtotime($tanggal . $jangka_waktu));

        $angsuran = $this->input->post('pinjaman_pokok') / $this->input->post('jangka_waktu') + ($this->input->post('pinjaman_pokok') * ($this->input->post('bunga') / 100));
        $data = [
            // 'username' => htmlspecialchars($this->input->post('username', true)),
            'pinjaman_pokok' => htmlspecialchars($this->input->post('pinjaman_pokok', true)),
            'bunga' => htmlspecialchars($this->input->post('bunga', true)),
            'tgl_pinjaman' => htmlspecialchars($this->input->post('tgl_pinjaman', true)),
            'jangka_waktu' => htmlspecialchars($this->input->post('jangka_waktu', true)),
            'tgl_selesai' => $tgl_selesai,
            'angsuran' => $angsuran
        ];

        // $this->db->Where('no_simpanan', $no_pinjaman);
        // $this->db->Update('pinjaman', $data);
        $this->UpdateDataPinjaman($no_pinjaman, $data);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible fade show"><strong>Berhasil mengubah pinjaman! </strong></div>');
        } else {
            $error = $this->db->error();
            $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal mengedit pinjaman! </strong>Periksa kembali data yang diinput. Error: ' . $error['message'] . '</div>');
        }
        $this->_editangsuran();
    }
    // public function edit()
    // {
    //     // Mendapatkan ID pinjaman yang akan diupdate
    //     $no_pinjaman = $this->input->post('no_pinjaman'); // Sesuaikan dengan field yang sesuai

    //     // Data baru untuk update
    //     $data_pinjaman = array(
    //         'pinjaman_pokok' => $this->input->post('pinjaman_pokok'),
    //         'bunga' => $this->input->post('bunga'),
    //         'tgl_pinjaman' => $this->input->post('tgl_pinjaman'),
    //         'jangka_waktu' => $this->input->post('jangka_waktu'),
    //         // tambahkan field lain sesuai kebutuhan
    //     );

    //     // Melakukan update data pinjaman
    //     $this->db->where('no_pinjaman', $no_pinjaman);
    //     $this->db->update('pinjaman', $data_pinjaman);

    //     $query = "SELECT * FROM pinjaman WHERE no_pinjaman = '$no_pinjaman'";
    //     $pinjaman = $this->db->query($query)->row_array();

    //     $angsuran_ke = 1;
    //     while ($angsuran_ke <= $jangka_waktu) {

    //         if ($angsuran_ke == 1) {
    //             $sisa = ($pinjaman['angsuran'] * $pinjaman['jangka_waktu']) - $pinjaman['angsuran'];
    //         } else {
    //             $query = "SELECT * FROM angsuran WHERE no_pinjaman = '$no_pinjaman' ORDER BY id DESC LIMIT 1";
    //             $last_angsuran = $this->db->query($query)->row_array();
    //             $sisa = $last_angsuran['sisa'] - $last_angsuran['bayar'];
    //         }

    //         $angsuran = '+' . $angsuran_ke . ' months';
    //         $jatuh_tempo = date('Y-m-d', strtotime($tanggal . $angsuran));

    //         $data = [
    //             'id_anggota' => $pinjaman['id_anggota'],
    //             'angsuran' => $angsuran_ke,
    //             'jatuh_tempo' => $jatuh_tempo,
    //             'bayar' => $pinjaman['angsuran'],
    //             'sisa' => $sisa,
    //             'denda' => 0,
    //             'jumlah' => $pinjaman['angsuran'] + 0,
    //             'status' => 0
    //         ];

    //         // Melakukan update data angsuran
    //         $this->db->where('no_pinjaman', $no_pinjaman);
    //         $this->db->update('angsuran', $data);
    //         $angsuran_ke++;
    //     }
    //     // Memberikan pesan sukses
    //     $this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible fade show"><strong>Berhasil update! </strong>Data pinjaman dan angsuran telah diperbarui.</div>');

    //     // Redirect ke halaman pinjaman
    //     redirect('pinjaman');
    // }

    private function _angsuran()
    {

        $tanggal = $this->input->post('tgl_pinjaman');
        $jangka_waktu = $this->input->post('jangka_waktu');

        $this->app_models->angsuran($tanggal, $jangka_waktu);
        $this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible fade show"><strong>Berhasil meminjam! </strong>Silahkan tunggu admin menyetujui.</div>');
        redirect('pinjaman');
    }
    private function _editangsuran()
    {
        $no_pinjaman = $this->input->post('no_pinjaman');
        $tanggal = $this->input->post('tgl_pinjaman');
        $jangka_waktu = $this->input->post('jangka_waktu');


        $this->app_models->editAngsuran($no_pinjaman, $tanggal, $jangka_waktu);
        $this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible fade show"><strong>Berhasil ! </strong>Mengubah data.</div>');
        redirect('pinjaman');
    }

    public function setuju($no_pinjaman)
    {
        $this->app_models->setSetuju($no_pinjaman);
        $this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible fade show"><strong>Selamat! </strong>Anda berhasil menyetujui pinjaman anggota.</div>');
        redirect('pinjaman');
    }

    public function bayar()
    {
        $id = $this->input->post('id');
        $no_pinjaman = $this->input->post('no_pinjaman');
        $tgl_bayar = $this->input->post('tgl_bayar');

        $this->app_models->setBayar($tgl_bayar, $id, $no_pinjaman);
        $this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible fade show"><strong>Berhasil Membayar! </strong>Akan dicek kembali oleh admin.</div>');
        redirect('pinjaman/tagihan');
    }

    public function tolak($id)
    {
        $this->app_models->setTolak($id);
        $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Berhasil! </strong>Menolak pembayaran user.</div>');
        redirect('pinjaman/tagihan');
    }
    public function hapus($no_pinjaman)
    {
        $this->db->delete('angsuran', ['no_pinjaman' => $no_pinjaman]);
        $this->db->delete('pinjaman', ['no_pinjaman' => $no_pinjaman]);

        $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Berhasil! </strong>Data dihapus.</div>');
        redirect('pinjaman');
    }
    public function hapusAngsuran($id)
    {
        $this->db->delete('angsuran', ['id' => $id]);

        $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Berhasil! </strong>Data dihapus.</div>');
        redirect('tagihan');
    }

    public function konfirmasi($id, $no_pinjaman)
    {
        $this->app_models->setKonfirmasi($id, $no_pinjaman);
        $this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible fade show"><strong>Berhasil! </strong>Mengonfirmasi pembayaran user.</div>');
        redirect('pinjaman/tagihan');
    }
}
