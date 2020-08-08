<?php
defined('BASEPATH') or exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Mahasiswa_api extends REST_Controller {
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Mahasiswa_m');
    }

    public function input_post()
    {
        header("Access-Control-Allow-Origin: *");

        $token = $this->session->userdata('user');
        $jwt_hasil = $this->authorization_token->validateTokenPost($token);
        if($jwt_hasil['status']== TRUE){
            $data = (array) $jwt_hasil['data'];
            if($data['status']==5){
                $nim = $this->post('nim');
                $nama = $this->post('nama');
                $alamat = $this->post('alamat');
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
                            $this->response($message, REST_Controller::HTTP_OK);
                        } else {
                            $message = array(
                                'status' => false,
                                'message' => 'Registrasi mahasiswa gagal dilakukan'
                            );
                            $this->response($message, REST_Controller::HTTP_OK);
                        }
                    } else {
                        $message = array(
                            'status' => false,
                            'message' => 'NIM sudah digunakan'
                        );
                        $this->response($message, REST_Controller::HTTP_OK);
                    }
                } else {
                    $message = array(
                        'status' => false,
                        'message' => 'Isian tidak boleh kosong'
                    );
                    $this->response($message, REST_Controller::HTTP_OK);
                }
            } else {
                $message = array(
                    'status' => false,
                    'message' => 'Hak akses ditolak'
                );
                $this->response($message, REST_Controller::HTTP_OK);
            }    
        } else {
            $message = array(
                'status' => false,
                'message' => 'Token tidak diterima'
            );
            $this->response($message, REST_Controller::HTTP_OK);
        }
    }

    public function fetchAllMahasiswa_get()
    {
        $token = $this->session->userdata('user');
        $jwt_hasil = $this->authorization_token->validateTokenPost($token);
        if($jwt_hasil['status']== TRUE){
            $data = (array) $jwt_hasil['data'];
            if($data['status']==5){
                $output = $this->Mahasiswa_m->fetchAllMahasiswa();
                if(!empty($output) AND $output != FALSE){
                    $message = array(
                        'status' => true,
                        'data' => $output,
                        'message' => 'Mahasiswa sudah ada'
                    );
                    $this->response($message, REST_Controller::HTTP_OK);
                } else {
                    $message = array(
                        'status' => false,
                        'message' => 'Belum ada mahasiswa'
                    );
                    $this->response($message, REST_Controller::HTTP_OK);
                }
            } else {
                $message = array(
                    'status' => false,
                    'message' => 'Hak akses ditolak'
                );
                $this->response($message, REST_Controller::HTTP_OK);
            }
        } else {
            $message = array(
                'status' => false,
                'message' => 'Token tidak diterima'
            );
            $this->response($message, REST_Controller::HTTP_OK);
        }
    }
    
    public function update_post()//belum
    {
        header("Access-Control-Allow-Origin: *");
        
        $token = $this->session->userdata('user');
        $jwt_hasil = $this->authorization_token->validateTokenPost($token);
        if($jwt_hasil['status']== TRUE){
            $data = (array) $jwt_hasil['data'];
            $nim = $this->post('nim');
            $nama = $this->post('nama');
            $alamat = $this->post('alamat');
            if($data['status']==5){
                $newData = array(
                    'username' => $nim,
                    'nama' => $nama,
                    'alamat' => $alamat,
                    'password' => $nim
                );
            
                $output = $this->Mahasiswa_m->updateMahasiswa($nim,$newData);
                if(!empty($output) AND $output != FALSE){
                    $message = array(
                        'status' => true,
                        'message' => 'Update mahasiswa berhasil'
                    );
                    $this->response($message, REST_Controller::HTTP_OK);
                } else {
                    $message = array(
                        'status' => false,
                        'message' => 'Pengajuan mahasiswa gagal'
                    );
                    $this->response($message, REST_Controller::HTTP_OK);
                }
            } else {
                $message = array(
                    'status' => false,
                    'message' => 'Hak akses ditolak'
                );
                $this->response($message, REST_Controller::HTTP_OK);
            }
        } else {
            $message = array(
                'status' => false,
                'message' => 'Token tidak diterima'
            );
            $this->response($message, REST_Controller::HTTP_OK);
        }
    }
}