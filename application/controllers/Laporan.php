<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Include librari PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('login') != 1) {
            $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Maaf! </strong>Anda belum login.</div>');
            redirect('auth');
        } else {
            if ($this->session->userdata('aktif') < 2) {
                if ($this->session->userdata('level') < 2) {
                    redirect('user');
                }
            }
        }
    }

    public function index()
    {
        $data['title'] = 'Laporan';
        $data['sub_title'] = 'Laporan';
        $data['status'] = 'Admin';
        $data['corp_name'] = 'BPN';
        $data['kelompok'] = 'Itenas';
        $data['user'] = $this->app_models->getUserTable('user');
        $data['userdata'] = $this->app_models->getUserTable('user');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('laporan/index', $data);
        $this->load->view('templates/footer');
    }

    public function bukti()
    {
        $data['title'] = 'Laporan';
        $data['sub_title'] = 'Bukti Bayar';
        $data['status'] = 'Admin';
        $data['corp_name'] = 'BPN';
        $data['kelompok'] = 'Itenas';
        $data['user'] = $this->app_models->getUserTable('user');
        $data['userdata'] = $this->app_models->getUserTable('user');
        $data['tanggal'] = new DateTime();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('laporan/bukti', $data);
        $this->load->view('templates/footer');
    }

    public function proses($jenis, $tgl_awal, $tgl_akhir, $jenis_laporan)
    {
        $full = [$jenis, $tgl_awal, $tgl_akhir, $jenis_laporan];
        $this->session->set_flashdata('full', $full);
        redirect('laporan/print');
    }

    public function print()
    {
        $full = $this->session->flashdata('full');
        $jenis = $full[0];
        $tgl_awal = $full[1];
        $tgl_akhir = $full[2];
        $jenis_laporan = $full[3];

        $filter = [
            $tgl_awal, $tgl_akhir, $jenis_laporan, $jenis
        ];

        if ($jenis == 'pdf') {
            if ($jenis_laporan == '') {
                $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal! </strong>Jenis Laporan wajib diisi!</div>');
                redirect('laporan');
            } else {
                if ($tgl_awal != '' && $tgl_akhir == '') {
                    $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal! </strong>Silahkan isi tanggal akhir.</div>');
                    redirect('laporan');
                } elseif ($tgl_awal == '' && $tgl_akhir != '') {
                    $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal! </strong>Silahkan isi tanggal awal.</div>');
                    redirect('laporan');
                } elseif ($tgl_awal == '' && $tgl_akhir == '') {
                    if ($jenis_laporan == 'pinjaman') {
                        redirect('laporan/printPinjaman');
                    }
                    $this->session->set_flashdata('jenis_simpanan', $jenis_laporan);
                    redirect('laporan/printSimpanan');
                } else {
                    $this->session->set_flashdata('filter', $filter);
                    redirect('laporan/printTanggalAndJenis');
                }
            }
        } elseif ($jenis == 'excel') {
            if ($jenis_laporan == '') {
                $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal! </strong>Jenis Laporan wajib diisi!</div>');
                redirect('laporan');
            } else {
                if ($tgl_awal != '' && $tgl_akhir == '') {
                    $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal! </strong>Silahkan isi tanggal akhir.</div>');
                    redirect('laporan');
                } elseif ($tgl_awal == '' && $tgl_akhir != '') {
                    $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal! </strong>Silahkan isi tanggal awal.</div>');
                    redirect('laporan');
                } elseif ($tgl_awal == '' && $tgl_akhir == '') {
                    if ($jenis_laporan == 'pinjaman') {
                        redirect('laporan/printPinjamanExcel');
                    }
                    $this->session->set_flashdata('jenis_simpanan', $jenis_laporan);
                    redirect('laporan/printSimpananExcel');
                } else {
                    $this->session->set_flashdata('filter', $filter);
                    redirect('laporan/PrintTanggalAndJenisExcel');
                }
            }
        }
    }

    public function cekLaporan()
    {
        $jenis_laporan = $this->input->post('jenis_laporan');
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $data['tgl_awal'] = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;
        $data['jenis_laporan'] = $jenis_laporan;

        if ($jenis_laporan == '') {
            $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal! </strong>Jenis Laporan wajib diisi!</div>');
            redirect('laporan');
        } else {
            if ($tgl_awal != '' && $tgl_akhir == '') {
                $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal! </strong>Silahkan isi tanggal akhir.</div>');
                redirect('laporan');
            } elseif ($tgl_awal == '' && $tgl_akhir != '') {
                $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal! </strong>Silahkan isi tanggal awal.</div>');
                redirect('laporan');
            } elseif ($tgl_awal == '' && $tgl_akhir == '') {
                if ($jenis_laporan == 'pinjaman') {
                    $data['title'] = 'Laporan';
                    $data['sub_title'] = 'Laporan Pinjaman';
                    $data['status'] = 'User';
                    $data['corp_name'] = 'BPN';
                    $data['kelompok'] = 'Itenas';
                    $data['user'] = $this->app_models->getUserTable('user');
                    $data['userdata'] = $this->app_models->getUserTable('user');
                    $data['tanggal'] = new DateTime();

                    $data['pinjaman'] = $this->print_models->viewPinjaman();
                    $data['totalPinjaman'] = $this->print_models->getTotalPinjaman();
                    $data['totalBunga'] = $this->print_models->getBunga();

                    $this->load->view('templates/header', $data);
                    $this->load->view('templates/navbar', $data);
                    $this->load->view('templates/sidebar', $data);
                    $this->load->view('laporan/cekLaporanPinjaman', $data);
                    $this->load->view('templates/footer');
                } else {
                    if ($jenis_laporan == 'simpananPokok') {
                        $jenis_laporan = 'Simpanan Pokok';
                    } elseif ($jenis_laporan == 'simpananWajib') {
                        $jenis_laporan = 'Simpanan Wajib';
                    } elseif ($jenis_laporan == 'simpananSukarela') {
                        $jenis_laporan = 'Simpanan Sukarela';
                    }
                    $data['title'] = 'Laporan';
                    $data['sub_title'] = 'Laporan ' . $jenis_laporan;
                    $data['status'] = 'User';
                    $data['corp_name'] = 'BPN';
                    $data['kelompok'] = 'Itenas';
                    $data['user'] = $this->app_models->getUserTable('user');
                    $data['userdata'] = $this->app_models->getUserTable('user');
                    $data['tanggal'] = new DateTime();


                    $data['simpanan'] = $this->print_models->viewSimpanan($jenis_laporan);
                    $data['totalSimpanan'] = $this->print_models->getTotalSimpanan($jenis_laporan);
                    // Contoh pengaturan flashdata pada halaman sebelumnya
                    $this->session->set_flashdata('jenis_simpanan');


                    $this->load->view('templates/header', $data);
                    $this->load->view('templates/navbar', $data);
                    $this->load->view('templates/sidebar', $data);
                    $this->load->view('laporan/cekLaporanSimpanan', $data);
                    $this->load->view('templates/footer');
                }
            } else {
                $data['title'] = 'Laporan';
                $data['status'] = 'User';
                $data['corp_name'] = 'BPN';
                $data['kelompok'] = 'Itenas';
                $data['user'] = $this->app_models->getUserTable('user');
                $data['userdata'] = $this->app_models->getUserTable('user');
                $data['tanggal'] = new DateTime();

                if ($jenis_laporan == 'pinjaman') {
                    $data['sub_title'] = 'Laporan Pinjaman';
                    $data['pinjaman'] = $this->print_models->getPinjamanByTanggal($tgl_awal, $tgl_akhir);
                    $data['totalPinjaman'] = $this->print_models->getTotalPinjamanByTanggal($tgl_awal, $tgl_akhir);
                    $data['totalBunga'] = $this->print_models->getBungaByTanggal($tgl_awal, $tgl_akhir);

                    if ($data['pinjaman'] == NULL) {
                        $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal mencetak! </strong>Tidak ada data.</div>');
                        redirect('laporan');
                    } else {
                        $this->load->view('templates/header', $data);
                        $this->load->view('templates/navbar', $data);
                        $this->load->view('templates/sidebar', $data);
                        $this->load->view('laporan/cekLaporanPinjaman', $data);
                        $this->load->view('templates/footer');
                    }
                } else {
                    if ($jenis_laporan == 'simpananPokok') {
                        $jenis_laporan = 'Simpanan Pokok';
                    } elseif ($jenis_laporan == 'simpananWajib') {
                        $jenis_laporan = 'Simpanan Wajib';
                    }
                    // } elseif ($jenis_laporan == 'simpananSukarela') {
                    //     $jenis_laporan = 'Simpanan Sukarela';
                    // }

                    $data['simpanan'] = $this->print_models->getSimpananByTanggalAndJenis($tgl_awal, $tgl_akhir, $jenis_laporan);
                    $data['totalSimpanan'] = $this->print_models->getTotalSimpananByTanggalAndJenis($tgl_awal, $tgl_akhir, $jenis_laporan);

                    if ($data['simpanan'] == NULL) {
                        $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal mencetak! </strong>Tidak ada data.</div>');
                        redirect('laporan');
                    } else {
                        $data['title'] = 'Laporan';
                        $data['sub_title'] = 'Laporan ' . $jenis_laporan;
                        $data['status'] = 'User';
                        $data['corp_name'] = 'BPN';
                        $data['kelompok'] = 'Itenas';
                        // $data['simpanan'] = $this->print_models->getSimpanan($jenis_laporan);

                        $this->load->view('templates/header', $data);
                        $this->load->view('templates/navbar', $data);
                        $this->load->view('templates/sidebar', $data);
                        $this->load->view('laporan/cekLaporanSimpanan', $data);
                        $this->load->view('templates/footer');
                    }
                }
            }
        }
    }

    public function printPinjaman()
    {
        $data['title'] = 'Laporan';
        $data['corp_name'] = 'BPN';
        $data['user'] = $this->app_models->getUserTable('user');
        $data['userdata'] = $this->app_models->getUserTable('user');
        $data['tanggal'] = new DateTime();
        $data['pinjaman'] = $this->print_models->viewPinjaman();
        $data['totalPinjaman'] = $this->print_models->getTotalPinjaman();
        $data['totalBunga'] = $this->print_models->getBunga();


        $this->load->view('templates/header', $data);
        $this->load->view('print/printPinjaman', $data);
    }

    public function printPinjamanExcel()
    {
        $data['title'] = 'Laporan';
        $data['corp_name'] = 'BPN';
        $data['user'] = $this->app_models->getUserTable('user');
        $data['userdata'] = $this->app_models->getUserTable('user');
        $data['tanggal'] = new DateTime();
        $data['pinjaman'] = $this->print_models->getPinjaman();
        $data['totalPinjaman'] = $this->print_models->getTotalPinjaman();
        $data['totalBunga'] = $this->print_models->getBunga();


        $this->load->view('templates/header', $data);
        $this->load->view('print/printPinjamanExcel', $data);
    }

    public function printSimpanan()
    {
        $data['title'] = 'Laporan';
        $data['corp_name'] = 'BPN';
        $data['user'] = $this->app_models->getUserTable('user');
        $data['userdata'] = $this->app_models->getUserTable('user');
        $data['tanggal'] = new DateTime();

        // $jenis_simpanan = $this->session->flashdata('jenis_simpanan');


        // if ($jenis_simpanan == 'simpananPokok') {
        //     $jenis_simpanan = 'Simpanan Pokok';
        //     $data['jenis'] = 'POKOK';
        // } elseif ($jenis_simpanan == 'simpananWajib') {
        //     $jenis_simpanan = 'Simpanan Wajib';
        //     $data['jenis'] = 'WAJIB';
        // }
        // // var_dump($jenis_simpanan);
        $jenis_simpanan = 'Simpanan Wajib';

        $data['simpanan'] = $this->print_models->viewSimpanan();
        $data['totalSimpanan'] = $this->print_models->getTotalSimpanan($jenis_simpanan);

        // var_dump($data['simpanan']);

        $this->load->view('templates/header', $data);
        $this->load->view('print/printSimpanan', $data);
    }

    public function printSimpananExcel()
    {
        $data['title'] = 'Laporan';
        $data['corp_name'] = 'BPN';
        $data['user'] = $this->app_models->getUserTable('user');
        $data['userdata'] = $this->app_models->getUserTable('user');
        $data['tanggal'] = new DateTime();

        $jenis_simpanan = $this->session->flashdata('jenis_simpanan');
        if ($jenis_simpanan == 'simpananPokok') {
            $jenis_simpanan = 'Simpanan Pokok';
            $data['jenis'] = 'POKOK';
        } elseif ($jenis_simpanan == 'simpananWajib') {
            $jenis_simpanan = 'Simpanan Wajib';
            $data['jenis'] = 'WAJIB';
        } elseif ($jenis_simpanan == 'simpananSukarela') {
            $jenis_simpanan = 'Simpanan Sukarela';
            $data['jenis'] = 'SUKARELA';
        }

        $data['simpanan'] = $this->print_models->getSimpanan($jenis_simpanan);
        $data['totalSimpanan'] = $this->print_models->getTotalSimpanan($jenis_simpanan);


        $this->load->view('templates/header', $data);
        $this->load->view('print/printSimpananExcel', $data);
    }

    public function printTanggalAndJenis()
    {
        $data['title'] = 'Laporan';
        $data['corp_name'] = 'BPN';
        $data['user'] = $this->app_models->getUserTable('user');
        $data['userdata'] = $this->app_models->getUserTable('user');
        $data['tanggal'] = new DateTime();
        $filter = $this->session->flashdata('filter');
        $tgl_awal = $filter[0];
        $tgl_akhir = $filter[1];
        $jenis_laporan = $filter[2];

        if ($jenis_laporan == 'pinjaman') {
            $data['pinjaman'] = $this->print_models->getPinjamanByTanggal($tgl_awal, $tgl_akhir);
            $data['totalPinjaman'] = $this->print_models->getTotalPinjamanByTanggal($tgl_awal, $tgl_akhir);
            $data['totalBunga'] = $this->print_models->getBungaByTanggal($tgl_awal, $tgl_akhir);

            if ($data['pinjaman'] == NULL) {
                $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal mencetak! </strong>Tidak ada data.</div>');
                redirect('laporan');
            } else {
                $this->load->view('templates/header', $data);
                $this->load->view('print/printPinjaman', $data);
            }
        } else {
            if ($jenis_laporan == 'simpananPokok') {
                $jenis_laporan = 'Simpanan Pokok';
                $data['jenis'] = 'POKOK';
            } elseif ($jenis_laporan == 'simpananWajib') {
                $jenis_laporan = 'Simpanan Wajib';
                $data['jenis'] = 'WAJIB';
            } elseif ($jenis_laporan == 'simpananSukarela') {
                $jenis_laporan = 'Simpanan Sukarela';
                $data['jenis'] = 'SUKARELA';
            }

            $data['simpanan'] = $this->print_models->getSimpananByTanggalAndJenis($tgl_awal, $tgl_akhir, $jenis_laporan);
            $data['totalSimpanan'] = $this->print_models->getTotalSimpananByTanggalAndJenis($tgl_awal, $tgl_akhir, $jenis_laporan);

            if ($data['simpanan'] == NULL) {
                $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal mencetak! </strong>Tidak ada data.</div>');
                redirect('laporan');
            } else {
                $this->load->view('templates/header', $data);
                $this->load->view('print/printSimpanan', $data);
            }
        }
    }

    public function printTanggalAndJenisExcel()
    {
        $data['title'] = 'Laporan';
        $data['corp_name'] = 'BPN';
        $data['user'] = $this->app_models->getUserTable('user');
        $data['userdata'] = $this->app_models->getUserTable('user');
        $data['tanggal'] = new DateTime();
        $filter = $this->session->flashdata('filter');
        $tgl_awal = $filter[0];
        $tgl_akhir = $filter[1];
        $jenis_laporan = $filter[2];

        if ($jenis_laporan == 'pinjaman') {
            $data['pinjaman'] = $this->print_models->getPinjamanByTanggal($tgl_awal, $tgl_akhir);
            $data['totalPinjaman'] = $this->print_models->getTotalPinjamanByTanggal($tgl_awal, $tgl_akhir);
            $data['totalBunga'] = $this->print_models->getBungaByTanggal($tgl_awal, $tgl_akhir);

            if ($data['pinjaman'] == NULL) {
                $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal mencetak! </strong>Tidak ada data.</div>');
                redirect('laporan');
            } else {
                $this->load->view('templates/header', $data);
                $this->load->view('print/printPinjamanExcel', $data);
            }
        } else {
            if ($jenis_laporan == 'simpananPokok') {
                $jenis_laporan = 'Simpanan Pokok';
                $data['jenis'] = 'POKOK';
            } elseif ($jenis_laporan == 'simpananWajib') {
                $jenis_laporan = 'Simpanan Wajib';
                $data['jenis'] = 'WAJIB';
            } elseif ($jenis_laporan == 'simpananSukarela') {
                $jenis_laporan = 'Simpanan Sukarela';
                $data['jenis'] = 'SUKARELA';
            }

            $data['jenis_laporan'] = $jenis_laporan;
            $data['simpanan'] = $this->print_models->getSimpananByTanggalAndJenis($tgl_awal, $tgl_akhir, $jenis_laporan);
            $data['totalSimpanan'] = $this->print_models->getTotalSimpananByTanggalAndJenis($tgl_awal, $tgl_akhir, $jenis_laporan);

            if ($data['simpanan'] == NULL) {
                $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal mencetak! </strong>Tidak ada data.</div>');
                redirect('laporan');
            } else {
                $this->load->view('templates/header', $data);
                $this->load->view('print/printSimpananExcel', $data);
            }
        }
    }

    public function printSHU()
    {
        $data['title'] = 'Laporan';
        $data['corp_name'] = 'BPN';
        $data['user'] = $this->app_models->getUserTable('user');
        $data['userdata'] = $this->app_models->getUserTable('user');
        $data['tanggal'] = new DateTime();

        $this->load->view('templates/header', $data);
        $this->load->view('print/printSHU');
    }

    public function export()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = [
            'font' => ['bold' => true], // Set font nya jadi bold
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis

                // Set border left dengan garis tipis
            ]
        ];

        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];

        $sheet->setCellValue('A1', "DATA SIMPANAN"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->mergeCells('A1:F1'); // Set Merge Cell pada kolom A1 sampai E1
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
        // Buat header tabel nya pada baris ke 3
        $sheet->setCellValue('A3', "No Simpanan"); // Set kolom A3 dengan tulisan "NO"
        $sheet->setCellValue('B3', "NIP"); // Set kolom A3 dengan tulisan "NO"
        $sheet->setCellValue('C3', "Nama Lengkap"); // Set kolom B3 dengan tulisan "NIS"
        $sheet->setCellValue('D3', "Simpanan"); // Set kolom C3 dengan tulisan "NAMA"
        $sheet->setCellValue('E3', "Tanggal Simpanan"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $sheet->setCellValue('F3', "Status"); // Set kolom E3 dengan tulisan "ALAMAT"
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);
        $sheet->getStyle('C3')->applyFromArray($style_col);
        $sheet->getStyle('D3')->applyFromArray($style_col);
        $sheet->getStyle('E3')->applyFromArray($style_col);
        $sheet->getStyle('F3')->applyFromArray($style_col);
        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
        $jenis_simpanan = 'simpananWajib';
        $data['dataSimpanan'] = $this->print_models->viewSimpanan();
        $simpanan = $data['dataSimpanan'];
        $total_simpanan = $data['totalSimpanan'] = $this->print_models->getTotalSimpanan($jenis_simpanan);

        $sheet->setCellValue('F2', "Total Simpanan" . $total_simpanan);
        // $no_simpanan = $this->print_models->getNoSimpanan($no_simpanan);
        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach ($simpanan as $data) { // Lakukan looping pada variabel siswa
            $sheet->setCellValue('A' . $numrow, $data['no_simpanan']);
            $sheet->setCellValue('B' . $numrow, $data['nip']);
            $sheet->setCellValue('C' . $numrow, $data['nama_lengkap']);
            $sheet->setCellValue('D' . $numrow, $data['simpanan']);
            $sheet->setCellValue('E' . $numrow, $data['tgl_simpanan']);
            $sheet->setCellValue('F' . $numrow, $data['status']);

            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);

            // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        }

        // Set width kolom
        $sheet->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $sheet->getColumnDimension('B')->setWidth(25); // Set width kolom B
        $sheet->getColumnDimension('C')->setWidth(15); // Set width kolom C
        $sheet->getColumnDimension('D')->setWidth(20); // Set width kolom D
        $sheet->getColumnDimension('E')->setWidth(30); // Set width kolom E
        $sheet->getColumnDimension('F')->setWidth(30); // Set width kolom E

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $sheet->setTitle("Laporan Data Simpanan");
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Simpanan.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }


    public function exportPinjam()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = [
            'font' => ['bold' => true], // Set font nya jadi bold
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis

                // Set border left dengan garis tipis
            ]
        ];

        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];

        $sheet->setCellValue('A1', "DATA PINJAMAN"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
        // Buat header tabel nya pada baris ke 3
        $sheet->setCellValue('A3', "No Pinjaman"); // Set kolom A3 dengan tulisan "NO"
        $sheet->setCellValue('B3', "NIP"); // Set kolom A3 dengan tulisan "NO"
        $sheet->setCellValue('C3', "Nama Anggota"); // Set kolom B3 dengan tulisan "NIS"
        $sheet->setCellValue('D3', "Pinjaman Pokok"); // Set kolom C3 dengan tulisan "NAMA"
        $sheet->setCellValue('E3', "Bunga"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $sheet->setCellValue('F3', "Tanggal Pinjaman"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('G3', "Jangka Waktu"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('H3', "Tanggal Selesai"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('I3', "Angsuran"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('J3', "Keterangan"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('K3', "Status"); // Set kolom E3 dengan tulisan "ALAMAT"
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);
        $sheet->getStyle('C3')->applyFromArray($style_col);
        $sheet->getStyle('D3')->applyFromArray($style_col);
        $sheet->getStyle('E3')->applyFromArray($style_col);
        $sheet->getStyle('F3')->applyFromArray($style_col);
        $sheet->getStyle('G3')->applyFromArray($style_col);
        $sheet->getStyle('H3')->applyFromArray($style_col);
        $sheet->getStyle('I3')->applyFromArray($style_col);
        $sheet->getStyle('J3')->applyFromArray($style_col);
        $sheet->getStyle('K3')->applyFromArray($style_col);
        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
        // $jenis_simpanan = 'simpananWajib';
        $data['dataPinjaman'] = $this->print_models->viewPinjaman();
        // $data['totalPinjaman'] = $this->print_models->getTotalPinjaman($jenis_simpanan);
        // $total_pinjaman = $data['totalPinjaman'] = $this->print_models->getTotalPinjaman();
        // $sheet->setCellValue('J2', "Total Pinjaman : Rp. " . $total_pinjaman);
        // $sheet->mergeCells('J2:K2'); // Set Merge Cell pada kolom A1 sampai E1
        // $sheet->getStyle('J2')->getFont()->setBold(true);
        $total_pinjaman = $data['totalPinjaman'] = $this->print_models->getTotalPinjaman();
        $sheet->setCellValue('J2', "Total Pinjaman : Rp. " . $total_pinjaman);
        $sheet->mergeCells('J2:K2'); // Set Merge Cell pada kolom A1 sampai E1
        $sheet->getStyle('J2')->getFont()->setBold(true)->setSize(16); // Atur ukuran font
        $sheet->getStyle('J2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Atur teks di tengah sel

        $pinjaman = $data['dataPinjaman'];
        // $no_simpanan = $this->print_models->getNoSimpanan($no_simpanan);
        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach ($pinjaman as $data) { // Lakukan looping pada variabel siswa
            // $sheet->setCellValue('A' . $numrow, $data->no_pinjaman);
            // $sheet->setCellValue('B' . $numrow, $data->id_anggota);
            // $sheet->setCellValue('C' . $numrow, $data->username);
            // $sheet->setCellValue('D' . $numrow, $data->pinjaman_pokok);
            // $sheet->setCellValue('E' . $numrow, $data->bunga);
            // $sheet->setCellValue('F' . $numrow, $data->tgl_pinjaman);
            // $sheet->setCellValue('G' . $numrow, $data->jangka_waktu);
            // $sheet->setCellValue('H' . $numrow, $data->tgl_selesai);
            // $sheet->setCellValue('I' . $numrow, $data->angsuran);
            // $sheet->setCellValue('J' . $numrow, $data->keterangan);
            // $sheet->setCellValue('K' . $numrow, $data->status);
            $sheet->setCellValue('A' . $numrow, $data['no_pinjaman']);
            $sheet->setCellValue('B' . $numrow, $data['nip']);
            $sheet->setCellValue('C' . $numrow, $data['nama_lengkap']);
            $sheet->setCellValue('D' . $numrow, $data['pinjaman_pokok']);
            $sheet->setCellValue('E' . $numrow, $data['bunga']);
            $sheet->setCellValue('F' . $numrow, $data['tgl_pinjaman']);
            $sheet->setCellValue('G' . $numrow, $data['jangka_waktu']);
            $sheet->setCellValue('H' . $numrow, $data['tgl_selesai']);
            $sheet->setCellValue('I' . $numrow, $data['angsuran']);
            $sheet->setCellValue('J' . $numrow, $data['keterangan']);
            $sheet->setCellValue('K' . $numrow, $data['status']);

            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('G' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('H' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('I' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('J' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('K' . $numrow)->applyFromArray($style_row);

            // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        }

        // Set width kolom
        $sheet->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $sheet->getColumnDimension('B')->setWidth(15); // Set width kolom B
        $sheet->getColumnDimension('C')->setWidth(25); // Set width kolom C
        $sheet->getColumnDimension('D')->setWidth(20); // Set width kolom D
        $sheet->getColumnDimension('E')->setWidth(30); // Set width kolom E
        $sheet->getColumnDimension('F')->setWidth(30); // Set width kolom E
        $sheet->getColumnDimension('G')->setWidth(30); // Set width kolom E
        $sheet->getColumnDimension('H')->setWidth(30); // Set width kolom E
        $sheet->getColumnDimension('I')->setWidth(30); // Set width kolom E
        $sheet->getColumnDimension('J')->setWidth(30); // Set width kolom E
        $sheet->getColumnDimension('K')->setWidth(30); // Set width kolom E

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $sheet->setTitle("Laporan Data Pinjaman");
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Pinjaman.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    // public function printExcel()
    // {
    //     // require(APPPATH . 'PHPExcel-1.8/Classes/PHPExcel.php');
    //     // require(APPPATH . 'PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');

    //     $data['title'] = 'Laporan';
    //     $data['corp_name'] = 'BPN';
    //     $data['user'] = $this->app_models->getUserTable('user');
    //     $data['userdata'] = $this->app_models->getUserTable('userdata');
    //     $data['tanggal'] = new DateTime();



    //     $object = new PHPExcel();

    //     $object->getProperties()->setCreator("Framework Indonesia");
    //     $object->getProperties()->setLastModifiedBy("Framework Indonesia");
    //     $object->getProperties()->setTitle("Data Simpanan & Pinjaman");

    //     $object->setActiveSheetIndex(0);

    //     $object->getActiveSheet()->setCellValue('A1', 'NO');
    //     $object->getActiveSheet()->setCellValue('B1', 'USERNAME');
    //     $object->getActiveSheet()->setCellValue('C1', 'SIMPANAN');
    //     $object->getActiveSheet()->setCellValue('D1', 'PINJAMAN');

    //     $baris = 2;
    //     $no = 1;

    //     $sql = "SELECT SUM(`simpanan`) AS simpananshu FROM `simpanan` WHERE `jenis_simpanan` = 'Simpanan Pokok' OR jenis_simpanan = 'Simpanan Wajib'";
    //     $shusimpanan = $this->db->query($sql)->row_array();
    //     $shusimpanan = $shusimpanan['simpananshu'];


    //     $sql = "SELECT SUM(`pinjaman_pokok`) AS pinjamanshu FROM `pinjaman`";
    //     $shupinjaman = $this->db->query($sql)->row_array();
    //     $shupinjaman = $shupinjaman['pinjamanshu'];
    //     // if ($this->session->userdata('level') == 2) :
    //     $users = $this->db->get('user')->result_array();



    //     // var_dump($shupinjaman);
    //     // var_dump($shusimpanan);
    //     // die;

    //     foreach ($users as $user) {
    //         $username = $user['username'];
    //         $query = " SELECT `username`, (SELECT SUM(`pinjaman_pokok`) FROM `pinjaman` WHERE `username` = '$username' AND keterangan = '2') AS pinjaman,
    //                                                 (SELECT SUM(`simpanan`) FROM `simpanan`  WHERE `username` = '$username' AND status = '2') AS simpanan
    //                                                 FROM `user` WHERE `username` = '$username'";
    //         $total = $this->db->query($query)->row_array();
    //         // simpanan / jumlah seluruh simpanan x 20% x 40000000 = 800000
    //         // echo round(($total['simpanan'] / $shusimpanan['simpananshu']), 3);
    //         // die;
    //         if ($total['simpanan'] == NULL) {
    //             $shus = 0;
    //         } else {
    //             $shus = ($total['simpanan']);
    //             $shus = floor($shus);
    //         }

    //         // (nilai pinjamannya / 20000000) * 25% * 10000000
    //         if ($total['pinjaman'] == NULL) {
    //             $shup = 0;
    //         } else {

    //             $shup = ($total['pinjaman']);
    //             $shup = floor($shup);
    //         }

    //         $object->getActiveSheet()->setCellValue('A' . $baris, $no++);
    //         $object->getActiveSheet()->setCellValue('B' . $baris, $user->username);
    //         $object->getActiveSheet()->setCellValue('C' . $baris, $user->simpanan);
    //         $object->getActiveSheet()->setCellValue('D' . $baris, $user->pinjaman);

    //         $baris++;

    //         // $totalshu = $shus + $shup;
    //     }

    //     $filename = "Data_Koperasi" . '.xlsx';

    //     $object->getActiveSheet()->setTitle("Data Koperasi");

    //     header('Content-Type : application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //     header('Content-Disposition: attachment;filename="' . $filename . '"');
    //     header('Cache-Control: max-age=0');

    //     $writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
    //     $writer->save('php://output');



    //     $this->load->view('templates/header', $data);
    //     $this->load->view('print/printSHU');

    //     exit;
    // }

    // public function printExcel()
    // {
    // }
}
