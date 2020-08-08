<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Beranda extends CI_Controller {
	public function __construct()
    {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
	}
	
	public function index()
	{
		$time = date("H");
		// echo (int)$time;
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
}