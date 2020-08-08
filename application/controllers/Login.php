<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function __construct()
    {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
	}
	
	public function index()
	{
		$this->load->view('Login_v');
	}
	
	public function logout()
	{
	    $this->session->sess_destroy();
		redirect('login');
	}
}