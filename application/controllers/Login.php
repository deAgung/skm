<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function __construct()
    {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('Login_m');
	}
	
	public function index()
	{
		$this->load->view('Login_v');
	}

	public function verify()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        if(empty($username) OR empty($password)){
            $message = array(
                'status' => false,
                'message' => "Username dan password harus terisi."
            );
            echo json_encode($message);
        } else {
            $awalan = substr($username,0,1);
            if(is_numeric(substr($username,0,1))){
                $tabel = 'mahasiswa';
            } else {
                $tabel = 'admin';
            }
            $output = $this->Login_m->verify_login($tabel,$username,$password);
            if($output['stat']==true){
                $data = array (
                    'st' => $output['data']['status'],
                    'username' => $output['data']['username'],
                    'nama' => $output['data']['nama']
                );
                
                $this->session->set_userdata($data);

                $message = array(
                    'status' => true,
                    'message' => $output['pesan']
                );
                echo json_encode($message);
            } else {
                $message = array(
                    'status' => false,
                    'message' => $output['pesan']
                );
                echo json_encode($message);
            }
        }
    }
	
	public function logout()
	{
	    $this->session->sess_destroy();
		redirect('login');
	}
}