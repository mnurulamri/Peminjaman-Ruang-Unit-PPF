<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
    dhtmlxScheduler, without Model
*/

require_once("./assets/dhtmlx/dhtmlxScheduler/codebase/connector/scheduler_connector.php");
require_once("./assets/dhtmlx/dhtmlxScheduler/codebase/connector/db_phpci.php");
DataProcessor::$action_param ="dhx_editor_status";


class schedulerRuangKelas extends CI_Controller {
    public function __construct() {
		parent::__construct();
		$this->load->database();
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
		$this->load->model('peminjaman/formPeminjamanModel');
		$data['ruang'] = $this->formPeminjamanModel->getRuang();
		$data['template_1'] = $this->load->view('layout/template-1', NULL, TRUE);
		$data['template_2'] = $this->load->view('layout/template-2', NULL, TRUE);
		$this->load->view('peminjaman/schedulerRuangKelasView', $data);

		/* yang lama
		$data['menu'] = $this->load->view('themes/menu', NULL, TRUE);
		$data['head'] = $this->load->view('themes/layout-1', NULL, TRUE);
		$data['header'] = $this->load->view('themes/layout-header', NULL, TRUE);
		$data['sidebar'] = $this->load->view('themes/layout-sidebar', NULL, TRUE);
		$data['content'] = $this->load->view('themes/layout-content', NULL, TRUE);
		//scheduler's view
		//$this->load->view('themes/layout-content-ruang_jadwal', $data);
		$this->load->view('peminjaman/ruang_jadwal', $data);
		*/
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

		$sql = "SELECT *, nm_ruang
				FROM kegiatan a, waktu b, ruang c
				WHERE b.ruang = kd_ruang AND a.nomor = b.nomor AND flag = 0 AND b.ruang <> 'x'
				ORDER BY b.ruang, start_date";

		$result = mysql_query($sql) or die(mysql_error());
		while($row = mysql_fetch_assoc($result)){
			$_data[$row['event_id']][] = $row;
		}

		/*	set tanggal, jika jenisnya adalah mata kuliah maka set tanggal pada saat awal kuliah dan akhir kuliah */
		$date1 = "20-02-2017";
		$date2 = "12-05-2017";

		$array_hari = array(
				'Senin' => '1',
				'Selasa' => '2',
				'Rabu' => '3',
				'Kamis' => '4',
				'Jumat' => '5',
				'Sabtu' => '6'
			);

		$xml = "<data>";

		foreach ($_data as $keys => $values) {
			//echo $keys.'<br>';
			$id = $keys;
			foreach ($values as $k => $v) {
				$event_id = $v['event_id'];
				//$hari = $v['hari'];
				$kd_hari = $array_hari[$v['hari']]; //tentukan kode hari
				$ruang = $v['nm_ruang'];
				$start_date = $v['start_date'];
				$end_date = $v['end_date'];
				//$start = $v['start'];
				//$lama = $v['lama'];
				$html = $v['event_name'].'<br>('.$v['prodi'].')';
				$prodi = $v['prodi'];
				$id_petugas = $v['id_petugas'];
				$id_peminjam = $v['id_peminjam'];
				$nama_peminjam = $v['nama_peminjam'];
				$no_telp = $v['no_telp'];
				$email = $v['email'];
				$nomor = $v['nomor'];
				$flag = $v['flag'];
				$level = $v['status'];

				$ruang = str_replace('F.F', 'F.', $ruang);
				$ruang = str_replace('E.E', 'E.', $ruang);
				$ruang = str_replace('H.H', 'H.', $ruang);
				$ruang = str_replace('G.G', 'G.', $ruang);
				$ruang = str_replace('G-', 'G.', $ruang);
				$ruang = str_replace('M', 'M.', $ruang);
				$ruang = str_replace('M-', 'M.', $ruang);

				//tanggalnya_hari($isi, $result, $date1, $date2, $hari, $array_hari, $id);
				//tanggalnya_hari($hari, $kd_hari, $ruang, $start, $lama, $html, $date1, $date2, $hari, $array_hari, $id);

				/* menentukan tanggal pada setiap mata kuliah */
				// memecah bagian-bagian dari tanggal $date1
				$pecahTgl1 = explode("-", $date1);

				// membaca bagian-bagian dari $date1
				$tgl1 = $pecahTgl1[0];
				$bln1 = $pecahTgl1[1];
				$thn1 = $pecahTgl1[2];

				$i = 0; // counter looping
				$sum = 0;// counter untuk jumlah hari

				do {
				   // mengenerate tanggal berikutnya
				   $tanggal = date("d-m-Y", mktime(0, 0, 0, $bln1, $tgl1+$i, $thn1));

				   // cek jika harinya mata kuliah, maka counter $sum bertambah satu, lalu tampilkan tanggalnya
				   if (date("w", mktime(0, 0, 0, $bln1, $tgl1+$i, $thn1)) == $kd_hari)  {

				    	$sum++;	//increment untuk jumlah hari

						$start_date = str_replace('-', '/', $start_date);
						$end_date = str_replace('-', '/', $end_date);

						$xml .= "<event>";
						$xml .= "<event_id><![CDATA[".$event_id."]]></event_id>";
						$xml .= "<start_date><![CDATA[".$start_date."]]></start_date>";
						$xml .= "<end_date><![CDATA[".$end_date."]]></end_date>";
						$xml .= "<text><![CDATA[".$html."]]></text>";
						$xml .= "<prodi><![CDATA[".$prodi."]]></prodi>";
						$xml .= "<id_petugas><![CDATA[".$id_petugas."]]></id_petugas>";
						$xml .= "<id_peminjam><![CDATA[".$id_peminjam."]]></id_peminjam>";
						$xml .= "<nama_peminjam><![CDATA[".$nama_peminjam."]]></nama_peminjam>";
						$xml .= "<no_telp><![CDATA[".$no_telp."]]></no_telp>";
						$xml .= "<email><![CDATA[".$email."]]></email>";
						$xml .= "<nomor><![CDATA[".$nomor."]]></nomor>";
						$xml .= "<flag><![CDATA[".$flag."]]></flag>";
						$xml .= "<level><![CDATA[".$level."]]></level>";
						$xml .= "<section_id>".$ruang."</section_id>";
						$xml .= "</event>";

				   }

				   $i++;  //increment untuk counter looping
				}
				// looping di atas akan terus dilakukan selama tanggal yang digenerate tidak sama dengan $date2.
				while ($tanggal != $date2);
			}
		}

		$xml .= $this->data_peminjaman();
		$xml .= "</data>";
		print $xml;
	}

