<?php
defined('BASEPATH') or exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Pengajuan_api extends REST_Controller {
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Pengajuan_m');
    }

    public function input_post()
    {
        header("Access-Control-Allow-Origin: *");

        $token = $this->session->userdata('user');
        //ntar validasi jwt dulu, kalo cocok, baru lanjut
        $jwt_hasil = $this->authorization_token->validateTokenPost($token);
        if($jwt_hasil['status']== TRUE){
            $data = (array) $jwt_hasil['data'];
            $tujuan = $this->post('tujuan');
            if(!empty($tujuan)){
                $newData = array(
                    'username' => $data['username'],
                    'nama' => $data['nama'],
                    'tujuan' => $tujuan
                );
                
                $output = $this->Pengajuan_m->insertPengajuan($newData);
                if(!empty($output) AND $output != FALSE){
                    $message = array(
                        'status' => true,
                        'message' => 'Pengajuan berhasil diberikan'
                    );
                    $this->response($message, REST_Controller::HTTP_OK);
                } else {
                    $message = array(
                        'status' => false,
                        'message' => 'Pengajuan gagal diberikan'
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
                'message' => 'Token tidak diterima'
            );
            $this->response($message, REST_Controller::HTTP_OK);
        }
    }

    public function fetchPengajuanUser_get()
    {
        $token = $this->session->userdata('user');
        $jwt_hasil = $this->authorization_token->validateTokenPost($token);
        if($jwt_hasil['status']== TRUE){
            $data = (array) $jwt_hasil['data'];
            $output = $this->Pengajuan_m->fetchReqPengajuanByNim($data['username']);
            if(!empty($output) AND $output != FALSE){
                $message = array(
                    'status' => true,
                    'data' => $output,
                    'message' => 'Riwayat sudah ada'
                );
                $this->response($message, REST_Controller::HTTP_OK);
            } else {
                $message = array(
                    'status' => false,
                    'message' => 'Belum ada pengajuan'
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

    public function fetchAllPengajuanUser_get()
    {
        $token = $this->session->userdata('user');
        $jwt_hasil = $this->authorization_token->validateTokenPost($token);
        if($jwt_hasil['status']== TRUE){
            $data = (array) $jwt_hasil['data'];
            $output = $this->Pengajuan_m->fetchPengajuanByNim($data['username']);
            if(!empty($output) AND $output != FALSE){
                $message = array(
                    'status' => true,
                    'data' => $output,
                    'message' => 'Riwayat sudah ada'
                );
                $this->response($message, REST_Controller::HTTP_OK);
            } else {
                $message = array(
                    'status' => false,
                    'message' => 'Belum ada pengajuan'
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

    public function fetchPengajuanBaru_get()
    {
        $token = $this->session->userdata('user');
        $jwt_hasil = $this->authorization_token->validateTokenPost($token);
        if($jwt_hasil['status']== TRUE){
            $output = $this->Pengajuan_m->fetchReqForOpr();
            if(!empty($output) AND $output != FALSE){
                $message = array(
                    'status' => true,
                    'data' => $output,
                    'message' => 'Riwayat sudah ada'
                );
                $this->response($message, REST_Controller::HTTP_OK);
            } else {
                $message = array(
                    'status' => false,
                    'message' => 'Belum ada pengajuan'
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

    public function fetchAllPengajuan_get()
    {
        $token = $this->session->userdata('user');
        $jwt_hasil = $this->authorization_token->validateTokenPost($token);
        if($jwt_hasil['status']== TRUE){
            // $data = (array) $jwt_hasil['data'];
            $output = $this->Pengajuan_m->fetchHisForOpr();
            if(!empty($output) AND $output != FALSE){
                $message = array(
                    'status' => true,
                    'data' => $output,
                    'message' => 'Riwayat sudah ada'
                );
                $this->response($message, REST_Controller::HTTP_OK);
            } else {
                $message = array(
                    'status' => false,
                    'message' => 'Belum ada pengajuan'
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

    public function fetchReqFinal_get()
    {
        $token = $this->session->userdata('user');
        $jwt_hasil = $this->authorization_token->validateTokenPost($token);
        if($jwt_hasil['status']== TRUE){
            $output = $this->Pengajuan_m->fetchReqForKpl();
            if(!empty($output) AND $output != FALSE){
                $message = array(
                    'status' => true,
                    'data' => $output,
                    'message' => 'Riwayat sudah ada'
                );
                $this->response($message, REST_Controller::HTTP_OK);
            } else {
                $message = array(
                    'status' => false,
                    'message' => 'Belum ada pengajuan'
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

    public function fetchAllFinal_get()
    {
        $token = $this->session->userdata('user');
        $jwt_hasil = $this->authorization_token->validateTokenPost($token);
        if($jwt_hasil['status']== TRUE){
            // $data = (array) $jwt_hasil['data'];
            $output = $this->Pengajuan_m->fetchHisForKpl();
            if(!empty($output) AND $output != FALSE){
                $message = array(
                    'status' => true,
                    'data' => $output,
                    'message' => 'Riwayat sudah ada'
                );
                $this->response($message, REST_Controller::HTTP_OK);
            } else {
                $message = array(
                    'status' => false,
                    'message' => 'Belum ada pengajuan'
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

    public function update_post()
    {
        header("Access-Control-Allow-Origin: *");
        
        $token = $this->session->userdata('user');
        //ntar validasi jwt dulu, kalo cocok, baru lanjut
        $jwt_hasil = $this->authorization_token->validateTokenPost($token);
        if($jwt_hasil['status']== TRUE){
            $data = (array) $jwt_hasil['data'];
            $id = $this->post('id');
            $indeks = $this->post('indeks');
            $today = date("Y-m-d H:i:s");

            if($indeks == 5){
                $psn = 'tolak';
                $newData = array(
                    'status' => $indeks,
                    'tgl_final' => $today
                );
            } else if($indeks == 4){
                $psn = 'setujui';
                $max = $this->Pengajuan_m->fetchMaxSkm();
                $dataMax = (array) $max[0];
                $noSKM = $dataMax['no_skm']+1;
                $no = (string) $noSKM;
                $pjg = strlen($no);
                if($pjg==1){
                    $noSurat = '00'.$no;
                } else if($pjg==2){
                    $noSurat = '0'.$no;
                } else if($pjg==3){
                    $noSurat = $no;
                }
                $newData = array(
                    'status' => $indeks,
                    'tgl_final' => $today,
                    'no_skm' => $noSKM,
                    'no_surat' => 'B-'.$noSurat.'/2710/KM/'.date("m").'/'.date("Y")
                );
            } else if($indeks == 3){
                $psn = 'tolak';
                $newData = array(
                    'status' => $indeks,
                    'tgl_setuju' => $today
                );
            } else if($indeks == 2){
                $psn = 'setujui';
                $newData = array(
                    'status' => $indeks,
                    'tgl_setuju' => $today
                );
            } else if($indeks == 0){
                $psn = 'batalkan';
                $newData = array(
                    'status' => $indeks,
                    // 'tanggal' => $today
                );
            }
            
            $output = $this->Pengajuan_m->updatePengajuan($id,$newData);
            if(!empty($output) AND $output != FALSE){
                $message = array(
                    'status' => true,
                    'message' => 'Pengajuan berhasil di' . $psn
                );
                $this->response($message, REST_Controller::HTTP_OK);
            } else {
                $message = array(
                    'status' => false,
                    'message' => 'Pengajuan gagal di'. $psn
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