<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Beranda extends CI_Controller {
	public function __construct()
    {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->CheckLogin->cek_login();
		$this->load->model('Pengajuan_m');
	}
	
	public function index()
	{
		$time = date("H");
		
		if($time>5 && $time<11){
			$greet = 'Selamat pagi!';
		} else if($time>10 && $time<18){
			$greet = 'Selamat siang!';
		} else if($time>17 || $time<6){
			$greet = 'Selamat malam!';
		}

		$level = $this->session->userdata('st');
		
		$data= array('greeting'=>$greet);
		$this->load->view('template/PageHead');
		$this->load->view('template/PageNavbar');
		if($level == 1){
			$this->load->view('Beranda_v',$data);
		} else if($level == 3){
			$this->load->view('Operator_v',$data);
		} else if($level == 5){
			$this->load->view('Kepala_v',$data);
		}
		$this->load->view('template/PageEndLobi');
	}

	public function input()
    {
        $tujuan = $this->input->post('tujuan');
        if(!empty($tujuan)){
            $newData = array(
                'username' => $this->session->userdata('username'),
                'nama' => $this->session->userdata('nama'),
                'tujuan' => $tujuan
            );
            
            $output = $this->Pengajuan_m->insertPengajuan($newData);
            if(!empty($output) AND $output != FALSE){
                $message = array(
                    'status' => true,
                    'message' => 'Pengajuan berhasil diberikan'
                );
                echo json_encode($message);
            } else {
                $message = array(
                    'status' => false,
                    'message' => 'Pengajuan gagal diberikan'
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
	}
	
	public function fetchPengajuanUser()
    {
        $output = $this->Pengajuan_m->fetchReqPengajuanByNim($this->session->userdata('username'));
        if(!empty($output) AND $output != FALSE){
            $message = array(
                'status' => true,
                'data' => $output,
                'message' => 'Riwayat sudah ada'
            );
            echo json_encode($message);
        } else {
            $message = array(
                'status' => false,
                'message' => 'Belum ada pengajuan'
            );
            echo json_encode($message);
        }
	}
	
	public function fetchAllPengajuanUser()
    {
        $output = $this->Pengajuan_m->fetchPengajuanByNim($this->session->userdata('username'));
        if(!empty($output) AND $output != FALSE){
            $message = array(
                'status' => true,
                'data' => $output,
                'message' => 'Riwayat sudah ada'
            );
            echo json_encode($message);
        } else {
            $message = array(
                'status' => false,
                'message' => 'Belum ada pengajuan'
            );
            echo json_encode($message);
        }
    }

    public function fetchPengajuanBaru()
    {
        $output = $this->Pengajuan_m->fetchReqForOpr();
        if(!empty($output) AND $output != FALSE){
            $message = array(
                'status' => true,
                'data' => $output,
                'message' => 'Riwayat sudah ada'
            );
            echo json_encode($message);
        } else {
            $message = array(
                'status' => false,
                'message' => 'Belum ada pengajuan'
            );
            echo json_encode($message);
        }
    }

    public function fetchAllPengajuan()
    {
        $output = $this->Pengajuan_m->fetchHisForOpr();
        if(!empty($output) AND $output != FALSE){
            $message = array(
                'status' => true,
                'data' => $output,
                'message' => 'Riwayat sudah ada'
            );
            echo json_encode($message);
        } else {
            $message = array(
                'status' => false,
                'message' => 'Belum ada pengajuan'
            );
            echo json_encode($message);
        }
    }

    public function fetchReqFinal()
    {
        
        $output = $this->Pengajuan_m->fetchReqForKpl();
        if(!empty($output) AND $output != FALSE){
            $message = array(
                'status' => true,
                'data' => $output,
                'message' => 'Riwayat sudah ada'
            );
            echo json_encode($message);
        } else {
            $message = array(
                'status' => false,
                'message' => 'Belum ada pengajuan'
            );
            echo json_encode($message);
        }
    }

    public function fetchAllFinal()
    {
        $output = $this->Pengajuan_m->fetchHisForKpl();
        if(!empty($output) AND $output != FALSE){
            $message = array(
                'status' => true,
                'data' => $output,
                'message' => 'Riwayat sudah ada'
            );
            echo json_encode($message);
        } else {
            $message = array(
                'status' => false,
                'message' => 'Belum ada pengajuan'
            );
            echo json_encode($message);
        }
    }

    public function update()
    {
        
        $id = $this->input->post('id');
        $indeks = $this->input->post('indeks');
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
                'status' => $indeks
            );
        }
        
        $output = $this->Pengajuan_m->updatePengajuan($id,$newData);
        if(!empty($output) AND $output != FALSE){
            $message = array(
                'status' => true,
                'message' => 'Pengajuan berhasil di' . $psn
            );
            echo json_encode($message);
        } else {
            $message = array(
                'status' => false,
                'message' => 'Pengajuan gagal di'. $psn
            );
            echo json_encode($message);
        }
    }
}