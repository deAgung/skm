<?php
defined('BASEPATH') or exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Login_api extends REST_Controller {
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Login_m');
    }

    public function verify_post()
    {
        header("Access-Control-Allow-Origin: *");

        $username = $this->post('username');
        $password = $this->post('password');
        
        if(empty($username) OR empty($password)){
            $message = array(
                'status' => false,
                'message' => "Username dan password harus terisi."
            );
            $this->response($message, REST_Controller::HTTP_OK);
        } else {
            $awalan = substr($username,0,1);
            if(is_numeric(substr($username,0,1))){
                $tabel = 'mahasiswa';
            } else {
                $tabel = 'admin';
            }
            $output = $this->Login_m->verify_login($tabel,$username,$password);
            if($output['stat']==true){
                $token_data['id'] = rand(1,101);
                $token_data['username'] = $output['data']['username'];
                $token_data['nama'] = $output['data']['nama'];
                $token_data['status'] = $output['data']['status'];
                $token_data['time'] = time();
                $user_token = $this->authorization_token->generateToken($token_data);
                
                $data = array ('user' => $user_token, 'st' => $output['data']['status']);
                
                $this->session->set_userdata($data);

                $message = array(
                    'status' => true,
                    'data' => $user_token,
                    'message' => $output['pesan']
                );
                $this->response($message, REST_Controller::HTTP_OK);
            } else {
                $message = array(
                    'status' => false,
                    'message' => $output['pesan']
                );
                $this->response($message, REST_Controller::HTTP_OK);
            }
        }
    }
}