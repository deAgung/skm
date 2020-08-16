<?php
class Login_m extends CI_Model{
    function verify_login($tabel,$username,$password){
        $data = $this->db->select('*')->where('username',$username)->get($tabel)->result_array();
        if(count($data) != 0){
            if($data[0]['password'] != $password){
                $message['stat'] = false;
                $message['pesan'] = 'Password tidak cocok';
            } else {
                $message['data'] = $data[0];
                $message['stat'] = true;
                $message['pesan'] = 'Login berhasil';
            }
        } else {
            $message['stat'] = false;
            $message['pesan'] = 'Username tidak ditemukan';
        }
        return $message;
    }
    function cek_login(){
        $token = $this->session->userdata('username');
        if(!empty($token)){
            return true;
        } else {
            redirect('login');
        }
    }
}
?>