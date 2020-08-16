<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa extends CI_Controller {
	public function __construct()
    {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->CheckLogin->cek_login();
		$this->load->model('Mahasiswa_m');
	}
	
	public function index()
	{
		$this->load->view('template/PageHead');
		$this->load->view('template/PageNavbar');
		$this->load->view('Mahasiswa_v');
		$this->load->view('template/PageEndLobi');
	}

	public function input()
    {
        if($this->session->userdata('st')==5){
            $nim = $this->input->post('nim');
            $nama = $this->input->post('nama');
            $alamat = $this->input->post('alamat');
            $cek = $this->Mahasiswa_m->cekNim($nim);
            if(!empty($nim) && !empty($nama) && !empty($alamat)){ 
                if(count($cek)<1){//nim belum digunakan
                    $newData = array(
                        'username' => $nim,
                        'nama' => $nama,
                        'alamat' => $alamat,
                        'password' => $nim
                    );
                    $output = $this->Mahasiswa_m->insertMahasiswa($newData);
                    if(!empty($output) AND $output != FALSE){
                        $message = array(
                            'status' => true,
                            'message' => 'Registrasi mahasiswa berhasil'
                        );
                        echo json_encode($message);
                    } else {
                        $message = array(
                            'status' => false,
                            'message' => 'Registrasi mahasiswa gagal dilakukan'
                        );
                        echo json_encode($message);
                    }
                } else {
                    $message = array(
                        'status' => false,
                        'message' => 'NIM sudah digunakan'
                    );
                    echo json_encode($message);
                }
            } else {
                $message = array(
                    'status' => false,
                    'message' => 'Isian tidak boleh kosong'
                );
                echo json_encode($message);
            }
        } else {
            $message = array(
                'status' => false,
                'message' => 'Hak akses ditolak'
            );
            echo json_encode($message);
        }    
    }

    public function fetchAllMahasiswa()
    {
        if($this->session->userdata('st')==5){
            $output = $this->Mahasiswa_m->fetchAllMahasiswa();
            if(!empty($output) AND $output != FALSE){
                $message = array(
                    'status' => true,
                    'data' => $output,
                    'message' => 'Mahasiswa sudah ada'
                );
                echo json_encode($message);
            } else {
                $message = array(
                    'status' => false,
                    'message' => 'Belum ada mahasiswa'
                );
                echo json_encode($message);
            }
        } else {
            $message = array(
                'status' => false,
                'message' => 'Hak akses ditolak'
            );
            echo json_encode($message);
        }
    }
}