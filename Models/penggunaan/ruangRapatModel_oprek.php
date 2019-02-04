<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!session_id()) session_start();

class RuangRapatModel extends CI_Model 
{
    function __construct()
    {
        parent::__construct();	
    }

    function getKegiatanID()
    {
        $this->db->select('COUNT(id_kegiatan) + 521 as nomor');
        $this->db->from('kegiatan');
        $data = $this->db->get()->result();
        foreach ($data as $k => $v) {
            $nomor = $v->nomor;
        }
        return $nomor;
    }

    function getNomor()
    {
        $this->db->select('MAX(nomor) + 1 as nomor');
        $this->db->from('kegiatan');
        $data = $this->db->get()->result();
        foreach ($data as $k => $v) {
            $nomor = $v->nomor;
        }
        return $nomor;
    }

    function cekNomor($nomor){
        //search nomor terdaftar di database kegiatan
        $this->db->select('nomor');
        $this->db->from('kegiatan');
        $this->db->where("nomor = $nomor");
        $data = $this->db->get->result();
        
        //set nomor
        if (count($data) > 0) {
            $nomor = $this->getNomor();
        }
        return $nomor;
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
    
    function getRuangUser()
    {
		$sql = "SELECT * FROM (SELECT * FROM ruang_rapat WHERE kd_ruang < 200 AND nm_ruang <> '' AND kd_ruang <> 11) as a 
				UNION ALL
				SELECT * FROM (SELECT * FROM ruang_rapat WHERE kd_ruang >= 200  AND nm_ruang <> '' order by nm_ruang) as b";
		$result = mysql_query($sql) or die(mysql_error());
        $data = array();
		while($rows = mysql_fetch_object($result)){
            $data[] = $rows;
		}
		return $data;
    }

    function getKegiatan($nomor)
    {
        $this->db->select('*');
        $this->db->from('kegiatan');
        $this->db->where("nomor = '$nomor'");
        $data = $this->db->get()->result();
        return $data;
    }

    function getJadwalRuang($nomor)
    {
    	$sql = "SELECT GROUP_CONCAT(nm_ruang SEPARATOR ', ') as ruangan, start_date, end_date, b.kd_ruang as kd_ruang, event_id
				FROM waktu a, ruang_rapat b
				WHERE ruang = kd_ruang AND nomor = '$nomor' 
				GROUP BY start_date
				ORDER BY start_date, kd_ruang";
        $result = mysql_query($sql);
		while($rows = mysql_fetch_object($result)){
            $data[] = $rows;
		}
		return $data;
    }

    function listKegiatan($kd_ruang){
        //fungsi untuk menampilkan data pengajuan list

        $sql = "SELECT *, DAY(start_date) as tgl, MONTH(start_date) as bulan, YEAR(start_date) as tahun, nm_ruang
                FROM kegiatan a, waktu b, ruang_rapat c
                WHERE a.nomor = b.nomor AND b.ruang = kd_ruang AND b.ruang = $kd_ruang
                ORDER BY a.nomor DESC";
        $result = mysql_query($sql);
        while ($row = mysql_fetch_object($result)) {
            $data[$row->nomor][$row->event_name][$row->prodi][$row->status][] = $row;
        }
        return $data;
    }

    function getData($hak_akses, $userlogin){
        //fungsi untuk menampilkan data pengajuan list
        //$userlogin = 'puskapa05';
        if($hak_akses==1){
	        $sql = "SELECT *, DAY(start_date) as tgl, MONTH(start_date) as bulan, YEAR(start_date) as tahun, nm_ruang 
	                FROM kegiatan a, waktu b, ruang_rapat c 
	                WHERE b.ruang = kd_ruang AND a.nomor = b.nomor AND flag_ppaa = 0 AND start_date>= CURDATE() 
	                ORDER BY a.id_kegiatan DESC, YEAR(start_date) DESC, MONTH(start_date) DESC, DAY (start_date) ASC";
         } else {
         	$sql = "SELECT *, DAY(start_date) as tgl, MONTH(start_date) as bulan, YEAR(start_date) as tahun, nm_ruang 
                FROM kegiatan a, waktu b, ruang_rapat c 
                WHERE b.ruang = kd_ruang AND a.nomor = b.nomor AND flag_ppaa = 0 AND username = '$userlogin'
                ORDER BY a.id_kegiatan DESC, YEAR(start_date) DESC, MONTH(start_date) DESC, DAY (start_date) ASC";
         }
        $result = mysql_query($sql);
        $data = array();
        while($rows = mysql_fetch_object($result)){
            $data[$rows->nomor][$rows->event_name][$rows->prodi][$rows->no_surat][] = $rows;
        }
        return $data;
    }

    function editJadwal($id){
        $sql = "SELECT *, DAY(start_date) as tgl, MONTH(start_date) as bulan, YEAR(start_date) as tahun, nm_ruang 
                FROM kegiatan a, waktu b, ruang_rapat c 
                WHERE a.ruang = kd_ruang AND a.nomor = b.nomor AND a.nomor = '$id'
                ORDER BY YEAR(start_date) DESC, MONTH(start_date) DESC";
        $result = mysql_query($sql);
        $data = array();
        while($rows = mysql_fetch_object($result)){
            $data[$rows->nomor][$rows->event_name][$rows->details][$rows->no_surat][$rows->id_peminjam][$rows->nama_peminjam][$rows->prodi][$rows->no_telp][$rows->email][$rows->catatan][$rows->jml_peserta][$rows->tgl_proses][$rows->id_kegiatan][$rows->tgl_permohonan][] = $rows;
        }
        return $data;
    }

    function insertKegiatan($data){
        $this->db->insert('kegiatan', $data);
    }

    function insertKegiatanMhs($nomor, $data_kegiatan, $data_entitas, $data_kategori, $data_jenis, $data_peserta){
        //simpan data kegiatan
        $this->db->insert('kegiatan', $data_kegiatan);

        //simpan data entitas kegiatan
        foreach ($data_entitas as $key => $value) {
            $data = array(
                'nomor' => $nomor,
                'entitas' => $value
            );

            $this->db->insert('kegiatan_entitas', $data);
        }

        //simpan data kategori kegiatan
        foreach ($data_kategori as $key => $value) {
            $data = array(
                'nomor' => $nomor,
                'kategori' => $value
            );

            $this->db->insert('kegiatan_kategori', $data);
        }

        //simpan data jenis kegiatan
        foreach ($data_jenis as $key => $value) {
            $data = array(
                'nomor' => $nomor,
                'jenis' => $value
            );

            $this->db->insert('kegiatan_jenis', $data);
        }

        //simpan data peserta
        foreach ($data_peserta as $key => $value) {
            $data = array(
                'nomor' => $nomor,
                'peserta' => $value
            );

            $this->db->insert('kegiatan_peserta', $data);
        }
    }

    function insertJadwal($data){
        //$this->db->insert('waktu', $data);
        echo '<pre>'; print_r($data); echo '</pre>';
    }

    function editKegiatan($data, $id_kegiatan){
        $this->db->where('id_kegiatan', $id_kegiatan);
        $this->db->update('kegiatan', $data);     
    }

    function disableCrud($data, $nomor){
        $this->db->where('nomor', $nomor);
        $this->db->update('kegiatan', $data);     
    }
	
	function delKegiatan($nomor){
		$this->db->where('nomor', $nomor);
		$this->db->delete('kegiatan');
		$this->db->where('nomor', $nomor);
		$this->db->delete('waktu');
	}
	
    function editWaktu($data, $event_id){
        $this->db->where('event_id', $event_id);
        $this->db->update('waktu', $data);       
    }

    function delWaktu($event_id){
        $this->db->where('event_id', $event_id);
        $this->db->delete('waktu');
    }

    function viewFormPengajuanPdf($nomor){       
        $this->db->select('*, DAY(start_date) as tgl, MONTH(start_date) as bulan, YEAR(start_date) as tahun, nm_ruang');
        $this->db->from('kegiatan a, waktu b, ruang_rapat c');
        $this->db->where("ruang = kd_ruang AND a.nomor = b.nomor AND a.nomor = $nomor");
        $query = $this->db->get();
        $data = $query->result();
        return $data;
    }

    function namaRuangRapat($ruang){
        $this->db->select('nm_ruang');
        $this->db->from('ruang_rapat');
        $this->db->where("kd_ruang = $ruang"); 
        $data = $this->db->get()->result();
        return $data;
    }
	
    function jadwalBentrok($event_id, $start_date, $end_date, $ruang)   //event_id supaya tidak memeriksa dirinya sendiri
    {
        $data = array();
        $sql = "
            SELECT *, DAY(start_date) as tgl, MONTH(start_date) as bulan, YEAR(start_date) as tahun , a.nomor as nomor
            FROM kegiatan a, waktu b, ruang_rapat c 
            WHERE   (
                        (
                            DATE(start_date) BETWEEN  DATE('$start_date') AND DATE('$end_date') OR
                            DATE(end_date) BETWEEN  DATE('$start_date') AND DATE('$end_date')
                        )
                        AND 
                        (
							TIME(start_date) BETWEEN  TIME('$start_date') AND TIME('$end_date') 
							OR
							TIME(end_date) BETWEEN  TIME('$start_date') AND TIME('$end_date') 
							OR
							TIME('$start_date') BETWEEN TIME(start_date) AND TIME(end_date)
							OR
							TIME('$end_date') BETWEEN TIME(start_date) AND TIME(end_date)
                        )
                    ) 
                    AND b.ruang = kd_ruang AND a.nomor = b.nomor AND event_id <> '$event_id' AND b.ruang = '$ruang'
                    AND (b.nomor LIKE 'ppf%'  OR b.nomor LIKE 'ppaa%')
            UNION        
            SELECT *, DAY(start_date) as tgl, MONTH(start_date) as bulan, YEAR(start_date) as tahun , a.nomor as nomor
            FROM kegiatan a, waktu b, ruang_rapat c  
            WHERE b.nomor LIKE 'siak%' AND
            b.ruang = kd_ruang AND a.nomor = b.nomor AND 
            b.ruang = '$ruang' AND 
            DAYNAME(start_date) = DAYNAME('$start_date') AND 
            (b.nomor LIKE 'siak%' OR b.nomor LIKE 'blok%') AND
            (
                ( TIME('$start_date') <= TIME(start_date) AND TIME('$end_date') >= TIME(start_date) ) OR
                ( TIME('$start_date') >= TIME(start_date) AND TIME('$end_date') <= TIME(end_date) ) OR 
                ( TIME('$start_date') <= TIME(end_date) AND TIME('$end_date') >= TIME(end_date) ) OR 
                ( TIME('$start_date') <= TIME(start_date) AND TIME('$end_date') >= TIME(end_date) ) 
            )
            ";
        $result = mysql_query($sql) OR die(mysql_error());
        while ($rows = mysql_fetch_object($result)) {
            $data[] = $rows;
        }
        return $data;    
    }

    function cekJadwalBentrok($start_date, $end_date, $ruang)  //cek jadwal bentrok pada saat add row jadwal
    {
        $data = array();

        $sql = "
            SELECT *, DAY(start_date) as tgl, MONTH(start_date) as bulan, YEAR(start_date) as tahun , a.nomor as nomor
            FROM kegiatan a, waktu b, ruang_rapat c 
            WHERE  	DATE(start_date) BETWEEN DATE('$start_date') AND DATE('$end_date') AND
					( 
						TIME(start_date) BETWEEN  TIME('$start_date') AND TIME('$end_date') 
						OR
						TIME(end_date) BETWEEN  TIME('$start_date') AND TIME('$end_date') 
						OR
						TIME('$start_date') BETWEEN TIME(start_date) AND TIME(end_date)
						OR
						TIME('$end_date') BETWEEN TIME(start_date) AND TIME(end_date)
					) AND 
                    b.ruang = kd_ruang AND a.nomor = b.nomor AND b.ruang = '$ruang' AND 
                    (b.nomor LIKE 'ppf%'  OR b.nomor LIKE 'ppaa%' OR b.nomor LIKE 'blok%')
            UNION        
            SELECT *, DAY(start_date) as tgl, MONTH(start_date) as bulan, YEAR(start_date) as tahun , a.nomor as nomor
            FROM kegiatan a, waktu b, ruang_rapat c  
            WHERE b.nomor LIKE 'siak%' AND
            b.ruang = kd_ruang AND a.nomor = b.nomor AND 
            b.ruang = '$ruang' AND 
            DAYNAME(start_date) = DAYNAME('$start_date') AND 
            (b.nomor LIKE 'siak%' OR b.nomor LIKE 'blok%') AND
            (
                ( TIME('$start_date') <= TIME(start_date) AND TIME('$end_date') >= TIME(start_date) ) OR
                ( TIME('$start_date') >= TIME(start_date) AND TIME('$end_date') <= TIME(end_date) ) OR 
                ( TIME('$start_date') <= TIME(end_date) AND TIME('$end_date') >= TIME(end_date) ) OR 
                ( TIME('$start_date') <= TIME(start_date) AND TIME('$end_date') >= TIME(end_date) ) 
            )
            ";
        $result = mysql_query($sql) OR die(mysql_error());
        while ($rows = mysql_fetch_object($result)) {
            $data[] = $rows;
        }
        return $data;  
    }
	
    function getListStatusPinjam()
    {
        $sql = "SELECT *, DAY(start_date) as tgl, MONTH(start_date) as bulan, YEAR(start_date) as tahun, nm_ruang 
                FROM kegiatan a, waktu b, ruang_rapat c 
                WHERE a.nomor = b.nomor AND b.ruang = kd_ruang AND flag_ppaa = 0 AND start_date >= CURDATE()
                ORDER BY id_kegiatan DESC, YEAR(start_date) DESC, MONTH(start_date) DESC";
        $result = mysql_query($sql) or die(mysql_error());
        $data = array();
        while($rows = mysql_fetch_object($result)){
            $data[$rows->id_kegiatan][$rows->nomor][$rows->event_name][$rows->prodi][$rows->status][$rows->no_surat][] = $rows;
        }
        return $data;
    }

    function getDataUser($username){
        $this->db->select('*');
        $this->db->from('user_login');
        $this->db->where("user_name = '$username'");
        $data = $this->db->get()->result();
        return $data;
    }

    function addDataUser($data){
        $this->db->insert('user_login', $data);        
    }

    function editDataUser($data, $username){
        $this->db->where('user_name', $username);
        $this->db->update('user_login', $data);     
    }
    
    function getDataUjian($nomor=''){
        if ($nomor=='') {
            $kondisi = "a.nomor=b.nomor AND b.ruang=kd_ruang AND flag=1 AND flag_ppaa = 1 AND a.nomor LIKE 'ujian%'";
        } else {
            $kondisi = "a.nomor=b.nomor AND b.ruang=kd_ruang AND flag=1 AND flag_ppaa = 1 AND a.nomor = '$nomor'";
        }   
        $data = array();
        $sql = "SELECT a.*, event_id as id, start_date, end_date, 
                        TIMESTAMPDIFF(minute, start_date, end_date) as lama, 
                        CONCAT(event_name, ' ', prodi, ' ', jml_peserta) as html, b.ruang as ruang, kd_ruang, nm_ruang,
                        (CASE
                            WHEN DAYNAME(start_date) = 'Sunday' THEN 'Minggu'
                            WHEN DAYNAME(start_date) = 'Monday' THEN 'Senin'
                            WHEN DAYNAME(start_date) = 'Tuesday' THEN 'Selasa'
                            WHEN DAYNAME(start_date) = 'Wednesday' THEN 'Rabu'
                            WHEN DAYNAME(start_date) = 'Thursday' THEN 'Kamis'
                            WHEN DAYNAME(start_date) = 'Friday' THEN 'Jumat'
                            WHEN DAYNAME(start_date) = 'Saturday' THEN 'Sabtu'
                        END) as hari,
                        (CASE
                            WHEN DAYNAME(tgl_permohonan) = 'Sunday' THEN 'Minggu'
                            WHEN DAYNAME(tgl_permohonan) = 'Monday' THEN 'Senin'
                            WHEN DAYNAME(tgl_permohonan) = 'Tuesday' THEN 'Selasa'
                            WHEN DAYNAME(tgl_permohonan) = 'Wednesday' THEN 'Rabu'
                            WHEN DAYNAME(tgl_permohonan) = 'Thursday' THEN 'Kamis'
                            WHEN DAYNAME(tgl_permohonan) = 'Friday' THEN 'Jumat'
                            WHEN DAYNAME(tgl_permohonan) = 'Saturday' THEN 'Sabtu'
                        END) as hari_permohonan,
                        DAY(tgl_permohonan) as day_permohonan, MONTH(tgl_permohonan) as bulan_permohonan, YEAR(tgl_permohonan) as tahun_permohonan,
                        DAY(start_date) as tgl, MONTH(start_date) as bulan, YEAR(start_date) as tahun, DATE(start_date) as tgl_kegiatan, nama_peminjam, no_telp, email,
                        TIME_FORMAT(start_date, '%h:%i') as start_time, TIME_FORMAT(end_date, '%h:%i') as end_time,
                        TIME_FORMAT(start_date, '%h') as jam_mulai, TIME_FORMAT(start_date, '%i') as menit_mulai,
                        TIME_FORMAT(end_date, '%h') as jam_selesai, TIME_FORMAT(end_date, '%i') as menit_selesai
                FROM kegiatan a, waktu b, ruang_rapat c
                WHERE $kondisi
                ORDER BY tgl_kegiatan desc";

        $query = $this->db->query($sql);
		return $query->result();
    }

    function edit_dokumen($nomor, $data){
        $this->db->where('nomor', $nomor);
        $this->db->update('kegiatan', $data); 
        echo 'data sudah disimpan!';
    }
}