	public function data_peminjaman()
	{
		//error_reporting(E_ALL ^ E_NOTICE);
		//include("conn.php");
		//header("Content-type:text/xml, charset=utf-8");

		//if(!session_id()) session_start();
		//if(empty($username)){header('location:login.php');}
		//$thsmt = $_SESSION['thsmt'] = 20142;
		//$jenis_ujian = $_SESSION['jenis_ujian'] = 'UAS';

		$sql = "SELECT *, nm_ruang
				FROM kegiatan a, waktu b, ruang c
				WHERE b.ruang = kd_ruang AND a.nomor = b.nomor AND flag = 1 AND b.ruang <> 'x'
				ORDER BY b.ruang, start_date";

		$result = mysql_query($sql) or die(mysql_error());
		while($row = mysql_fetch_assoc($result)){
			$_data[$row['event_id']][] = $row;
		}

		$array_hari = array(
				'Senin' => '1',
				'Selasa' => '2',
				'Rabu' => '3',
				'Kamis' => '4',
				'Jumat' => '5',
				'Sabtu' => '6'
			);

		//$xml = "<data>";

		foreach ($_data as $keys => $values) {
			//echo $keys.'<br>';
			$id = $keys;
			foreach ($values as $k => $v) {
				$event_id = $v['event_id'];
				//$hari = $v['hari'];
				//$kd_hari = $array_hari[$v['hari']]; //tentukan kode hari
				$ruang = $v['nm_ruang'];
				$start_date = $v['start_date'];
				$end_date = $v['end_date'];
				//$start = $v['start'];
				//$end = $v['end'];
				$html = $v['event_name'];
				//$tgl_kegiatan = str_replace('-', '/', $v['tgl_kegiatan']);
				$prodi = $v['prodi'];
				$id_petugas = $v['id_petugas'];
				$id_peminjam = $v['id_peminjam'];
				$nama_peminjam = $v['nama_peminjam'];
				$no_telp = $v['no_telp'];
				$email = $v['email'];
				$nomor = $v['nomor'];
				$flag = $v['flag'];
				$level = $v['status'];

				$ruang = str_replace('F.F', 'F.', $ruang);
				$ruang = str_replace('E.E', 'E.', $ruang);
				$ruang = str_replace('H.H', 'H.', $ruang);
				$ruang = str_replace('G.G', 'G.', $ruang);
				$ruang = str_replace('G-', 'G.', $ruang);
				$ruang = str_replace('M', 'M.', $ruang);
				$ruang = str_replace('M-', 'M.', $ruang);

				$start_date = str_replace('-', '/', $start_date);
				$end_date = str_replace('-', '/', $end_date);

				$xml .= "<event>";
				$xml .= "<event_id><![CDATA[".$event_id."]]></event_id>";
				$xml .= "<start_date><![CDATA[".$start_date."]]></start_date>";
				$xml .= "<end_date><![CDATA[".$end_date."]]></end_date>";
				$xml .= "<text><![CDATA[".$html."]]></text>";
				$xml .= "<prodi><![CDATA[".$prodi."]]></prodi>";
				$xml .= "<id_petugas><![CDATA[".$id_petugas."]]></id_petugas>";
				$xml .= "<id_peminjam><![CDATA[".$id_peminjam."]]></id_peminjam>";
				$xml .= "<nama_peminjam><![CDATA[".$nama_peminjam."]]></nama_peminjam>";
				$xml .= "<no_telp><![CDATA[".$no_telp."]]></no_telp>";
				$xml .= "<email><![CDATA[".$email."]]></email>";
				$xml .= "<nomor><![CDATA[".$nomor."]]></nomor>";
				$xml .= "<flag><![CDATA[".$flag."]]></flag>";
				$xml .= "<level><![CDATA[".$level."]]></level>";
				$xml .= "<section_id>".$ruang."</section_id>";
				$xml .= "</event>";
			}
		}
		//$xml .= "</data>";
		//print $xml;
		return $xml;
	}

