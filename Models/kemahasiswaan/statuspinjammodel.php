<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!session_id()) session_start();

class statusPinjamModel extends CI_Model 
{
    function __construct()
    {
        parent::__construct();	
    }

    function getRuang()
    {
		$sql = "SELECT * FROM (SELECT * FROM ruang_rapat WHERE kd_ruang < 200 AND nm_ruang <> '') as a 
				UNION ALL
				SELECT * FROM (SELECT * FROM ruang_rapat WHERE kd_ruang >= 200  AND nm_ruang <> '' order by nm_ruang) as b";
		$result = mysql_query($sql) or die(mysql_error());
        $data = array();
		while($rows = mysql_fetch_object($result)){
            $data[] = $rows;
		}
		return $data;
    }

    function getRows($params = array()){

        /*$sql = "SELECT *, DAY(start_date) as tgl, MONTH(start_date) as bulan, YEAR(start_date) as tahun, nm_ruang 
                FROM kegiatan a, waktu b, ruang_rapat c 
                WHERE a.nomor = b.nomor AND b.ruang = kd_ruang AND flag_ppaa = 0 AND start_date >= CURDATE()
                ORDER BY id_kegiatan DESC, YEAR(start_date) DESC, MONTH(start_date) DESC";*/

        $this->db->select("a.*, start_date, end_date, DAY(start_date) as tgl, MONTH(start_date) as bulan, YEAR(start_date) as tahun, nm_ruang");
        $this->db->from("kegiatan a, waktu b, ruang_rapat c");
        $this->db->where("a.nomor = b.nomor AND b.ruang = kd_ruang AND flag_ppaa = 0 AND start_date >= CURDATE()");

        //filter data by searched keywords
        if(!empty($params['search']['keywords'])){
            $this->db->like('event_name',$params['search']['keywords']);
        }
        //sort data by ascending or desceding order
        if(!empty($params['search']['sortBy'])){
            $this->db->order_by('event_name',$params['search']['sortBy']);
        }else{
            $this->db->order_by('id_kegiatan','desc');
        }
        //set start and limit
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        //get records
        $query = $this->db->get();
        //$query = $this->db->query($sql);
        //return fetched data
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }

    function getListStatusPinjam()
    {
        $sql = "SELECT *, start_date, end_date, DAY(start_date) as tgl, MONTH(start_date) as bulan, YEAR(start_date) as tahun, nm_ruang 
                FROM kegiatan a, waktu b, ruang_rapat c 
                WHERE a.nomor = b.nomor AND b.ruang = kd_ruang AND flag_ppaa = 0 AND start_date >= CURDATE()
                ORDER BY id_kegiatan DESC, YEAR(start_date) DESC, MONTH(start_date) DESC";
        $result = mysql_query($sql) or die(mysql_error());
        $data = array();
        while($rows = mysql_fetch_object($result)){
            $data[$rows->id_kegiatan][$rows->nomor][$rows->event_name][$rows->prodi][$rows->status][$rows->no_surat][$rows->start_date][$rows->end_date][] = $rows;
        }
        return $data;
    }

    function getRowsTest($params = array()){

        /*$sql = "SELECT *, DAY(start_date) as tgl, MONTH(start_date) as bulan, YEAR(start_date) as tahun, nm_ruang 
                FROM kegiatan a, waktu b, ruang_rapat c 
                WHERE a.nomor = b.nomor AND b.ruang = kd_ruang AND flag_ppaa = 0 AND start_date >= CURDATE()
                ORDER BY id_kegiatan DESC, YEAR(start_date) DESC, MONTH(start_date) DESC";*/

        /*$this->db->select("id_kegiatan, event_name, prodi, no_surat, status, a.nomor as nomor");
        $this->db->from("kegiatan a, waktu b, ruang_rapat c");
        $this->db->where("a.nomor = b.nomor AND b.ruang = kd_ruang AND flag_ppaa = 0 AND start_date >= CURDATE()");
        $this->db->group_by('id_kegiatan');
        $this->db->order_by('id_kegiatan','desc');*/

        $this->db->select("id_kegiatan, event_name, prodi, no_surat, status, nomor");
        $this->db->from("view_kegiatan");

        //filter data by searched keywords
        if(!empty($params['search']['keywords'])){
            $this->db->like('event_name',$params['search']['keywords']);
        }
        //sort data by ascending or desceding order
        if(!empty($params['search']['sortBy'])){
            $this->db->order_by('event_name',$params['search']['sortBy']);
        }else{
            $this->db->order_by('id_kegiatan','desc');
        }
        //set start and limit
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        //get records
        $query = $this->db->get();
        //$query = $this->db->query($sql);
        //return fetched data
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }

    function getJadwal()
    {
        $sql = "SELECT id_kegiatan, a.nomor as nomor, start_date, end_date, DAY(start_date) as tgl, MONTH(start_date) as bulan, YEAR(start_date) as tahun, nm_ruang 
                FROM kegiatan a, waktu b, ruang_rapat c 
                WHERE a.nomor = b.nomor AND b.ruang = kd_ruang AND flag_ppaa = 0 AND start_date >= CURDATE()
                ORDER BY id_kegiatan DESC, YEAR(start_date) DESC, MONTH(start_date) DESC";
        $query = $this->db->query($sql);
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }
}