<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!session_id()) session_start();

class SchedulerRuangRapatModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function getRuangRapat()
    {
        $sql = "SELECT * FROM ruang_rapat";
        $result = mysql_query($sql);
        $data = array();
        while($rows = mysql_fetch_object($result)){
            //$data[] = '<option value="'.$rows->kd_ruang.'">'.$rows->nm_ruang.'</option>';
            $data[] = $rows;
        }
        return $data;
    }

    function getSchedulerRuangRapat($ruang)
    {
        $sql = "SELECT a.*, nm_ruang, c.* 
                FROM kegiatan a, ruang_rapat b, waktu c 
                WHERE ruang = kd_ruang AND a.nomor = c.nomor
                ORDER BY ruang, start_date";
        //$result = $this->db->query($sql);
                
        $result = mysql_query($sql) or die(mysql_error());
        while($row = mysql_fetch_assoc($result)){
            $_data[$row['id']][] = $row;
        }
        return $_data;
    }

    function insertSchedulerRuangRapat($data){
        $this->db->insert('jadwal_rapat', $data);
        //print_r($data);
    }

    function updateSchedulerRuangRapat($event_id, $data){
        $this->db->where('event_id', $event_id);
        $this->db->update('jadwal_rapat', $data);
        //print_r($data);
    }

    function deleteSchedulerRuangRapat($event_id){
        $this->db->where('event_id', $event_id);
        $this->db->delete('jadwal_rapat');
    }
}