	public function dataSiak()
	{
		error_reporting(E_ALL ^ E_NOTICE);
		header("Content-type:text/xml, charset=utf-8");

		$sql = "SELECT *, nm_ruang,
				(CASE
					WHEN DAYNAME(start_date) = 'Sunday' THEN 'Minggu'
					WHEN DAYNAME(start_date) = 'Monday' THEN 'Senin'
					WHEN DAYNAME(start_date) = 'Tuesday' THEN 'Selasa'
					WHEN DAYNAME(start_date) = 'Wednesday' THEN 'Rabu'
					WHEN DAYNAME(start_date) = 'Thursday' THEN 'Kamis'
					WHEN DAYNAME(start_date) = 'Friday' THEN 'Jumat'
					WHEN DAYNAME(start_date) = 'Saturday' THEN 'Sabtu'
				END) as hari, TIME(start_date) as start_time, TIME(end_date) as end_time
				FROM kegiatan a, waktu b, ruang c
				WHERE b.ruang = kd_ruang AND a.nomor = b.nomor AND flag = 0 AND b.ruang <> 'x' AND a.nomor like 'siak%'
				ORDER BY b.ruang, start_date";

		$result = mysql_query($sql) or die(mysql_error());
		while($row = mysql_fetch_assoc($result)){
			$_data[$row['event_id']][] = $row;
		}

		/*	set tanggal, jika jenisnya adalah mata kuliah maka set tanggal pada saat awal kuliah dan akhir kuliah */
		$date1 = "28-08-2017";
		$date2 = "29-12-2017";

		$array_hari = array(
			'Senin' => '1',
			'Selasa'=> '2',
			'Rabu' 	=> '3',
			'Kamis' => '4',
			'Jumat' => '5',
			'Sabtu' => '6'
		);

		$xml = "<data>";

		foreach ($_data as $keys => $values) {
			//echo $keys.'<br>';
			$id = $keys;
			foreach ($values as $k => $v) {
				$event_id = $v['event_id'];
				//$hari = $v['hari'];
				$kd_hari = $array_hari[$v['hari']]; //tentukan kode hari
				$ruang = $v['nm_ruang'];
				$start_date = $v['start_date'];
				$end_date = $v['end_date'];
				//$start = $v['start'];
				//$lama = $v['lama'];
				$html = $v['event_name'];
				$prodi = $v['prodi'];
				$id_petugas = $v['id_petugas'];
				$id_peminjam = $v['id_peminjam'];
				$nama_peminjam = $v['nama_peminjam'];
				$no_telp = $v['no_telp'];
				$email = $v['email'];
				$nomor = $v['nomor'];
				$flag = $v['flag'];
				$level = $v['status'];

				$ruang = str_replace('F.F', 'F.', $ruang);
				$ruang = str_replace('E.E', 'E.', $ruang);
				$ruang = str_replace('H.H', 'H.', $ruang);
				$ruang = str_replace('G.G', 'G.', $ruang);
				$ruang = str_replace('G-', 'G.', $ruang);
				$ruang = str_replace('M', 'M.', $ruang);
				$ruang = str_replace('M-', 'M.', $ruang);

				//tanggalnya_hari($isi, $result, $date1, $date2, $hari, $array_hari, $id);
				//tanggalnya_hari($hari, $kd_hari, $ruang, $start, $lama, $html, $date1, $date2, $hari, $array_hari, $id);

				/* menentukan tanggal pada setiap mata kuliah */
				// memecah bagian-bagian dari tanggal $date1
				$pecahTgl1 = explode("-", $date1);

				// membaca bagian-bagian dari $date1
				$tgl1 = $pecahTgl1[0];
				$bln1 = $pecahTgl1[1];
				$thn1 = $pecahTgl1[2];

				$i = 0; // counter looping
				$sum = 0;// counter untuk jumlah hari

				do {
				   // mengenerate tanggal berikutnya
				   $tanggal = date("d-m-Y", mktime(0, 0, 0, $bln1, $tgl1+$i, $thn1));
				   $tgl_kuliah = date("Y-m-d", mktime(0, 0, 0, $bln1, $tgl1+$i, $thn1));
				   // cek jika harinya mata kuliah, maka counter $sum bertambah satu, lalu tampilkan tanggalnya
				   if (date("w", mktime(0, 0, 0, $bln1, $tgl1+$i, $thn1)) == $kd_hari)  {

				    	$sum++;	//increment untuk jumlah hari

						$start_date = str_replace('-', '/', $tgl_kuliah).' '.$v['start_time'];
						$end_date = str_replace('-', '/', $tgl_kuliah).' '.$v['end_time'];

						$xml .= "<event>";
						$xml .= "<event_id><![CDATA[".$event_id."]]></event_id>";
						$xml .= "<start_date><![CDATA[".$start_date."]]></start_date>";
						$xml .= "<end_date><![CDATA[".$end_date."]]></end_date>";
						$xml .= "<text><![CDATA[".$html."]]></text>";
						$xml .= "<prodi><![CDATA[".$prodi."]]></prodi>";
						$xml .= "<id_petugas><![CDATA[".$id_petugas."]]></id_petugas>";
						$xml .= "<id_peminjam><![CDATA[".$id_peminjam."]]></id_peminjam>";
						$xml .= "<nama_peminjam><![CDATA[".$nama_peminjam."]]></nama_peminjam>";
						$xml .= "<no_telp><![CDATA[".$no_telp."]]></no_telp>";
						$xml .= "<email><![CDATA[".$email."]]></email>";
						$xml .= "<nomor><![CDATA[".$nomor."]]></nomor>";
						$xml .= "<flag><![CDATA[".$flag."]]></flag>";
						$xml .= "<level><![CDATA[".$level."]]></level>";
						$xml .= "<section_id>".$ruang."</section_id>";
						$xml .= "</event>";

				   }

				   $i++;  //increment untuk counter looping
				}
				// looping di atas akan terus dilakukan selama tanggal yang digenerate tidak sama dengan $date2.
				while ($tanggal != $date2);
			}
		}
		$xml .= $this->data_peminjaman();
		$xml .= "</data>";
		print $xml;
	}

