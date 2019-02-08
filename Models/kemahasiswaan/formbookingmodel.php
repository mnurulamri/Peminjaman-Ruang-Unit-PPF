<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!session_id()) session_start();

class FormBookingModel extends CI_Model 
{
    function __construct()
    {
        parent::__construct();	
    }

    function getDataKegiatan($nomor)
    {
        $sql = "SELECT * FROM kegiatan WHERE nomor = '$nomor'";
        $query = $this->db->query($sql);
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }

    function getDataKegiatanEntitas($nomor)
    {
        $sql = "SELECT * FROM kegiatan_entitas WHERE nomor = '$nomor'";
        $query = $this->db->query($sql);
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }

    function getDataKegiatanJenis($nomor)
    {
        $sql = "SELECT * FROM kegiatan_jenis WHERE nomor = '$nomor'";
        $query = $this->db->query($sql);
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }

    function getDataKegiatanKategori($nomor)
    {
        $sql = "SELECT * FROM kegiatan_kategori WHERE nomor = '$nomor'";
        $query = $this->db->query($sql);
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }

    function getDataKegiatanPeserta($nomor)
    {
        $sql = "SELECT * FROM kegiatan_peserta WHERE nomor = '$nomor'";
        $query = $this->db->query($sql);
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }

    function getDataJadwal($nomor)
    {
        $sql = "SELECT start_date, end_date, DAY(start_date) as tgl, MONTH(start_date) as bulan, YEAR(start_date) as tahun, nm_ruang 
            FROM waktu b, ruang_rapat c 
            WHERE b.ruang = kd_ruang AND nomor = '$nomor'
            ORDER BY YEAR(start_date) DESC, MONTH(start_date) DESC";
        $query = $this->db->query($sql);
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }
}
