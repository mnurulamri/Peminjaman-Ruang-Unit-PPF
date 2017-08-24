<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	dhtmlxScheduler, without Model
*/

require_once("./assets/dhtmlx/dhtmlxScheduler/codebase/connector/scheduler_connector.php");
require_once("./assets/dhtmlx/dhtmlxScheduler/codebase/connector/db_phpci.php");
DataProcessor::$action_param ="dhx_editor_status";


class schedulerRuangRapat extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		//$this->load->model('backend/pegawaimodel');
		//$this->load->library('servicefisip');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function beforeRender($action){
		//formatting data before output
		if ($action->get_id() == 10) 
			$action->set_userdata("color", "pink"); //mark event
	}
	public function beforeProcessing($action){
		//validation before saving
		if ($action->get_value("event_name") == ""){
			$action->invalid();
			$action->set_response_attribute("details", "Empty data not allowed");
		}
	}
	public function index()
	{
		//scheduler's view
		$this->load->model('peminjaman/schedulerRuangRapatModel');
		//$data['ruang'] = $this->schedulerRuangRapatModel->getRuangRapat();
		$data['template_1'] = $this->load->view('layout/template-1', NULL, TRUE);
		$data['template_2'] = $this->load->view('layout/template-2', NULL, TRUE);
		$this->load->view('peminjaman/schedulerRuangRapatView', $data);
	}

	public function ruang()
	{
		//scheduler's view
		$this->load->model('peminjaman/schedulerRuangRapatModel');
		$data['ruang'] = (int) $this->uri->segment(4);

		$sql = "SELECT nm_ruang FROM ruang_rapat WHERE kd_ruang = ".$this->uri->segment(4);
		$result = mysql_query($sql) or die(mysql_error());
		while($row = mysql_fetch_assoc($result)){
			$nama_ruang = $row;
		}

		$data['nama_ruang'] = $nama_ruang['nm_ruang'];
		$data['template_1'] = $this->load->view('layout/template-1', NULL, TRUE);
		$data['template_2'] = $this->load->view('layout/template-2', NULL, TRUE);
		$this->load->view('peminjaman/schedulerRuangRapatView', $data);
	}

	public function data()
	{
		error_reporting(E_ALL ^ E_NOTICE);
		//include("conn.php");
		header("Content-type:text/xml, charset=utf-8");

		//if(!session_id()) session_start();
		//if(empty($username)){header('location:login.php');} 
		//$thsmt = $_SESSION['thsmt'] = 20142;
		//$jenis_ujian = $_SESSION['jenis_ujian'] = 'UAS';
		
		$ruang = (int) $this->uri->segment(4);
		//$_data = $this->schedulerRuangRapatModel->getSchedulerRuangRapat($ruang);

		$sql = "SELECT *, nm_ruang 
				FROM kegiatan a, waktu b, ruang_rapat c 
				WHERE b.ruang = kd_ruang AND a.nomor = b.nomor AND b.ruang = $ruang
				ORDER BY b.ruang, start_date";

		$result = mysql_query($sql) or die(mysql_error());
		while($row = mysql_fetch_assoc($result)){
			$_data[$row['id']][] = $row;
		}

		$xml = "<data>";

		foreach ($_data as $keys => $values) {
			//echo $keys.'<br>';
			$id = $keys;
			foreach ($values as $k => $v) {
				$event_id = $v['event_id'];
				$jml_peserta = $v['jml_peserta'];
				$event_name = $v['event_name'].'<br>('.$v['prodi'].')';
				$start_date = $v['start_date'];
				$end_date = $v['end_date'];
				$tgl_proses = $v['tgl_proses'];
				$tgl_permohonan = $v['tgl_permohonan'];
				$nama_peminjam = $v['nama_peminjam'];								
				$prodi = $v['prodi'];
				$no_telp = $v['no_telp'];	
				$email = $v['email'];
				$nomor = $v['nomor'];			
				$flag = $v['flag'];
				$level = $v['status'];
				$ruang = $v['kd_ruang']; 

				//rubah format tanggal
				//$_tgl = date_create($tanggal);
				//$tgl_kegiatan = date_format($_tgl,"Y/m/d");
				$start_date = str_replace('-', '/', $start_date);
				$end_date = str_replace('-', '/', $end_date);

				$xml .= "<event>";
				$xml .= "<event_id><![CDATA[".$event_id."]]></event_id>";
				$xml .= "<jml_peserta><![CDATA[".$jml_peserta."]]></jml_peserta>";
				$xml .= "<start_date><![CDATA[".$start_date."]]></start_date>";
				$xml .= "<end_date><![CDATA[".$end_date."]]></end_date>";
				$xml .= "<text><![CDATA[".$event_name."]]></text>";
				$xml .= "<tgl_proses><![CDATA[".$tgl_proses."]]></tgl_proses>";
				$xml .= "<tgl_permohonan><![CDATA[".$tgl_permohonan."]]></tgl_permohonan>";
				$xml .= "<nama_peminjam><![CDATA[".$nama_peminjam."]]></nama_peminjam>";
				$xml .= "<prodi><![CDATA[".$prodi."]]></prodi>";				
				$xml .= "<no_telp><![CDATA[".$no_telp."]]></no_telp>";
				$xml .= "<email><![CDATA[".$email."]]></email>";
				$xml .= "<nomor><![CDATA[".$nomor."]]></nomor>";
				$xml .= "<flag><![CDATA[".$flag."]]></flag>";
				$xml .= "<level><![CDATA[".$level."]]></level>";
				$xml .= "<ruang>".$ruang."</ruang>";
				$xml .= "</event>";
			}
		}

		$xml .= "</data>";
		print $xml;
	}

	public function dataUnitView()
	{
		error_reporting(E_ALL ^ E_NOTICE);
		header("Content-type:text/xml, charset=utf-8");

		$sql = "SELECT *, nm_ruang 
				FROM kegiatan a, waktu b, ruang_rapat c 
				WHERE b.ruang = kd_ruang AND a.nomor = b.nomor AND kd_ruang > 200
				ORDER BY b.ruang, start_date";

		$result = mysql_query($sql) or die(mysql_error());
		while($row = mysql_fetch_assoc($result)){
			$_data[$row['id']][] = $row;
		}

		$xml = "<data>";

		foreach ($_data as $keys => $values) {
			//echo $keys.'<br>';
			$id = $keys;
			foreach ($values as $k => $v) {
				$event_id = $v['event_id'];
				$jml_peserta = $v['jml_peserta'];
				$event_name = $v['event_name'].'<br>('.$v['prodi'].')';
				$start_date = $v['start_date'];
				$end_date = $v['end_date'];
				$tgl_proses = $v['tgl_proses'];
				$tgl_permohonan = $v['tgl_permohonan'];
				$nama_peminjam = $v['nama_peminjam'];								
				$prodi = $v['prodi'];
				$no_telp = $v['no_telp'];	
				$email = $v['email'];
				$nomor = $v['nomor'];			
				$flag = $v['flag'];
				$level = $v['status'];
				$ruang = $v['nm_ruang']; 

				//rubah format tanggal
				//$_tgl = date_create($tanggal);
				//$tgl_kegiatan = date_format($_tgl,"Y/m/d");
				$start_date = str_replace('-', '/', $start_date);
				$end_date = str_replace('-', '/', $end_date);

				$xml .= "<event>";
				$xml .= "<event_id><![CDATA[".$event_id."]]></event_id>";
				$xml .= "<jml_peserta><![CDATA[".$jml_peserta."]]></jml_peserta>";
				$xml .= "<start_date><![CDATA[".$start_date."]]></start_date>";
				$xml .= "<end_date><![CDATA[".$end_date."]]></end_date>";
				$xml .= "<text><![CDATA[".$event_name."]]></text>";
				$xml .= "<tgl_proses><![CDATA[".$tgl_proses."]]></tgl_proses>";
				$xml .= "<tgl_permohonan><![CDATA[".$tgl_permohonan."]]></tgl_permohonan>";
				$xml .= "<nama_peminjam><![CDATA[".$nama_peminjam."]]></nama_peminjam>";
				$xml .= "<prodi><![CDATA[".$prodi."]]></prodi>";				
				$xml .= "<no_telp><![CDATA[".$no_telp."]]></no_telp>";
				$xml .= "<email><![CDATA[".$email."]]></email>";
				$xml .= "<nomor><![CDATA[".$nomor."]]></nomor>";
				$xml .= "<flag><![CDATA[".$flag."]]></flag>";
				$xml .= "<level><![CDATA[".$level."]]></level>";
				$xml .= "<ruang>".$ruang."</ruang>";
				$xml .= "<section_id>".$ruang."</section_id>";
				$xml .= "</event>";
			}
		}

		$xml .= "</data>";
		print $xml;
	}
	

	public function dataUnitPPAAView()
	{
		error_reporting(E_ALL ^ E_NOTICE);
		header("Content-type:text/xml, charset=utf-8");

		$sql = "SELECT *, nm_ruang 
				FROM kegiatan a, waktu b, ruang_rapat c 
				WHERE b.ruang = kd_ruang AND a.nomor = b.nomor AND kd_ruang in (208, 210)
				ORDER BY b.ruang, start_date";

		$result = mysql_query($sql) or die(mysql_error());
		while($row = mysql_fetch_assoc($result)){
			$_data[$row['id']][] = $row;
		}

		$xml = "<data>";

		foreach ($_data as $keys => $values) {
			//echo $keys.'<br>';
			$id = $keys;
			foreach ($values as $k => $v) {
				$event_id = $v['event_id'];
				$jml_peserta = $v['jml_peserta'];
				$event_name = $v['event_name'].'<br>('.$v['prodi'].')';
				$start_date = $v['start_date'];
				$end_date = $v['end_date'];
				$tgl_proses = $v['tgl_proses'];
				$tgl_permohonan = $v['tgl_permohonan'];
				$nama_peminjam = $v['nama_peminjam'];								
				$prodi = $v['prodi'];
				$no_telp = $v['no_telp'];	
				$email = $v['email'];
				$nomor = $v['nomor'];			
				$flag = $v['flag'];
				$level = $v['status'];
				$ruang = $v['nm_ruang']; 

				//rubah format tanggal
				//$_tgl = date_create($tanggal);
				//$tgl_kegiatan = date_format($_tgl,"Y/m/d");
				$start_date = str_replace('-', '/', $start_date);
				$end_date = str_replace('-', '/', $end_date);

				$xml .= "<event>";
				$xml .= "<event_id><![CDATA[".$event_id."]]></event_id>";
				$xml .= "<jml_peserta><![CDATA[".$jml_peserta."]]></jml_peserta>";
				$xml .= "<start_date><![CDATA[".$start_date."]]></start_date>";
				$xml .= "<end_date><![CDATA[".$end_date."]]></end_date>";
				$xml .= "<text><![CDATA[".$event_name."]]></text>";
				$xml .= "<tgl_proses><![CDATA[".$tgl_proses."]]></tgl_proses>";
				$xml .= "<tgl_permohonan><![CDATA[".$tgl_permohonan."]]></tgl_permohonan>";
				$xml .= "<nama_peminjam><![CDATA[".$nama_peminjam."]]></nama_peminjam>";
				$xml .= "<prodi><![CDATA[".$prodi."]]></prodi>";				
				$xml .= "<no_telp><![CDATA[".$no_telp."]]></no_telp>";
				$xml .= "<email><![CDATA[".$email."]]></email>";
				$xml .= "<nomor><![CDATA[".$nomor."]]></nomor>";
				$xml .= "<flag><![CDATA[".$flag."]]></flag>";
				$xml .= "<level><![CDATA[".$level."]]></level>";
				$xml .= "<ruang>".$ruang."</ruang>";
				$xml .= "<section_id>".$ruang."</section_id>";
				$xml .= "</event>";
			}
		}
		$xml.= "</data>";
		print $xml;
	}
	
}