	public function dataPerKelas()
	{
		error_reporting(E_ALL ^ E_NOTICE);
		header("Content-type:text/xml, charset=utf-8");
		$kd_ruang = (int) $this->uri->segment(4);
		$sql = "SELECT *, nm_ruang,
				(CASE
					WHEN DAYNAME(start_date) = 'Sunday' THEN 'Minggu'
					WHEN DAYNAME(start_date) = 'Monday' THEN 'Senin'
					WHEN DAYNAME(start_date) = 'Tuesday' THEN 'Selasa'
					WHEN DAYNAME(start_date) = 'Wednesday' THEN 'Rabu'
					WHEN DAYNAME(start_date) = 'Thursday' THEN 'Kamis'
					WHEN DAYNAME(start_date) = 'Friday' THEN 'Jumat'
					WHEN DAYNAME(start_date) = 'Saturday' THEN 'Sabtu'
				END) as hari, TIME(start_date) as start_time, TIME(end_date) as end_time
				FROM kegiatan a, waktu b, ruang c
				WHERE b.ruang = kd_ruang AND a.nomor = b.nomor AND flag = 0 AND event_name <> '' AND kd_ruang  = '$kd_ruang'
				ORDER BY b.ruang, start_date";

		$result = mysql_query($sql) or die(mysql_error());
		while($row = mysql_fetch_assoc($result)){
			$_data[$row['event_id']][] = $row;
		}

		/*	set tanggal, jika jenisnya adalah mata kuliah maka set tanggal pada saat awal kuliah dan akhir kuliah */
		$date1 = "28-08-2017";
		$date2 = "29-12-2017";

		$array_hari = array(
			'Senin' => '1',
			'Selasa'=> '2',
			'Rabu' 	=> '3',
			'Kamis' => '4',
			'Jumat' => '5',
			'Sabtu' => '6'
		);

		$xml = "<data>";

		foreach ($_data as $keys => $values) {
			//echo $keys.'<br>';
			$id = $keys;
			foreach ($values as $k => $v) {
				$event_id = $v['event_id'];
				//$hari = $v['hari'];
				$kd_hari = $array_hari[$v['hari']]; //tentukan kode hari
				$ruang = $v['nm_ruang'];
				$start_date = $v['start_date'];
				$end_date = $v['end_date'];
				//$start = $v['start'];
				//$lama = $v['lama'];
				$html = $v['event_name'];
				$prodi = $v['prodi'];
				$id_petugas = $v['id_petugas'];
				$id_peminjam = $v['id_peminjam'];
				$nama_peminjam = $v['nama_peminjam'];
				$no_telp = $v['no_telp'];
				$email = $v['email'];
				$nomor = $v['nomor'];
				$flag = $v['flag'];
				$level = $v['status'];

				$ruang = str_replace('F.F', 'F.', $ruang);
				$ruang = str_replace('E.E', 'E.', $ruang);
				$ruang = str_replace('H.H', 'H.', $ruang);
				$ruang = str_replace('G.G', 'G.', $ruang);
				$ruang = str_replace('G-', 'G.', $ruang);
				$ruang = str_replace('M', 'M.', $ruang);
				$ruang = str_replace('M-', 'M.', $ruang);

				//tanggalnya_hari($isi, $result, $date1, $date2, $hari, $array_hari, $id);
				//tanggalnya_hari($hari, $kd_hari, $ruang, $start, $lama, $html, $date1, $date2, $hari, $array_hari, $id);

				/* menentukan tanggal pada setiap mata kuliah */
				// memecah bagian-bagian dari tanggal $date1
				$pecahTgl1 = explode("-", $date1);

				// membaca bagian-bagian dari $date1
				$tgl1 = $pecahTgl1[0];
				$bln1 = $pecahTgl1[1];
				$thn1 = $pecahTgl1[2];

				$i = 0; // counter looping
				$sum = 0;// counter untuk jumlah hari

				do {
				   // mengenerate tanggal berikutnya
				   $tanggal = date("d-m-Y", mktime(0, 0, 0, $bln1, $tgl1+$i, $thn1));
				   $tgl_kuliah = date("Y-m-d", mktime(0, 0, 0, $bln1, $tgl1+$i, $thn1));
				   // cek jika harinya mata kuliah, maka counter $sum bertambah satu, lalu tampilkan tanggalnya
				   if (date("w", mktime(0, 0, 0, $bln1, $tgl1+$i, $thn1)) == $kd_hari)  {

				    	$sum++;	//increment untuk jumlah hari

						$start_date = str_replace('-', '/', $tgl_kuliah).' '.$v['start_time'];
						$end_date = str_replace('-', '/', $tgl_kuliah).' '.$v['end_time'];

						$xml .= "<event>";
						$xml .= "<event_id><![CDATA[".$event_id."]]></event_id>";
						$xml .= "<start_date><![CDATA[".$start_date."]]></start_date>";
						$xml .= "<end_date><![CDATA[".$end_date."]]></end_date>";
						$xml .= "<text><![CDATA[".$html."]]></text>";
						$xml .= "<prodi><![CDATA[".$prodi."]]></prodi>";
						$xml .= "<id_petugas><![CDATA[".$id_petugas."]]></id_petugas>";
						$xml .= "<id_peminjam><![CDATA[".$id_peminjam."]]></id_peminjam>";
						$xml .= "<nama_peminjam><![CDATA[".$nama_peminjam."]]></nama_peminjam>";
						$xml .= "<no_telp><![CDATA[".$no_telp."]]></no_telp>";
						$xml .= "<email><![CDATA[".$email."]]></email>";
						$xml .= "<nomor><![CDATA[".$nomor."]]></nomor>";
						$xml .= "<flag><![CDATA[".$flag."]]></flag>";
						$xml .= "<level><![CDATA[".$level."]]></level>";
						$xml .= "<section_id>".$ruang."</section_id>";
						$xml .= "</event>";

				   }

				   $i++;  //increment untuk counter looping
				}
				// looping di atas akan terus dilakukan selama tanggal yang digenerate tidak sama dengan $date2.
				while ($tanggal != $date2);
			}
		}
		$xml .= $this->data_peminjaman_perkelas();
		$xml .= "</data>";
		print $xml;
	}

