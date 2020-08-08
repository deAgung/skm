<?php
class Pengajuan_m extends CI_Model{
    protected $tabel_ajukan = 'pengajuan_skm';

    function insertPengajuan($newData){//ok
        $data = $this->db->insert($this->tabel_ajukan, $newData);
        return $data;
    }
    
    function fetchReqForOpr(){//ok
        $data = $this->db->select('*')->where('status',1)->order_by('tanggal', 'DESC')->get($this->tabel_ajukan)->result_array();
        return $data;
    }

    function fetchReqForkpl(){//ok
        $data = $this->db->select('*')->where('status',2)->order_by('tanggal', 'DESC')->get($this->tabel_ajukan)->result_array();
        return $data;
    }
    
    function fetchReqPengajuanByNim($username){//beranda_v
        $data = $this->db->select('*')->where('username',$username)->where('status',1)->order_by('tanggal', 'DESC')->get($this->tabel_ajukan)->result_array();
        return $data;
    }
    
    function fetchPengajuanByNim($username){//beranda_v
        $data = $this->db->select('*')->where('username',$username)->where('status >',1)->order_by('tanggal', 'DESC')->get($this->tabel_ajukan)->result_array();
        return $data;
    }
    
    function fetchHisForOpr(){//ok
        $data = $this->db->select('*')->where('status >',1)->order_by('tanggal', 'DESC')->get($this->tabel_ajukan)->result_array();
        return $data;
    }
    
    function fetchHisForKpl(){//ok
        $data = $this->db->select('*')->where('status >',2)->order_by('tanggal', 'DESC')->get($this->tabel_ajukan)->result_array();
        return $data;
    }

    function updatePengajuan($id,$newData){//ok
        $data = $this->db->where('id',$id)->update($this->tabel_ajukan,$newData);
        return $data;
    }

    function fetchMaxSkm(){//ok
        $data = $this->db->select_max('no_skm')->get($this->tabel_ajukan)->result_array();
        return $data;
    }
}
?>