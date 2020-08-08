<?php
class Mahasiswa_m extends CI_Model{
    protected $tabel = 'mahasiswa';

    function insertMahasiswa($newData){//ok
        $data = $this->db->insert($this->tabel, $newData);
        return $data;
    }
    
    function fetchAllMahasiswa(){//ok
        $data = $this->db->select('*')->get($this->tabel)->result_array();
        return $data;
    }

    function cekNim($nim){//ok
        $data = $this->db->select('*')->where('username',$nim)->get($this->tabel)->result_array();
        return $data;
    }

    function updateMahasiswa($username,$newData){//ok
        $data = $this->db->where('username',$username)->update($this->tabel,$newData);
        return $data;
    }
}
?>