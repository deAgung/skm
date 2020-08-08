<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa extends CI_Controller {
	public function __construct()
    {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->CheckLogin->cek_login();
	}
	
	public function index()
	{
		$this->load->view('template/PageHead');
		$this->load->view('template/PageNavbar');
		$this->load->view('Mahasiswa_v');
		$this->load->view('template/PageEndLobi');
	}
}