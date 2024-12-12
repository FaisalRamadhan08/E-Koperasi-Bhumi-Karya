<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class App_Models extends CI_Model
{
	public function getUserTable($table)
	{
		return $this->db->get_where($table, ['id_anggota' => $this->session->userdata('id_anggota')])->row_array();
	}

	public function getSelectedUserTable($id_anggota)
	{
		return $this->db->get_where('user', ['id_anggota' => $id_anggota])->row_array();
	}

	public function getSelectedUserDataTable($id_anggota)
	{
		return $this->db->get_where('user', ['id_anggota' => $id_anggota])->row_array();
	}

	public function getSelectedTable($table, $id_anggota)
	{
		return $this->db->get_where($table, ['id_anggota' => $id_anggota])->row_array();
	}

	public function deleteSelectedUser($id_anggota)
	{
		$this->db->delete('user', ['id_anggota' => $id_anggota]);
		// $this->db->delete('user', ['id_anggota' => $id_anggota]);
	}

	public function getWhereNumRow($table)
	{
		return $this->db->get_where($table, ['id_anggota' => $this->session->userdata('id_anggota')])->num_rows();
	}

	public function getNumRow($table)
	{
		return $this->db->get($table)->num_rows();
	}

	public function hitungSimpanan()
	{
		return $this->db->count_all("simpanan");
	}

	public function getSimpananPokok($id_anggota)
	{
		$query = "SELECT SUM(simpanan) AS simpanan FROM simpanan WHERE id_anggota = '$id_anggota' AND jenis_simpanan = 'Simpanan Pokok' AND status = '2' ";

		return $this->db->query($query)->row_array();
	}

	public function getSimpananWajib($id_anggota)
	{
		$query = "SELECT SUM(simpanan) AS simpanan FROM simpanan WHERE id_anggota = '$id_anggota' AND jenis_simpanan = 'Simpanan Wajib' AND status = '2'";

		return $this->db->query($query)->row_array();
	}

	public function getSimpananSukarela($id_anggota)
	{
		$query = "SELECT SUM(simpanan) AS simpanan FROM simpanan WHERE id_anggota = '$id_anggota' AND jenis_simpanan = 'Simpanan Sukarela' AND status = '2'";

		return $this->db->query($query)->row_array();
	}

	public function getTotalSP()
	{
		$query = " SELECT `id_anggota`, (SELECT SUM(`pinjaman_pokok`) FROM `pinjaman` WHERE `keterangan` = 2) AS pinjaman,
                   (SELECT SUM(`simpanan`) FROM `simpanan` WHERE `status` = 2) AS simpanan
                    FROM `user` ";
		$total = $this->db->query($query)->row_array();

		return $total;
	}

	public function getUserTotalSP($id_anggota)
	{
		$query = " SELECT `id_anggota`, (SELECT SUM(`pinjaman_pokok`) FROM `pinjaman` WHERE `id_anggota` = '$id_anggota' AND `keterangan` = 2) AS pinjaman,
				  (SELECT SUM(`simpanan`) FROM `simpanan`  WHERE `id_anggota` = '$id_anggota' AND `status` = 2) AS simpanan
				  FROM `user` WHERE `id_anggota` = '$id_anggota' ";
		$total = $this->db->query($query)->row_array();

		return $total;
	}

	public function getTransaksi($table)
	{
		$query = "SELECT * FROM $table ORDER BY tgl_$table DESC LIMIT 5";

		return $this->db->query($query)->result_array();
	}

	public function getUserTransaksi($table, $id_anggota)
	{
		$query = "SELECT * FROM $table WHERE id_anggota = '$id_anggota' ORDER BY tgl_$table DESC LIMIT 5";

		return $this->db->query($query)->result_array();
	}


	public function setSetuju($no_pinjaman)
	{
		$query = "UPDATE `pinjaman` 
                SET `keterangan` = 2
                WHERE `no_pinjaman` = $no_pinjaman
                ";

		$this->db->query($query);
	}

	public function setBayar($tgl_bayar, $id, $no_pinjaman)
	{
		$query = "UPDATE `angsuran` 
                SET `tgl_bayar` = $tgl_bayar,
                    `status`    = 1
                WHERE `id` = $id
                ";

		$this->db->query($query);
	}

	public function setTolak($id)
	{
		$query = "UPDATE `angsuran` 
                SET `status`    = 0
                WHERE `id` = $id
                ";

		$this->db->query($query);
	}

	public function setKonfirmasi($id, $no_pinjaman)
	{
		$query = "UPDATE `angsuran` 
                SET `status`    = 2
                WHERE `id` = $id
                ";

		$this->db->query($query);

		$query = "SELECT a.status 
				  FROM angsuran AS a 
				  JOIN pinjaman AS b
				  ON b.no_pinjaman = a.no_pinjaman
				  WHERE b.no_pinjaman = $no_pinjaman
				  ORDER BY a.angsuran DESC
				  LIMIT 1";

		$status = $this->db->query($query)->row_array();
		if ($status['status'] == 2) {
			$query = "UPDATE `pinjaman` 
                SET `status`    = 1
                WHERE `no_pinjaman` = $no_pinjaman
                ";

			$this->db->query($query);
		}
	}

	public function angsuran($tanggal, $jangka_waktu)
	{
		$query = "SELECT * FROM pinjaman  ORDER BY no_pinjaman DESC LIMIT 1";
		$pinjaman = $this->db->query($query)->row_array();

		$angsuran_ke = 1;
		while ($angsuran_ke <= $jangka_waktu) {

			if ($angsuran_ke == 1) {
				$sisa = ($pinjaman['angsuran'] * $pinjaman['jangka_waktu']) - $pinjaman['angsuran'];
			} else {
				$query = "SELECT * FROM angsuran  ORDER BY id DESC LIMIT 1";
				$sisa = $this->db->query($query)->row_array();
				$sisa = $sisa['sisa'] - $sisa['bayar'];
			}

			$angsuran = '+' . $angsuran_ke . ' months';
			$jatuh_tempo = date('Y-m-d', strtotime($tanggal . $angsuran));


			$data = [
				'no_pinjaman' => $pinjaman['no_pinjaman'],
				'id_anggota' => $pinjaman['id_anggota'],
				'angsuran' => $angsuran_ke,
				'jatuh_tempo' => $jatuh_tempo,
				'bayar' => $pinjaman['angsuran'],
				'sisa' => $sisa,
				'denda' => 0,
				'jumlah' => $pinjaman['angsuran'] + 0,
				'status' => 0
			];
			$this->db->insert('angsuran', $data);
			$angsuran_ke++;
		}
	}

	// public function editAngsuran($no_pinjaman, $tanggal, $jangka_waktu)
	// {
	// 	$query = "SELECT * FROM pinjaman WHERE no_pinjaman = '$no_pinjaman'";
	// 	$pinjaman = $this->db->query($query)->row_array();

	// 	$angsuran_ke = 1;
	// 	while ($angsuran_ke <= $jangka_waktu) {

	// 		if ($angsuran_ke == 1) {
	// 			$sisa = ($pinjaman['angsuran'] * $pinjaman['jangka_waktu']) - $pinjaman['angsuran'];
	// 		} else {
	// 			$query = "SELECT * FROM angsuran WHERE no_pinjaman = '$no_pinjaman' ORDER BY id DESC LIMIT 1";
	// 			$last_angsuran = $this->db->query($query)->row_array();
	// 			$sisa = $last_angsuran['sisa'] - $last_angsuran['bayar'];
	// 		}

	// 		$angsuran = '+' . $angsuran_ke . ' months';
	// 		$jatuh_tempo = date('Y-m-d', strtotime($tanggal . $angsuran));

	// 		$data = [
	// 			// 'no_pinjaman' => $pinjaman['no_pinjaman'],
	// 			'id_anggota' => $pinjaman['id_anggota'],
	// 			'angsuran' => $angsuran_ke,
	// 			'jatuh_tempo' => $jatuh_tempo,
	// 			'bayar' => $pinjaman['angsuran'],
	// 			'sisa' => $sisa,
	// 			'denda' => 0,
	// 			'jumlah' => $pinjaman['angsuran'] + 0,
	// 			'status' => 0
	// 		];

	// 		$this->db->where('no_pinjaman', $no_pinjaman); // Sesuaikan kondisi sesuai kebutuhan Anda
	// 		$this->db->update('angsuran', $data);


	// 		$angsuran_ke++;
	// 	}
	// }

	// public function editAngsuran($no_pinjaman, $tanggal, $jangka_waktu)
	// {
	// 	$query = "SELECT * FROM pinjaman WHERE no_pinjaman = '$no_pinjaman'";
	// 	$pinjaman = $this->db->query($query)->row_array();

	// 	if ($pinjaman) {
	// 		$angsuran_ke = 1;
	// 		while ($angsuran_ke <= $jangka_waktu) {

	// 			if ($angsuran_ke == 1) {
	// 				$sisa = ($pinjaman['angsuran'] * $pinjaman['jangka_waktu']) - $pinjaman['angsuran'];
	// 			} else {
	// 				$query = "SELECT * FROM angsuran WHERE no_pinjaman = '$no_pinjaman' ORDER BY id DESC LIMIT 1";
	// 				$last_angsuran = $this->db->query($query)->row_array();
	// 				$sisa = $last_angsuran['sisa'] - $last_angsuran['bayar'];
	// 			}

	// 			$angsuran = '+' . $angsuran_ke . ' months';
	// 			$jatuh_tempo = date('Y-m-d', strtotime($tanggal . $angsuran));

	// 			$data = [
	// 				'id_anggota' => $pinjaman['id_anggota'],
	// 				'angsuran' => $angsuran_ke,
	// 				'jatuh_tempo' => $jatuh_tempo,
	// 				'bayar' => $pinjaman['angsuran'],
	// 				'sisa' => $sisa,
	// 				'denda' => 0,
	// 				'jumlah' => $pinjaman['angsuran'] + 0,
	// 				'status' => 0
	// 			];

	// 			$this->db->where('no_pinjaman', $no_pinjaman);
	// 			$this->db->update('angsuran', $data);

	// 			$angsuran_ke++;
	// 		}
	// 	} else {
	// 		// Handle the case where $pinjaman is null
	// 		// For example, you can log an error or return an error response
	// 		log_message('error', 'Pinjaman not found for no_pinjaman: ' . $no_pinjaman);
	// 		// Or you can return an error response
	// 		// return $this->response->error('Pinjaman not found', 404);
	// 	}
	// }

	public function editAngsuran($no_pinjaman, $tanggal, $jangka_waktu)
	{
		$query = "SELECT * FROM pinjaman WHERE no_pinjaman = '$no_pinjaman'";
		$pinjaman = $this->db->query($query)->row_array();

		$angsuran_ke = 1;
		while ($angsuran_ke <= $jangka_waktu) {

			if ($angsuran_ke == 1) {
				$sisa = ($pinjaman['angsuran'] * $pinjaman['jangka_waktu']) - $pinjaman['angsuran'];
			} else {
				$query = "SELECT * FROM angsuran WHERE no_pinjaman = '$no_pinjaman' ORDER BY id DESC LIMIT 1";
				$last_angsuran = $this->db->query($query)->row_array();
				$sisa = $last_angsuran['sisa'] - $last_angsuran['bayar'];
			}

			$angsuran = '+' . $angsuran_ke . ' months';
			$jatuh_tempo = date('Y-m-d', strtotime($tanggal . $angsuran));

			$data = [
				'id_anggota' => $pinjaman['id_anggota'],
				'angsuran' => $angsuran_ke,
				'jatuh_tempo' => $jatuh_tempo,
				'bayar' => $pinjaman['angsuran'],
				'sisa' => $sisa,
				'denda' => 0,
				'jumlah' => $pinjaman['angsuran'] + 0,
				'status' => 0
			];

			$this->db->where('no_pinjaman', $no_pinjaman); // Sesuaikan kondisi sesuai kebutuhan Anda
			$this->db->update('angsuran', $data);

			$angsuran_ke++;
		}
	}





	public function getDataSimpanan()
	{
		$dataSimpanan = $this->db
			->select('simpanan.*, user.username as user_username, user.nip')
			->from('simpanan')
			->join('user', 'simpanan.id_anggota = user.id_anggota', 'left')
			->get()
			->result_array();

		// var_dump($dataSimpanan); // Tambahkan ini
		return $dataSimpanan;
	}
	public function getDataSimpananUser()
	{
		$user = $this->session->userdata('id_anggota');


		$dataSimpanan = $this->db
			->select('simpanan.*, user.username as user_username, user.nip')
			->from('simpanan')
			->join('user', 'simpanan.id_anggota = user.id_anggota', 'left')
			->where('simpanan.id_anggota', $user)
			->get()
			->result_array();

		// var_dump($dataSimpanan); // Tambahkan ini
		return $dataSimpanan;
	}

	// public function getDataSimpananUser()
	// {
	// 	$user = $this->session->userdata('user'); // Mengambil data user yang sedang login

	// 	$dataSimpanan = $this->db
	// 		->select('simpanan.*, user.username as user_username')
	// 		->from('simpanan')
	// 		->join('user', 'simpanan.id_anggota = user.id_anggota', 'left')
	// 		->where('simpanan.id_anggota', $user['id_anggota']) // Menambahkan kondisi where sesuai dengan id_anggota user yang sedang login
	// 		->get()
	// 		->result_array();

	// 	// var_dump($dataSimpanan); // Tambahkan ini
	// 	return $dataSimpanan;
	// }

	public function getDataPinjaman()
	{
		$user = $this->session->userdata('id_anggota');
		$dataPinjaman = $this->db
			->select('pinjaman.*, user.username as username, user.nip')
			->from('pinjaman')
			->join('user', 'pinjaman.id_anggota = user.id_anggota', 'left')
			->where('pinjaman.id_anggota', $user)
			->get()
			->result_array();

		// var_dump($dataSimpanan); // Tambahkan ini
		return $dataPinjaman;
	}
	public function getDataPinjamanAdmin()
	{
		// $user = $this->session->userdata('id_anggota');
		$dataPinjaman = $this->db
			->select('pinjaman.*, user.username as username, user.nip')
			->from('pinjaman')
			->join('user', 'pinjaman.id_anggota = user.id_anggota', 'left')
			// ->where('pinjaman.id_anggota', $user)
			->get()
			->result_array();

		// var_dump($dataSimpanan); // Tambahkan ini
		return $dataPinjaman;
	}
	// public function getDataPinjaman()
	// {
	// 	$user = $this->session->userdata('id_anggota');

	// 	if ($this->session->userdata('level') == 2) {
	// 		// Jika login sebagai anggota
	// 		$dataPinjaman = $this->db
	// 			->select('pinjaman.*, user.username as username')
	// 			->from('pinjaman')
	// 			->join('user', 'pinjaman.id_anggota = user.id_anggota', 'left')
	// 			->where('pinjaman.id_anggota', $user)
	// 			->get()
	// 			->result_array();
	// 	} else {
	// 		// Jika login sebagai admin
	// 		$dataPinjaman = $this->db
	// 			->select('pinjaman.*, user.username as username')
	// 			->from('pinjaman')
	// 			->join('user', 'pinjaman.id_anggota = user.id_anggota', 'left')
	// 			->get()
	// 			->result_array();
	// 	}

	// 	return $dataPinjaman;
	// }


	public function getDataAngsuran()
	{
		$angsuran = $this->db
			->select('angsuran.*, user.username as username, user.nip')
			->from('angsuran')
			->join('user', 'angsuran.id_anggota = user.id_anggota', 'left')
			->get()
			->result_array();

		// var_dump($dataSimpanan); // Tambahkan ini
		return $angsuran;
	}
	public function getDataAngsuranUser()
	{
		$user = $this->session->userdata('id_anggota');
		$angsuran = $this->db
			->select('angsuran.*, user.username as username, user.nip, user.nama_lengkap')
			->from('angsuran')
			->join('user', 'angsuran.id_anggota = user.id_anggota', 'left')
			->where('angsuran.id_anggota', $user)
			->get()
			->result_array();

		// var_dump($dataSimpanan); // Tambahkan ini
		return $angsuran;
	}
	public function getLevel($id_anggota)
	{
		$query = $this->db
			->select('level')
			->where('id_anggota', $id_anggota)
			->get('user');

		if ($query->num_rows() > 0) {
			return $query->row()->level;
		}

		return null;
	}


	public function getPengurus()
	{
		$query = "SELECT *
                  FROM `user`
				  WHERE level = 2";
		$userdata = $this->db->query($query)->result_array();

		return $userdata;
	}

	public function getAnggota()
	{
		$query = "SELECT *
							FROM `user`
							WHERE level = 1";

		$userdata = $this->db->query($query)->result_array();

		return $userdata;
	}

	public function setAktif($id_anggota)
	{
		$query = "UPDATE user SET aktif = 2 WHERE id_anggota = '$id_anggota'";
		$this->db->query($query);
	}

	public function setNonaktif($id_anggota)
	{
		$query = "UPDATE user SET aktif = 1 WHERE id_anggota = '$id_anggota'";
		$this->db->query($query);
	}

	public function editProfile()
	{
		$this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[user.username]', [
			'required' => 'Username harus diisi!',
			'is_unique' => 'Username sudah digunakan!'
		]);
		// $this->form_validation->set_rules('tempat_lahir', 'Tempat_lahir', 'required|trim', [
		// 	'required' => 'Tempat lahir harus diisi!'
		// ]);
		// $this->form_validation->set_rules('tanggal_lahir', 'Tanggal_lahir', 'required', [
		// 	'required' => 'Tanggal lahir harus diisi!'
		// ]);
		// $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim', [
		// 	'required' => 'Alamat harus diisi!'
		// ]);
		// $this->form_validation->set_rules('no_hp', 'No_hp', 'required|trim', [
		// 	'required' => 'No HP harus diisi!'
		// ]);
		// $this->form_validation->set_rules('no_rek', 'No_rek', 'required|trim', [
		// 	'required' => 'No Rekening harus diisi!'
		// ]);
		// $this->form_validation->set_rules('bank', 'Bank', 'required|trim', [
		// 	'required' => 'Bank harus diisi!'
		// ]);

		if ($this->form_validation->run() == false) {
			$data['title'] = 'User';
			$data['sub_title'] = 'Edit Profil';
			$data['corp_name'] = 'Itenas';
			$data['user'] = $this->app_models->getUserTable('user');
			$data['userdata'] = $this->app_models->getUserTable('user');

			// $this->load->view('templates/header', $data);
			// $this->load->view('templates/navbar', $data);
			// $this->load->view('templates/sidebar', $data);
			// $this->load->view('pengguna/edit_form/', $data);
			// $this->load->view('templates/footer');
			$this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal! </strong>Semua data harus diisi!.</div>');
			redirect('pengguna/edit_form/' . $this->input->post('username'));
		} else {
			$config['upload_path']          = './assets/images/profile';
			$config['allowed_types']        = 'gif|jpg|png';
			$config['max_size']             = 10240;
			$config['max_width']            = 10000;
			$config['max_height']           = 10000;

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('profil')) {
				$data = [
					'username' => htmlspecialchars($this->input->post('username', true)),
					'nama_lengkap' => htmlspecialchars($this->input->post('nama_lengkap', true)),
					'no_rek' => htmlspecialchars($this->input->post('no_rek', true)),
					// 'bank' => htmlspecialchars($this->input->post('bank', true)),
					'tempat_lahir' => htmlspecialchars($this->input->post('tempat_lahir', true)),
					'tanggal_lahir' => $this->input->post('tanggal_lahir'),
					'jenis_kelamin' => htmlspecialchars($this->input->post('jenis_kelamin', true)),
					'alamat' => htmlspecialchars($this->input->post('alamat', true)),
					'no_hp' => htmlspecialchars($this->input->post('no_hp', true)),
					'profil' => 'default.jpg'
				];
				$this->db->where('id_user', $data['id_user']);
				$this->db->update('user', $data);

				$this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible fade show"><strong>Selamat! </strong>Anda berhasil mengubah data.</div>');
				redirect('pengguna');
			} else {
				$profil =  $this->upload->data('file_name');
				$data = [
					'username' => htmlspecialchars($this->input->post('username', true)),
					'nama_lengkap' => htmlspecialchars($this->input->post('nama_lengkap', true)),
					'no_rek' => htmlspecialchars($this->input->post('no_rek', true)),
					// 'bank' => htmlspecialchars($this->input->post('bank', true)),
					'tempat_lahir' => htmlspecialchars($this->input->post('tempat_lahir', true)),
					'tanggal_lahir' => $this->input->post('tanggal_lahir'),
					'jenis_kelamin' => htmlspecialchars($this->input->post('jenis_kelamin', true)),
					'alamat' => htmlspecialchars($this->input->post('alamat', true)),
					'no_hp' => htmlspecialchars($this->input->post('no_hp', true)),
					'profil' => $profil

				];
				$this->db->where('id_user', $data['id_user']);
				$this->db->update('user', $data);

				$this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible fade show"><strong>Selamat! </strong>Anda berhasil mengubah data.</div>');
				redirect('pengguna');
			}
		}
	}

	// public function editProfile()
	// {
	// 	$id_user = $this->session->userdata('id_user'); // Sesuaikan ini dengan cara Anda mendapatkan id_user

	// 	$this->form_validation->set_rules('username', 'Username', 'required|trim', [
	// 		'required' => 'Username harus diisi!'
	// 	]);

	// 	if ($this->form_validation->run() == false) {
	// 		$data['title'] = 'User';
	// 		$data['sub_title'] = 'Edit Profil';
	// 		$data['corp_name'] = 'Itenas';
	// 		$data['user'] = $this->app_models->getUserTable('user');
	// 		$data['userdata'] = $this->app_models->getUserTable('userdata');

	// 		$this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal! </strong>Semua data harus diisi!.</div>');
	// 		redirect('pengguna/edit_form/' . $this->input->post('username'));
	// 	} else {
	// 		$config['upload_path'] = './assets/images/profile';
	// 		$config['allowed_types'] = 'gif|jpg|png';
	// 		$config['max_size'] = 10240;
	// 		$config['max_width'] = 10000;
	// 		$config['max_height'] = 10000;

	// 		$this->load->library('upload', $config);

	// 		$data = [
	// 			'username' => htmlspecialchars($this->input->post('username', true)),
	// 			'nama_lengkap' => htmlspecialchars($this->input->post('nama_lengkap', true)),
	// 			'no_rek' => htmlspecialchars($this->input->post('no_rek', true)),
	// 			'tempat_lahir' => htmlspecialchars($this->input->post('tempat_lahir', true)),
	// 			'tanggal_lahir' => $this->input->post('tanggal_lahir'),
	// 			'jenis_kelamin' => htmlspecialchars($this->input->post('jenis_kelamin', true)),
	// 			'alamat' => htmlspecialchars($this->input->post('alamat', true)),
	// 			'no_hp' => htmlspecialchars($this->input->post('no_hp', true)),
	// 		];

	// 		if ($_FILES['profil']['name'] != '') {
	// 			if ($this->upload->do_upload('profil')) {
	// 				$profil = $this->upload->data('file_name');
	// 				$data['profil'] = $profil;
	// 			}
	// 		}

	// 		$this->db->where('id_user', $id_user); // Menambahkan kondisi WHERE untuk mengidentifikasi record yang akan diupdate
	// 		$this->db->update('userdata', $data);

	// 		$this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible fade show"><strong>Selamat! </strong>Anda berhasil mengubah data.</div>');
	// 		redirect('pengguna');
	// 	}
	// }


	public function validasiSimpanan()
	{
		$id_anggota = $this->session->userdata('id_anggota');
		$query = "SELECT no_simpanan FROM simpanan WHERE id_anggota = '$id_anggota' AND jenis_simpanan = 'Simpanan Pokok'";

		return $this->db->query($query)->num_rows();
	}

	public function getStatusPinjaman()
	{
		$id_anggota = $this->session->userdata('id_anggota');
		$query = "SELECT status FROM pinjaman WHERE id_anggota = '$id_anggota' AND keterangan > 0 ORDER BY no_pinjaman DESC LIMIT 1";
		$status = $this->db->query($query)->row_array();

		return $status['status'];
	}

	public function getJumlahStatusPinjaman()
	{
		$id_anggota = $this->session->userdata('id_anggota');
		$query = "SELECT no_pinjaman FROM pinjaman WHERE id_anggota = '$id_anggota' AND keterangan > 0 AND status = 0";

		return $this->db->query($query)->num_rows();
	}
}
/* End of file app_model.php */
/* Location: ./application/models/app_model.php */