<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pengguna extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');

        // if ($this->session->userdata('login') != 1) {
        //     $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Maaf! </strong>Anda belum login.</div>');
        //     redirect('auth');
        // } else {
        //     if ($this->session->userdata('aktif') < 2) {
        //         if ($this->session->userdata('level') < 2) {
        //             redirect('user');
        //         }
        //     }
        // }
    }

    public function index()
    {
        if ($this->session->userdata('level') == 1) {
            redirect('pengguna/profile');
        }
        // TITLE
        $data['title'] = 'Pengguna';
        $data['sub_title'] = 'Pengguna';
        $data['status'] = 'Admin';
        $data['corp_name'] = 'BPN';
        $data['kelompok'] = 'Itenas';

        $data['user'] = $this->app_models->getUserTable('user');
        // $data['userdata'] = $this->app_models->getUserTable('user');
        $data['userdataPengurus'] = $this->app_models->getPengurus();
        $data['userdataPengguna'] = $this->app_models->getAnggota();
        $data['tanggal'] = new DateTime();

        $id_anggota = $this->session->userdata('id_anggota');

        $data['user'] = $this->app_models->getUserTable('user');
        // $data['userdata'] = $this->app_models->getUserTable('userdata');
        $data['jumlah_pinjaman'] = $this->app_models->getWhereNumRow('pinjaman');
        $data['jumlah_simpanan'] = $this->app_models->getWhereNumRow('simpanan');

        $data['transaksi_simpanan'] = $this->app_models->getUserTransaksi('simpanan', $id_anggota);
        $data['transaksi_pinjaman'] = $this->app_models->getUserTransaksi('pinjaman', $id_anggota);

        // $query = " SELECT `username`, (SELECT SUM(`pinjaman_pokok`) FROM `pinjaman` WHERE `username` = '$username') AS pinjaman, (SELECT SUM(`simpanan`) FROM `simpanan`  WHERE `username` = '$username') AS simpanan FROM `user` WHERE `username` = '$username' ";
        // $total = $this->app_models->getUserTotalSP($username);
        // $persen = $total['simpanan'] + $total['pinjaman'];


        // $data['total'] = $total['simpanan'] + $total['pinjaman'];
        // $data['total_simpanan'] = $total['simpanan'];
        // $data['total_pinjaman'] = $total['pinjaman'];
        // $data['total'] = $total['simpanan'] + $total['pinjaman'];


        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pengguna/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data = [
            'nip' => htmlspecialchars($this->input->post('nip', true)),
            'username' => htmlspecialchars($this->input->post('username', true)),
            'password' => htmlspecialchars($this->input->post('password'), true),
            'nama_lengkap' => htmlspecialchars($this->input->post('nama_lengkap', true)),
            // 'tempat_lahir' => '',
            'tanggal_lahir' => '',
            'jenis_kelamin' => '',
            'alamat' => '',
            'no_hp' => '',
            'profil' => 'default.jpg',
            'no_rek' => '',
            // 'bank' => '',
            'level' => 1,
            'aktif' => 2
        ];
        $this->db->insert('user', $data);

        // $data = [
        //     'username' => htmlspecialchars($this->input->post('username', true)),
        //     'nama_lengkap' => htmlspecialchars($this->input->post('nama_lengkap', true)),
        //     'tempat_lahir' => '',
        //     'tanggal_lahir' => '',
        //     'jenis_kelamin' => '',
        //     'alamat' => '',
        //     'no_hp' => '',
        //     'profil' => 'default.jpg',
        //     'no_rek' => '',
        //     'bank' => ''
        // ];
        // $this->db->insert('userdata', $data);
        $this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible fade show"><strong>Berhasil menambahkan Pengguna! </strong>.</div>');
        redirect('pengguna');
    }

    public function tambahAdmin()
    {
        $data = [
            'nip' => htmlspecialchars($this->input->post('nip', true)),
            'username' => htmlspecialchars($this->input->post('username', true)),
            'password' => htmlspecialchars($this->input->post('password'), true),
            'nama_lengkap' => htmlspecialchars($this->input->post('nama_lengkap', true)),
            // 'tempat_lahir' => '',
            'tanggal_lahir' => '',
            'jenis_kelamin' => '',
            'alamat' => '',
            'no_hp' => '',
            'profil' => 'default.jpg',
            'no_rek' => '',
            // 'bank' => '',
            'level' => 2,
            'aktif' => 2
        ];
        $this->db->insert('user', $data);

        // $data = [
        //     'username' => htmlspecialchars($this->input->post('username', true)),
        //     'nama_lengkap' => htmlspecialchars($this->input->post('nama_lengkap', true)),
        //     'tempat_lahir' => '',
        //     'tanggal_lahir' => '',
        //     'jenis_kelamin' => '',
        //     'alamat' => '',
        //     'no_hp' => '',
        //     'profil' => 'default.jpg',
        //     'no_rek' => '',
        //     'bank' => ''
        // ];
        // $this->db->insert('userdata', $data);
        $this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible fade show"><strong>Berhasil menambahkan Pengguna! </strong>.</div>');
        redirect('pengguna');
    }

    public function profile()
    {
        $data['title'] = 'User';
        $data['sub_title'] = 'Edit Profil';
        $data['status'] = 'Admin';
        $data['corp_name'] = 'BPN';
        $data['kelompok'] = 'Itenas';
        $data['user'] = $this->app_models->getUserTable('user');
        // $data['userdata'] = $this->app_models->getUserTable('userdata');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pengguna/profile', $data);
        $this->load->view('templates/footer');
    }

    public function change_pass()
    {
        $data['title'] = 'Password';
        $data['sub_title'] = 'Ubah Password';
        $data['status'] = 'User';
        $data['corp_name'] = 'BPN';
        $data['kelompok'] = 'Itenas';
        $data['user'] = $this->app_models->getUserTable('user');
        // $data['userdata'] = $this->app_models->getUserTable('userdata');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pengguna/change_pass', $data);
        $this->load->view('templates/footer');
    }

    public function edit_form($id_anggota)
    {
        $data['title'] = 'User';
        $data['sub_title'] = 'Edit Profil';
        $data['status'] = 'Admin';
        $data['corp_name'] = 'BPN';
        $data['kelompok'] = 'Itenas';
        $data['user'] = $this->app_models->getUserTable('user');
        $data['userdata'] = $this->app_models->getSelectedUserDataTable($id_anggota);



        // $data['user'] = $this->app_models->getUserTable('user');
        // $data['userdata'] = $this->app_models->getUserTable('userdata');
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



        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pengguna/edit_form', $data);
        $this->load->view('templates/footer');
    }

    public function edit()
    {
        $this->form_validation->set_rules('nama_lengkap', 'Name', 'required|trim', [
            'required' => 'Nama harus diisi!'
        ]);
        $this->form_validation->set_rules('tempat_lahir', 'Tempat_lahir', 'required|trim', [
            'required' => 'Tempat lahir harus diisi!'
        ]);
        // $this->form_validation->set_rules('tanggal_lahir', 'Tanggal_lahir', 'required', [
        //     'required' => 'Tanggal lahir harus diisi!'
        // ]);
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim', [
            'required' => 'Alamat harus diisi!'
        ]);
        $this->form_validation->set_rules('no_hp', 'No_hp', 'required|trim', [
            'required' => 'No HP harus diisi!'
        ]);
        $this->form_validation->set_rules('password1', 'Password1', 'required|trim|min_length[5]|matches[password2]', [
            'matches' => 'Password tidak sama!',
            'min_length' => 'Password minimal 5 karakter!',
            'required' => 'Password harus diisi!'
        ]);
        $this->form_validation->set_rules('password2', 'Password2', 'matches[password1]');


        if ($this->form_validation->run() == false) {
            $data['title'] = 'User';
            $data['sub_title'] = 'Edit Profil';
            $data['status'] = 'Admin';
            $data['corp_name'] = 'BPN';
            $data['kelompok'] = 'Itenas';
            $data['user'] = $this->app_models->getUserTable('user');
            // $data['userdata'] = $this->app_models->getUserTable('user');

            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('pengguna/edit_form', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'username' => htmlspecialchars($this->input->post('username', true)),
                'no_rek' => htmlspecialchars($this->input->post('no_rek', true)),
                'password' => htmlspecialchars($this->input->post('password1'), true),
                'nama_lengkap' => htmlspecialchars($this->input->post('nama_lengkap', true)),
                // 'tempat_lahir' => htmlspecialchars($this->input->post('tempat_lahir', true)),
                'tanggal_lahir' => $this->input->post('tanggal_lahir'),
                'jenis_kelamin' => htmlspecialchars($this->input->post('jenis_kelamin', true)),
                'alamat' => htmlspecialchars($this->input->post('alamat', true)),
                'no_hp' => htmlspecialchars($this->input->post('no_hp', true)),
                'profil' => 'default.jpg',
                'no_rek' => htmlspecialchars($this->input->post('no_rek', true)),
                'bank' => htmlspecialchars($this->input->post('bank', true))
            ];
            $this->db->where('id_anggota', $data['id_anggota']);
            $this->db->update('user', $data);

            $user = $this->db->get_where('user', ['id_anggota' => $data['id_anggota']])->row_array();

            $this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible fade show"><strong>Selamat! </strong>Anda berhasil merubah data.</div>');
            redirect('pengguna');
        }
    }

    public function hapus($id_anggota)
    {
        $this->db->delete('angsuran', ['id_anggota' => $id_anggota]);
        $this->db->delete('pinjaman', ['id_anggota' => $id_anggota]);
        $this->db->delete('simpanan', ['id_anggota' => $id_anggota]);
        $this->app_models->deleteSelectedUser($id_anggota);

        $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Berhasil! </strong>Data dihapus.</div>');
        redirect('pengguna');
    }

    public function aktif($id_anggota)
    {
        $this->app_models->setAktif($id_anggota);

        $this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible fade show"><strong>Selamat! </strong>Anda berhasil mengaktifkan user.</div>');
        redirect('pengguna');
    }

    public function nonaktif($id_anggota)
    {
        $this->app_models->setNonaktif($id_anggota);

        $this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible fade show"><strong>Selamat! </strong>Anda berhasil menonaktifkan user.</div>');
        redirect('pengguna');
    }


    public function getByid($id)
    {
    }

    // public function edit_profile($username)
    // {

    //     // $this->app_models->editProfile();
    //     $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[userdata.username]', [
    //         'required' => 'Username harus diisi!',
    //         'is_unique' => 'Username sudah digunakan!'
    //     ]);
    //     $this->form_validation->set_rules('tempat_lahir', 'Tempat_lahir', 'required|trim', [
    //         'required' => 'Tempat lahir harus diisi!'
    //     ]);
    //     $this->form_validation->set_rules('tanggal_lahir', 'Tanggal_lahir', 'required', [
    //         'required' => 'Tanggal lahir harus diisi!'
    //     ]);
    //     $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim', [
    //         'required' => 'Alamat harus diisi!'
    //     ]);
    //     $this->form_validation->set_rules('no_hp', 'No_hp', 'required|trim', [
    //         'required' => 'No HP harus diisi!'
    //     ]);
    //     $this->form_validation->set_rules('no_rek', 'No_rek', 'required|trim', [
    //         'required' => 'No Rekening harus diisi!'
    //     ]);
    //     // $this->form_validation->set_rules('bank', 'Bank', 'required|trim', [
    //     //     'required' => 'Bank harus diisi!'
    //     // ]);

    //     if ($this->form_validation->run() == false) {
    //         $data['title'] = 'User';
    //         $data['sub_title'] = 'Edit Profil';
    //         $data['corp_name'] = 'Itenas';
    //         $data['user'] = $this->app_models->getUserTable('user');
    //         $data['userdata'] = $this->app_models->getUserTable('userdata');

    //         // $this->load->view('templates/header', $data);
    //         // $this->load->view('templates/navbar', $data);
    //         // $this->load->view('templates/sidebar', $data);
    //         // $this->load->view('pengguna/edit_form/', $data);
    //         // $this->load->view('templates/footer');
    //         $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal! </strong>Semua data harus diisi!.</div>');
    //         redirect('pengguna/edit_form/' . $this->input->post('username'));
    //     } else {
    //         $config['upload_path']          = './assets/images/profile';
    //         $config['allowed_types']        = 'gif|jpg|png';
    //         $config['max_size']             = 10240;
    //         $config['max_width']            = 10000;
    //         $config['max_height']           = 10000;

    //         $this->load->library('upload', $config);

    //         if (!$this->upload->do_upload('profil')) {
    //             $data = [
    //                 'username' => htmlspecialchars($this->input->post('username', true)),
    //                 'nama_lengkap' => htmlspecialchars($this->input->post('nama_lengkap', true)),
    //                 'no_rek' => htmlspecialchars($this->input->post('no_rek', true)),
    //                 // 'bank' => htmlspecialchars($this->input->post('bank', true)),
    //                 'tempat_lahir' => htmlspecialchars($this->input->post('tempat_lahir', true)),
    //                 'tanggal_lahir' => $this->input->post('tanggal_lahir'),
    //                 'jenis_kelamin' => htmlspecialchars($this->input->post('jenis_kelamin', true)),
    //                 'alamat' => htmlspecialchars($this->input->post('alamat', true)),
    //                 'no_hp' => htmlspecialchars($this->input->post('no_hp', true)),
    //                 'profil' => 'default.jpg'
    //             ];
    //             $this->db->where('username', $data['username']);
    //             $this->db->update('userdata', $data);

    //             $this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible fade show"><strong>Selamat! </strong>Anda berhasil mengubah data.</div>');
    //             redirect('pengguna');
    //         } else {
    //             $profil =  $this->upload->data('file_name');
    //             $data = [
    //                 'username' => htmlspecialchars($this->input->post('username', true)),
    //                 'nama_lengkap' => htmlspecialchars($this->input->post('nama_lengkap', true)),
    //                 'no_rek' => htmlspecialchars($this->input->post('no_rek', true)),
    //                 // 'bank' => htmlspecialchars($this->input->post('bank', true)),
    //                 'tempat_lahir' => htmlspecialchars($this->input->post('tempat_lahir', true)),
    //                 'tanggal_lahir' => $this->input->post('tanggal_lahir'),
    //                 'jenis_kelamin' => htmlspecialchars($this->input->post('jenis_kelamin', true)),
    //                 'alamat' => htmlspecialchars($this->input->post('alamat', true)),
    //                 'no_hp' => htmlspecialchars($this->input->post('no_hp', true)),
    //                 'profil' => $profil

    //             ];
    //             $this->db->where('username', $data['username']);
    //             $this->db->update('userdata', $data);

    //             $this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible fade show"><strong>Selamat! </strong>Anda berhasil mengubah data.</div>');
    //             redirect('pengguna');
    //         }
    //     }
    // }
    public function edit_Profile()
    {
        $this->form_validation->set_rules('nama_lengkap', 'Name', 'required|trim', [
            'required' => 'Nama harus diisi!'
        ]);
        // $this->form_validation->set_rules('tempat_lahir', 'Tempat_lahir', 'required|trim', [
        //     'required' => 'Tempat lahir harus diisi!'
        // ]);
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal_lahir', 'required', [
            'required' => 'Tanggal lahir harus diisi!'
        ]);
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim', [
            'required' => 'Alamat harus diisi!'
        ]);
        $this->form_validation->set_rules('no_hp', 'No_hp', 'required|trim', [
            'required' => 'No HP harus diisi!'
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'User';
            $data['sub_title'] = 'Edit Profil';
            $data['corp_name'] = 'Itenas';
            $data['user'] = $this->app_models->getUserTable('user');
            // $data['userdata'] = $this->app_models->getUserTable('user');

            // $this->load->view('templates/header', $data);
            // $this->load->view('templates/navbar', $data);
            // $this->load->view('templates/sidebar', $data);
            // $this->load->view('pengguna/edit_form/', $data);
            // $this->load->view('templates/footer');
            $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal! </strong>Semua data harus diisi!.</div>');
            redirect('pengguna/edit_form/' . $this->input->post('id_anggota'));
        } else {
            $config['upload_path']          = './assets/images/profile';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             = 10240;
            $config['max_width']            = 10000;
            $config['max_height']           = 10000;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('profil')) {
                $data = [
                    'nip' => htmlspecialchars($this->input->post('nip', true)),
                    'username' => htmlspecialchars($this->input->post('username', true)),
                    'password' => htmlspecialchars($this->input->post('password', true)),
                    'nama_lengkap' => htmlspecialchars($this->input->post('nama_lengkap', true)),
                    // 'tempat_lahir' => htmlspecialchars($this->input->post('tempat_lahir', true)),
                    'tanggal_lahir' => $this->input->post('tanggal_lahir'),
                    'jenis_kelamin' => htmlspecialchars($this->input->post('jenis_kelamin', true)),
                    'alamat' => htmlspecialchars($this->input->post('alamat', true)),
                    'no_hp' => htmlspecialchars($this->input->post('no_hp', true)),
                    'no_rek' => htmlspecialchars($this->input->post('no_rek', true)),
                    'profil' => 'default.jpg'
                ];
                $this->db->last_query(); // Add this line to see the generated SQL query
                echo $this->upload->display_errors();



                $this->db->set($data);
                $this->db->where('id_anggota', $this->input->post('id_anggota'));
                $this->db->update('user', $data);

                $this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible fade show"><strong>Selamat! </strong>Anda berhasil mengubah data.</div>');
                redirect('pengguna');
            } else {
                $profil =  $this->upload->data('file_name');
                $data = [
                    'nip' => htmlspecialchars($this->input->post('nip', true)),
                    'username' => htmlspecialchars($this->input->post('username', true)),
                    'password' => htmlspecialchars($this->input->post('password', true)),
                    'nama_lengkap' => htmlspecialchars($this->input->post('nama_lengkap', true)),
                    // 'tempat_lahir' => htmlspecialchars($this->input->post('tempat_lahir', true)),
                    'tanggal_lahir' => $this->input->post('tanggal_lahir'),
                    'jenis_kelamin' => htmlspecialchars($this->input->post('jenis_kelamin', true)),
                    'alamat' => htmlspecialchars($this->input->post('alamat', true)),
                    'no_hp' => htmlspecialchars($this->input->post('no_hp', true)),
                    'no_rek' => htmlspecialchars($this->input->post('no_rek', true)),
                    'profil' => $profil
                ];
                $this->db->last_query(); // Add this line to see the generated SQL query
                echo $this->upload->display_errors();


                $this->db->set($data);
                $this->db->where('id_anggota', $this->input->post('id_anggota'));
                $this->db->update('user', $data);

                $this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible fade show"><strong>Selamat! </strong>Anda berhasil mengubah data.</div>');
                redirect('pengguna');
            }
        }
    }
}