	public function data_peminjaman_perkelas()
	{
		$kd_ruang = (int) $this->uri->segment(4);

		$sql = "SELECT *, nm_ruang
				FROM kegiatan a, waktu b, ruang c
				WHERE b.ruang = kd_ruang AND a.nomor = b.nomor AND flag = 1 AND kd_ruang = $kd_ruang
				ORDER BY b.ruang, start_date";

		$result = mysql_query($sql) or die(mysql_error());
		while($row = mysql_fetch_assoc($result)){
			$_data[$row['event_id']][] = $row;
		}

		$array_hari = array(
				'Senin' => '1',
				'Selasa' => '2',
				'Rabu' => '3',
				'Kamis' => '4',
				'Jumat' => '5',
				'Sabtu' => '6'
			);

		//$xml = "<data>";

		foreach ($_data as $keys => $values) {
			//echo $keys.'<br>';
			$id = $keys;
			foreach ($values as $k => $v) {
				$event_id = $v['event_id'];
				//$hari = $v['hari'];
				//$kd_hari = $array_hari[$v['hari']]; //tentukan kode hari
				$ruang = $v['nm_ruang'];
				$start_date = $v['start_date'];
				$end_date = $v['end_date'];
				//$start = $v['start'];
				//$end = $v['end'];
				$html = $v['event_name'];
				//$tgl_kegiatan = str_replace('-', '/', $v['tgl_kegiatan']);
				$prodi = $v['prodi'];
				$id_petugas = $v['id_petugas'];
				$id_peminjam = $v['id_peminjam'];
				$nama_peminjam = $v['nama_peminjam'];
				$no_telp = $v['no_telp'];
				$email = $v['email'];
				$nomor = $v['nomor'];
				$flag = $v['flag'];
				$level = $v['status'];

				$ruang = str_replace('F.F', 'F.', $ruang);
				$ruang = str_replace('E.E', 'E.', $ruang);
				$ruang = str_replace('H.H', 'H.', $ruang);
				$ruang = str_replace('G.G', 'G.', $ruang);
				$ruang = str_replace('G-', 'G.', $ruang);
				$ruang = str_replace('M', 'M.', $ruang);
				$ruang = str_replace('M-', 'M.', $ruang);

				$start_date = str_replace('-', '/', $start_date);
				$end_date = str_replace('-', '/', $end_date);

				$xml .= "<event>";
				$xml .= "<event_id><![CDATA[".$event_id."]]></event_id>";
				$xml .= "<start_date><![CDATA[".$start_date."]]></start_date>";
				$xml .= "<end_date><![CDATA[".$end_date."]]></end_date>";
				$xml .= "<text><![CDATA[".$html."]]></text>";
				$xml .= "<prodi><![CDATA[".$prodi."]]></prodi>";
				$xml .= "<id_petugas><![CDATA[".$id_petugas."]]></id_petugas>";
				$xml .= "<id_peminjam><![CDATA[".$id_peminjam."]]></id_peminjam>";
				$xml .= "<nama_peminjam><![CDATA[".$nama_peminjam."]]></nama_peminjam>";
				$xml .= "<no_telp><![CDATA[".$no_telp."]]></no_telp>";
				$xml .= "<email><![CDATA[".$email."]]></email>";
				$xml .= "<nomor><![CDATA[".$nomor."]]></nomor>";
				$xml .= "<flag><![CDATA[".$flag."]]></flag>";
				$xml .= "<level><![CDATA[".$level."]]></level>";
				$xml .= "<section_id>".$ruang."</section_id>";
				$xml .= "</event>";
			}
		}
		//$xml .= "</data>";
		//print $xml;
		return $xml;
	}	

	public function data_biasa()
	{
		//data feed
		$this->load->database();

		$connector = new SchedulerConnector($this->db, "PHPCI");
		$connector->configure("jadwal_ajs","event_id","start_date,end_date,event_name,details");
		$connector->event->attach($this);
		$connector->render();
	}
}
