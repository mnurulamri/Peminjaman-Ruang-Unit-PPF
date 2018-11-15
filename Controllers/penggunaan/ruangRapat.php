<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RuangRapat extends CI_Controller 
{
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('service');
		$this->load->model('penggunaan/ruangrapatmodel');
		date_default_timezone_set('Asia/Jakarta');

	}

	public function template(){
		$userlogin = ($this->session->userdata['logged_in']['username']);
		$data_header['foto'] = $this->service->getFoto($userlogin);
		$data_header['nama'] = $this->service->getNama($userlogin);
		$data['ruang'] 		= $this->ruangrapatmodel->getRuang();
		$data['menu'] 		= $this->load->view('layout/3_menu', $data, true);
		$this->load->view('layout/1-head-title');
		$this->load->view('layout/2-header', $data_header);		
		$this->load->view('layout/3-menu', $data);
	}

    public function listKegiatan(){
		$kd_ruang = $this->input->post('kd_ruang');
		$data['data'] = $this->ruangrapatmodel->listKegiatan($kd_ruang);
		$this->load->view('penggunaan/listKegiatan', $data);
    }

	public function insertKegiatan(){
		//fetch input data form
		//$nomor 			= $this->input->post('nomor');
		$_tgl_proses	= $this->input->post('tgl_proses');
		$_tgl_permohonan= $this->input->post('tgl_permohonan');
		$kd_ruang 		= $this->input->post('ruang');
		$event_name 	= $this->input->post('nama_kegiatan');
		$jml_peserta 	= $this->input->post('jml_peserta');
		$nama_peminjam 	= $this->input->post('nama_peminjam');
		$id_peminjam 	= $this->input->post('id_peminjam');
		$unit_kerja 	= $this->input->post('unit_kerja');
		$no_telp 		= $this->input->post('no_telp');
		$email 			= $this->input->post('email');
		$kebutuhan 		= $this->input->post('kebutuhan');
		$catatan 		= $this->input->post('catatan');

		$tgl_proses = $this->format_tanggal($_tgl_proses);
		$tgl_permohonan = $this->format_tanggal($_tgl_permohonan);
		$username = $this->session->userdata['logged_in']['username'];

		$nomor = 'ppf'.$this->getToken(); //$nomor = $this->ruangrapatmodel->getNomor();
		
		//preprare data insert
		$data = array(
			'event_name' 	=> $event_name,
			'tgl_proses' 	=> $tgl_proses,
			'tgl_permohonan'=> $tgl_permohonan,
			'nama_peminjam' => $nama_peminjam,
			'jml_peserta' 	=> $jml_peserta,
			'id_peminjam' 	=> $id_peminjam,
			'prodi' 		=> $unit_kerja,
			'no_telp' 		=> $no_telp,
			'email' 		=> $email,
			'nomor' 		=> $nomor,
			'details'		=> $kebutuhan,
			'catatan'		=> $catatan,
			'status'		=> 1,
			'username' 		=> $username,
			'flag'			=> 1
		);
		
		$this->ruangrapatmodel->insertKegiatan($data);
		echo $nomor;  //parameter nomor surat yang dikirimn untuk edit jadwal
	}

	public function editKegiatan(){
		//fetch input data form
		$id_kegiatan	= $this->input->post('id_kegiatan');
		$nomor 			= $this->input->post('nomor');
		$no_surat 		= $this->input->post('no_surat');
		$tgl_proses		= $this->format_tanggal($this->input->post('tgl_proses'));
		$tgl_permohonan = $this->format_tanggal($this->input->post('tgl_permohonan'));
		$kd_ruang 		= $this->input->post('ruang');
		$event_name 	= $this->input->post('nama_kegiatan');
		$jml_peserta 	= $this->input->post('jml_peserta');
		$nama_peminjam 	= $this->input->post('nama_peminjam');
		$id_peminjam 	= $this->input->post('id_peminjam');
		$unit_kerja 	= $this->input->post('unit_kerja');
		$no_telp 		= $this->input->post('no_telp');
		$email 			= $this->input->post('email');
		$kebutuhan 		= $this->input->post('kebutuhan');
		$catatan 		= $this->input->post('catatan');

		//preprare data edit
		$data = array(
			'id_kegiatan' 	=> $id_kegiatan,
			'no_surat' 		=> $no_surat,
			'event_name' 	=> $event_name,
			'tgl_proses' 	=> $tgl_proses,
			'tgl_permohonan'=> $tgl_permohonan,
			'nama_peminjam' => $nama_peminjam,
			'jml_peserta' 	=> $jml_peserta,
			'id_peminjam' 	=> $id_peminjam,
			'prodi' 		=> $unit_kerja,
			'no_telp' 		=> $no_telp,
			'email' 		=> $email,
			'nomor' 		=> $nomor,
			'details'		=> $kebutuhan,
			'catatan'		=> $catatan,
			'status'		=> 1
		);
		
		//echo '<div>event_id'.$event_id.' data sudah di simpan!...</div>';
		$this->ruangrapatmodel->editKegiatan($data, $id_kegiatan);
	}

	public function insertJadwal(){  //insert untuk form tambah pengajuan
		//fetch input data form
		$nomor 			= $this->input->post('nomor');
		$ruang 			= $this->input->post('ruang');
		$_tgl_kegiatan 	= $this->input->post('tgl_kegiatan');
		$jam_awal 		= $this->input->post('jam_mulai');
		$menit_awal 	= $this->input->post('menit_mulai');
		$jam_akhir 		= $this->input->post('jam_selesai');
		$menit_akhir 	= $this->input->post('menit_selesai');

		$array = array();

		//nomor
		//$array[0]['nomor'] = $nomor;

		//ruangan
		$i=0;
		foreach ($ruang as $k => $v) {
			$array[$i]['ruang'] = $v;
			$i++;
		}

		//tanggal kegiatan
		$i=0;
		foreach ($_tgl_kegiatan as $k => $v) {
			$tgl_kegiatan = $this->format_tanggal($v);
			$array[$i]['tgl_kegiatan'] = $tgl_kegiatan;
			$array[$i]['nomor'] = $nomor;
			$i++;
		}

		//jam mulai
		$i=0;		
		foreach ($jam_awal as $k => $v) {
			$array[$i]['jam_awal'] = $v;
			$i++;
		}

		//jam akhir
		$i=0;		
		foreach ($jam_akhir as $k => $v) {
			$array[$i]['jam_akhir'] = $v;
			$i++;
		}
		
		//menit awal
		$i=0;
		foreach ($menit_awal as $k => $v) {
			$array[$i]['menit_awal'] = $v;
			$i++;
		}
		
		//menit selesai
		$i=0;
		foreach ($menit_akhir as $k => $v) {
			$array[$i]['menit_akhir'] = $v;
			$i++;
		}

		
		$i=0;		
		foreach ($array as $k => $v) {
			$ruang = $v['ruang'];
			$start_date = $v['tgl_kegiatan'].' '.$v['jam_awal'].':'.$v['menit_awal'];
			$end_date = $v['tgl_kegiatan'].' '.$v['jam_akhir'].':'.$v['menit_akhir'];	
			$data = array(
				'nomor'		=>$nomor,
				'ruang'		=>$ruang,
				'start_date'=>$start_date,
				'end_date'	=>$end_date
			);
			$this->ruangrapatmodel->insertJadwal($data);
		}
		
	}

	public function editJadwal()
	{  //edit dari form pengajuan
		//fetch input data form
		$event_id		= $this->input->post('event_id');
		$nomor 			= $this->input->post('nomor');
		$ruang 			= $this->input->post('ruang');
		$_tgl_kegiatan 	= $this->input->post('tgl_kegiatan');
		$jam_awal 		= $this->input->post('jam_mulai');
		$menit_awal 	= $this->input->post('menit_mulai');
		$jam_akhir 		= $this->input->post('jam_selesai');
		$menit_akhir 	= $this->input->post('menit_selesai');

		$array = array();

		$i=0;		
		foreach ($event_id as $k => $v) {
			$array[$i]['event_id'] = $v;
			$i++;
		}

		//ruang
		$i=0;		
		foreach ($ruang as $k => $v) {
			$array[$i]['ruang'] = $v;
			$i++;
		}

		//tanggal kegiatan
		$i=0;
		foreach ($_tgl_kegiatan as $k => $v) {
			$tgl_kegiatan = $this->format_tanggal($v);
			$array[$i]['tgl_kegiatan'] = $tgl_kegiatan;
			$array[$i]['nomor'] = $nomor;
			//$array[$i]['event_id'] = $event_id;
			$i++;
		}

		//jam mulai
		$i=0;		
		foreach ($jam_awal as $k => $v) {
			$array[$i]['jam_awal'] = $v;
			$i++;
		}

		//jam akhir
		$i=0;		
		foreach ($jam_akhir as $k => $v) {
			$array[$i]['jam_akhir'] = $v;
			$i++;
		}
		
		//menit awal
		$i=0;
		foreach ($menit_awal as $k => $v) {
			$array[$i]['menit_awal'] = $v;
			$i++;
		}
		
		//menit selesai
		$i=0;
		foreach ($menit_akhir as $k => $v) {
			$array[$i]['menit_akhir'] = $v;
			$i++;
		}

		//kelola input/edit data dengan mempertimbangkan jadwal yang bentrok
		//tampilkan pesan bila terjadi jadwal yang bentrok kemudian simpan data bila sudah tidak ada jadwal yang bentrok
		$array_hari = array('Sun'=>'Minggu', 'Mon'=>'Senin', 'Tue'=>'Selasa', 'Wed'=>'Rabu', 'Thu'=>'Kamis', 'Fri'=>'Jumat', 'Sat'=>'Sabtu');
		$array_bulan = array('1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni', '7'=>'Juli',
		                    '8'=>'Agustus', '9'=>'September', '10'=>'Oktober', '11'=>'Nopember', '12'=>'Desember', );
		$data_bentrok = array();
		
		$i=0;		
		foreach ($array as $k => $v) {
			$event_id = $v['event_id'];
			$ruang = $v['ruang'];
			$start_date = $v['tgl_kegiatan'].' '.$v['jam_awal'].':'.$v['menit_awal'];
			$end_date = $v['tgl_kegiatan'].' '.$v['jam_akhir'].':'.$v['menit_akhir'];

			if ($ruang == 236 OR $ruang == 237) {
				# code...
			} else {
				$jadwal_bentrok = $this->ruangrapatmodel->jadwalBentrok($event_id, $start_date, $end_date, $ruang);
			}
			
			$j=0; //counter data bentrok
			if ($jadwal_bentrok) {
				
				foreach ($jadwal_bentrok as $key => $value) {
					//tentukan jadwal yang bentrok
					$event_name	= $value->event_name;
					$ruang 		= $value->nm_ruang;
					$d 			= date('D', strtotime($value->start_date));
					$waktu_awal = date('H:i', strtotime($value->start_date));
					$waktu_akhir= date('H:i', strtotime($value->end_date));
					$nama_hari 	= $array_hari[$d];
					$tgl 		= $value->tgl;
					$bulan 		= $array_bulan[$value->bulan];
					$tahun 		= $value->tahun;
					$tanggal 	= $tgl.' '.$bulan.' '.$tahun;			
					//tampilkan pesan bentrok ke dalam form
					$data_bentrok[$j] = '<div class="well well-sm" style="color:red">Bentrok Dengan Kegiatan '.$event_name.', Hari '.$nama_hari.' Tanggal '.$tanggal.' Jam '.$waktu_awal.'-'.$waktu_akhir.' Ruang '.$ruang.'</div>';
					echo '<div class="well well-sm">Bentrok Dengan Kegiatan '.$event_name.', Hari '.$nama_hari.' Tanggal '.$tanggal.' Jam '.$waktu_awal.'-'.$waktu_akhir.' Ruang '.$ruang.'</div>';	
				}
				$j++;		
			} else {
				//bila tidak ada jadwal yang bentrok maka input atau edit nomor surat, ruang, tanggal dan waktunya
				$data = array(
					'event_id'	=>$event_id,
					'ruang'		=>$ruang,
					'nomor'		=>$nomor,
					'start_date'=>$start_date,
					'end_date'	=>$end_date
				);
				//echo '<pre>';echo print_r($data);echo '</pre>';;
				$sql = "REPLACE INTO waktu (event_id,ruang,nomor,start_date,end_date) VALUES('$event_id', '$ruang', '$nomor', '$start_date', '$end_date')";
				mysql_query($sql) or die(mysql_error());
				//echo '<div>event_id'.$nomor.' data sudah di simpan!...</div>';
			}
		}
		
		//tutup modal bila sudah tidak ada jadwal yang bentrok
		if (count($data_bentrok) == 0) {
			echo '<script>window.location.replace("daftar-pengajuan");</script>';
		}
	}

	public function insertItemJadwal(){  //insert untuk form edit pengajuan
		//fetch input data form
		$nomor 			= $this->input->post('nomor');
		$ruang 			= $this->input->post('ruang');
		$_tgl_kegiatan 	= $this->input->post('tgl_kegiatan');
		$jam_awal 		= $this->input->post('jam_mulai');
		$menit_awal 	= $this->input->post('menit_mulai');
		$jam_akhir 		= $this->input->post('jam_selesai');
		$menit_akhir 	= $this->input->post('menit_selesai');

		$tgl_kegiatan 	= $this->format_tanggal($_tgl_kegiatan);

		$start_date 	= $tgl_kegiatan.' '.$v['jam_awal'].':'.$v['menit_awal'];
		$end_date 		= $tgl_kegiatan.' '.$v['jam_akhir'].':'.$v['menit_akhir'];

		$data = array(
			'nomor'		=> $nomor,
			'ruang'		=> $ruang,
			'start_date'=> $start_date,
			'end_date'	=> $end_date
		);
		$this->ruangrapatmodel->insertJadwal($data);
	}

	public function delWaktu($event_id){
		$event_id = $this->input->post('event_id');
		$this->ruangrapatmodel->delWaktu($event_id);
	}
	
	public function delKegiatan()
	{
		$nomor = $this->input->post('nomor');
		$this->ruangrapatmodel->delKegiatan($nomor);
	}

	public function pengajuanEdit()
	{  //form edit pengajuan
		$id = $this->input->post('id');
		$data['ruang_new']= $this->getRuangAddRow();
		$data['data'] 	= $this->ruangrapatmodel->editJadwal($id);
		$this->load->view('penggunaan/ruangRapatPengajuanEdit', $data);
	}

	public function getToken()
	{
	     $token = "";
	     $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	     $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
	     $codeAlphabet.= "0123456789";
	     $max = strlen($codeAlphabet); // edited

	    for ($i=0; $i < 20; $i++) {
	        $token .= $codeAlphabet[rand(0, $max-1)];
	    }

	    return $token;
	}

	public function getNomor()
	{
		$nomor = $this->ruangrapatmodel->getNomor();
		return $nomor;
	}

	public function cekNomor(){
		$nomor = $this->ruangrapatmodel->cekNomor();
		return $nomor;
	}

	public function getKegiatanID(){   //untuk inputan key pengait kegiatan dan waktu
		$nomor = $this->ruangrapatmodel->getKegiatanID();
		return $nomor;
	}

	public function getRuang(){
		$ruang = $this->ruangrapatmodel->getRuang();

		$html='<select id="ruang_+i + " name="ruang" class="ruang form-control" style="width: 100px">';
		foreach ($ruang as $k => $v) {
			$html.= '<option value="'.$v->kd_ruang.'">'.$v->nm_ruang.'</option>';
		}
		$html.='</select>';
		return $html;		
	}

	public function getRuangAddRow(){
		$ruang = $this->ruangrapatmodel->getRuang();

		$html='';
		foreach ($ruang as $k => $v) {
			$html.= '<option value="'.$v->kd_ruang.'">'.$v->nm_ruang.'</option>';
		}
		return $html;		
	}	

	public function getFieldRuang($nm_ruang=''){
		//set ruang berdasarkan hak akses
		$hak_akses = ($this->session->userdata['logged_in']['hak_akses']);
		if($hak_akses == 1){ //ruang untuk admin
			$ruang = $this->ruangrapatmodel->getRuang();
		} else {
			$ruang = $this->ruangrapatmodel->getRuangUser(); //untuk mengeluarkan ruang F.201
		}

		$html='<select id="ruang" name="ruang" class="ruang form-control" style="width: 100px">';
		foreach ($ruang as $k => $v) {
			if($v->nm_ruang == $nm_ruang){
				$html.= '<option value="'.$v->kd_ruang.'" selected >'.$v->nm_ruang.'</option>';
			} else {
				$html.= '<option value="'.$v->kd_ruang.'">'.$v->nm_ruang.'</option>';
			}			
		}
		$html.='</select>';
		return $html;
	}

	public function getRuangRapat($nm_ruang='')
	{		
		$ruang = $this->daftarruangrapatmodel->getRuangRapat();

		$html='<select id="ruang" name="ruang" class="ruang form-control" >';
		foreach ($ruang as $k => $v) {
			if($v->nm_ruang == $nm_ruang){
				$html.= '<option value="'.$v->kd_ruang.'" selected >'.$v->nm_ruang.'</option>';
			} else {
				$html.= '<option value="'.$v->kd_ruang.'">'.$v->nm_ruang.'</option>';
			}			
		}
		$html.='</select>';
		return $html;
	}

	public function daftar()
	{
		$userlogin = ($this->session->userdata['logged_in']['username']);
		$data_header['foto'] = $this->service->getFoto($userlogin);
		$data_header['nama'] = $this->service->getNama($userlogin);
		$data['ruang'] 		= $this->ruangrapatmodel->getRuang();
		$data['menu'] 		= $this->load->view('layout/3_menu', $data, true);		
		$data['script'] = $this->load->view('layout/template-2', null, true);
		$this->load->view('layout/1-head-title');
		$this->load->view('layout/2-header', $data_header);		
		$this->load->view('layout/3-menu', $data);		
		$this->load->view('penggunaan/ruangRapatList', $data);
	}

	public function pengajuanList(){
		$userlogin = ($this->session->userdata['logged_in']['username']);
		$data_header['foto'] = $this->service->getFoto($userlogin);
		$data_header['nama'] = $this->service->getNama($userlogin);

		$data['ruang'] 		= $this->ruangrapatmodel->getRuang();
		$data['menu'] 		= $this->load->view('layout/3_menu', $data, true);		
		$data['script'] 	= $this->load->view('layout/template-2', null, true);
		$data['data'] 		= $this->ruangrapatmodel->getData();
		$this->load->view('layout/1-head-title');
		$this->load->view('layout/2-header', $data_header);		
		$this->load->view('layout/3-menu', $data);
		$this->load->view('penggunaan/ruangRapatPengajuanListTest', $data);
		//$this->load->view('penggunaan/ruangRapatPengajuanList', $data);
	}

	public function pengajuanAdd(){
		$nosurat			= $this->getToken();
		//$nosurat			= $this->getNomor();
		//-------------------------
		//$nosurat			= $this->getKegiatanID();
		//$nosurat += 674;
		$data['nomor'] 		= $nosurat;
		$data['ruang'] 		= $this->getFieldRuang();
		$data['start_time'] = $this->waktuMulai();
		$data['end_time'] 	= $this->waktuSelesai();

		$username = $this->session->userdata['logged_in']['username'];
		$data['data_user']	= $this->ruangrapatmodel->getDataUser($username);

		$this->load->view('penggunaan/ruangRapatPengajuanAddTest', $data);
		//$this->load->view('penggunaan/ruangRapatPengajuanAdd', $data);
		
	}

	public function pengajuanAddExecute(){
		
		$nomor 			= $this->input->post('nomor');
		$_tgl_proses	= $this->input->post('tgl_proses');
		$_tgl_permohonan= $this->input->post('tgl_permohonan');
		$_tgl_kegiatan 	= $this->input->post('tgl_kegiatan');
		$kd_ruang 		= $this->input->post('ruang');
		$event_name 	= $this->input->post('nama_kegiatan');
		$jml_peserta 	= $this->input->post('jml_peserta');
		$nama_peminjam 	= $this->input->post('nama_peminjam');
		$id_peminjam 	= $this->input->post('id_peminjam');
		$unit_kerja 	= $this->input->post('unit_kerja');
		$no_telp 		= $this->input->post('no_telp');
		$email 			= $this->input->post('email');
		$jam_awal 		= $this->input->post('jam_mulai');
		$menit_awal 	= $this->input->post('menit_mulai');
		$jam_akhir	    = $this->input->post('jam_selesai');
		$menit_akhir 	= $this->input->post('menit_selesai');
		$kebutuhan 		= $this->input->post('kebutuhan');

		$jam_awal = (strlen($jam_awal) == 1) ? '0'.$jam_awal : $jam_awal ;
		$menit_awal = (strlen($menit_awal) == 1) ? '0'.$menit_awal.':00' : $menit_awal.':00' ;
		$jam_akhir = (strlen($jam_akhir) == 1) ? '0'.$jam_akhir : $jam_akhir ;
		$menit_akhir = (strlen($menit_akhir) == 1) ? '0'.$menit_akhir.':00' : $menit_akhir.':00' ;

		//rubah format tanggal
		$tgl_kegiatan = $this->format_tanggal($_tgl_kegiatan);
		$tgl_proses = $this->format_tanggal($_tgl_proses);
		$tgl_permohonan = $this->format_tanggal($_tgl_permohonan);

		$start_date = $tgl_kegiatan.' '.$jam_awal.':'.$menit_awal;
		$end_date = $tgl_kegiatan.' '.$jam_akhir.':'.$menit_akhir;

		$data = array(
			'event_name' 	=> $event_name,
			'tgl_proses' 	=> $tgl_proses,
			'tgl_permohonan'=> $tgl_permohonan,
			'nama_peminjam' => $nama_peminjam,
			'jml_peserta' 	=> $jml_peserta,
			'id_peminjam' 	=> $id_peminjam,
			'prodi' 		=> $unit_kerja,
			'no_telp' 		=> $no_telp,
			'email' 		=> $email,
			'ruang' 		=> $kd_ruang,
			'nomor' 		=> $nomor,
			'details'		=> $kebutuhan
		);

		$data_jadwal = array(
			'nomor'			=> $nomor,
			'start_date' 	=> $start_date,
			'end_date' 		=> $end_date
		);
		//print_r($data) ;
		//echo '<div>event_id'.$event_id.' data sudah di simpan!...</div>';
		$this->ruangrapatmodel->insertJadwal($data);
		$data = $this->datatableRuang();
		echo $data;
	}

	public function status()
	{
		$userlogin = ($this->session->userdata['logged_in']['username']);
		$data_header['foto'] = $this->service->getFoto($userlogin);
		$data_header['nama'] = $this->service->getNama($userlogin);
		$this->load->view('layout/1-head-title');
		$this->load->view('layout/2-header', $data_header);
		$data['ruang'] 		= $this->ruangrapatmodel->getRuang();
		$data['menu'] 		= $this->load->view('layout/3_menu', $data, true);
		$this->load->view('layout/3-menu', $data);		
		$data['script'] 	= $this->load->view('layout/template-2', null, true);
		$data['data'] 		= $this->ruangrapatmodel->getListStatusPinjam();		
		$this->load->view('penggunaan/statusPinjamList', $data);  //ruangRapatStatus
	}

	public function statusKonfirmasi()
	{  //form edit pengajuan
		$nomor 			= $this->input->post('nomor');
		$data['data'] 	= $this->getDataFormPengajuan($nomor);
		//$data['data_kegiatan'] 	= $this->ruangrapatmodel->getKegiatan($nomor);
		//$data['data_jadwal'] 	= $this->ruangrapatmodel->getJadwalRuang($nomor);
		$this->load->view('penggunaan/statusKonfirmasi', $data);
		//print_r($nomor);
	}

	function getDataFormPengajuan($nomor='')
	{
		//$nomor = $this->input->post('id');
		//$nomor = '666';
		$data_kegiatan 	= $this->ruangrapatmodel->getKegiatan($nomor);
		$data_jadwal 	= $this->ruangrapatmodel->getJadwalRuang($nomor);

		foreach ($data_kegiatan as $k => $v) {
            $id_kegiatan    = $v->id_kegiatan;
            $nomor          = $v->nomor;
            $no_surat       = $v->no_surat;
            $tgl_proses 	= $this->tanggal($v->tgl_proses);
            $tgl_proses_mentah 	= $v->tgl_proses;
            $tgl_permohonan = $this->tanggal($v->tgl_permohonan);
            $event_name  	= $v->event_name;
            $jml_peserta 	= $v->jml_peserta;
            $prodi 			= $v->prodi;
            $kebutuhan      = $v->details;
            $id_petugas     = $v->id_petugas;
            $id_peminjam    = $v->id_peminjam;
            $nama_peminjam  = $v->nama_peminjam;
            $unit_kerja     = $v->prodi;
            $no_telp        = $v->no_telp;
            $email          = $v->email;
            $catatan 		= $v->catatan;
            $status 		= $v->status;
		}

		$i=0;
		foreach ($data_jadwal as $k => $v) {
          $ruang      	= $v->ruangan;
          $tgl_kegiatan = $this->tanggal($v->start_date);
          $waktu_awal   = date('H:i', strtotime($v->start_date));
          $waktu_akhir  = date('H:i', strtotime($v->end_date));
          $waktu      	= $waktu_awal.' - '.$waktu_akhir;

			/*
			//cek jadwal bentrok
			if($v->start_date >= date("Y-m-d H:i:s")){
				$jadwal_bentrok[$i] = $this->ruangrapatmodel->jadwalBentrok($v->event_id, $v->start_date, $v->end_date, $v->kd_ruang);
			}
			*/
			
          //masukkan ke dalam array
          $jadwal[$i]['ruang'] 		  = $ruang;
          $jadwal[$i]['tgl_kegiatan'] = $tgl_kegiatan;
          $jadwal[$i]['waktu']    	  = $waktu;
          $jadwal[$i]['bentrok']    	  = $this->ruangrapatmodel->jadwalBentrok($v->event_id, $v->start_date, $v->end_date, $v->kd_ruang);
	
         //counter
          $i++;
		}

		$array = array(
			'id_kegiatan'	=> $id_kegiatan,
			'tgl_proses'	=> $tgl_proses,
			'tgl_proses_mentah' => $tgl_proses_mentah,
			'nomor'			=> $nomor,
			'no_surat'		=> $no_surat,
			'tgl_permohonan'=> $tgl_permohonan,
			'prodi'			=> $prodi,
			'nama_peminjam'	=> $nama_peminjam,
			'id_peminjam'	=> $id_peminjam,
			'no_telp'		=> $no_telp,
			'email'			=> $email,
			'event_name'	=> $event_name,
			'jml_peserta'	=> $jml_peserta,
			'jadwal'		=> $jadwal,
			'kebutuhan'		=> $kebutuhan,
			'catatan'		=> $catatan,
			'status'		=> $status
		);

		return $array;
		//$data['kegiatan'] = $data_kegiatan;
		//$data['data'] = $array;
		//$this->load->view('penggunaan/test', $data);
	}

	public function statusKonfirmasiPersetujuan(){
		$id_kegiatan = $this->input->post('id_kegiatan');
		$status 	 = $this->input->post('status');
		$no_surat 	 = $this->input->post('no_surat');

		switch ($status) {
			case 1:
				$ket_status = '<span style="color:#C85EC7">Menunggu Persetujuan Koordinator PPF</span>';
				break;
			case 2:
				$ket_status = '<span style="color:#808000">Menunggu Persetujuan Wakil Manajer PPF</span>';
				break;
			case 3:
				$ket_status = '<span style="color:#009966">Disetujui</span>';
				break;
			default:
				$ket_status = '???';
				break;
		}
		
		$data = array(
			'status' => $status,
			'no_surat' => $no_surat
		);
		echo $no_surat.'|'.$ket_status;
		$this->ruangrapatmodel->editKegiatan($data, $id_kegiatan);
	}

	public function waktuMulai()
	{
		$jam_mulai = '08';
		$start = '<select>';
		for ($i=8; $i<24; $i++) {
			$retVal = (strlen($i)==1) ? '0'.$i : $i ;
			$option = ($i==$jam_mulai) ? '<option value="'.$retVal.'" selected>'.$retVal.'</option>' : '<option>'.$retVal.'</option>' ;
			$start.= $option;
		}
		$start.= '</select>';
		$menit_mulai = '00';
		$start.= '<select name="menit_mulai" id="menit_mulai">'; //menit awal
		for ($i=0; $i<61; $i+=5) { 
			$retVal = (strlen($i)==1) ? '0'.$i : $i ;
			$option = ($i==$menit_mulai) ? '<option value="'.$retVal.'" selected>'.$retVal.'</option>' : '<option>'.$retVal.'</option>' ;
			$start.= $option;
		}
		$start.= '</select>';
		return $start;
	}

	public function waktuSelesai()
	{
		$end = '<select>';
		$jam_akhir = '09';
		for ($i=8; $i<24; $i++) {
			$retVal = (strlen($i)==1) ? '0'.$i : $i ;
			$option = ($i==$jam_akhir) ? '<option value="'.$retVal.'" selected>'.$retVal.'</option>' : '<option>'.$retVal.'</option>' ;
			$end.= $option;
		}
		$end.= '</select>';
		$menit_akhir = '00';
		$end.= '<select name="menit_selesai" id="menit_selesai">'; //menit akhir
		for ($i=0; $i<61; $i+=5) { 
			$retVal = (strlen($i)==1) ? '0'.$i : $i ;
			$option = ($i==$menit_akhir) ? '<option value="'.$retVal.'" selected>'.$retVal.'</option>' : '<option>'.$retVal.'</option>' ;
			$end.= $option;
		}
		$end.= '</select>';
		return $end;
	}

	function datatableRuang(){

		$data = $this->ruangrapatmodel->getData();

		$no = 1;	

		$array_hari = array('Sun'=>'Minggu', 'Mon'=>'Senin', 'Tue'=>'Selasa', 'Wed'=>'Rabu', 'Thu'=>'Kamis', 'Fri'=>'Jumat', 'Sat'=>'Sabtu');
		$array_bulan = array('1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni', '7'=>'Juli',
		                    '8'=>'Agustus', '9'=>'September', '10'=>'Oktober', '11'=>'Nopember', '12'=>'Desember', );

				echo'
                <table id="example1" class="table">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Kegiatan</th>
                      <th>Unit Pengguna</th>                      
                      <th>No. Surat</th>
                      <th>Jadwal</th>
                      <th>Edit</th>
                      <th>View</th>
                    </tr>
                  </thead>
                  <tbody>';
                    foreach ($data as $k_nomor => $v_nomor) {                      
                      foreach ($v_nomor as $k_event_name => $v_event_name) {
                        foreach ($v_event_name as $k_prodi => $v_prodi) {
                          echo '
                          <tr>
                            <td>'.$no.'</td>
                            <td id="event_name_'.$k_nomor.'">'.$k_event_name.'</td>
                            <td>'.$k_prodi.'</td>
                            <td>'.$k_nomor.'</td>
                            <td width="27%">
                              <table class="table">';

                                foreach ($v_prodi as $k => $v) {

                                  $d = date('D', strtotime($v->start_date));
                                  $waktu_awal = date('H:i', strtotime($v->start_date));
                                  $waktu_akhir = date('H:i', strtotime($v->end_date));
                                  $nama_hari = $array_hari[$d];
                                  $tgl = $v->tgl;
                                  $bulan = $array_bulan[$v->bulan];
                                  $tahun = $v->tahun;

                                  echo '
                                    <tr>
                                      <td>'.$v->nm_ruang.'</td>
                                      <td>'.$nama_hari.', '.$tgl.' '.$bulan.' '.$tahun.'</td>
                                      <td style="padding-left:5px">('.$waktu_awal.'-'.$waktu_akhir.')</td>
                                    </tr>';
                                }  
                            echo '
                              </table>
                            </td>
                            <td id='.$k_nomor.' data-toggle="modal" data-target=".edit-jadwal-rapat"><i class="fa fa-edit fa-align-center" style="color:#00a65a; font-size:20px; cursor:pointer"></i></td>
                            <td><i id='.$k_nomor.' class="view fa fa-file-pdf-o fa-align-center fa-lg faa-vertical" style="color:red; cursor:pointer"></i></td>
                          </tr>';
                          $no++;                             
                        }     
                      }
                    }
                    echo '
                  </tbody>
                  <tfoot>
                    <tr style="color:#fff; ">
                      <th class="line-left">No</th>
                      <th class="line-right">Nama Kegiatan</th>
                      <th class="line-right">Unit Pengguna</th>                      
                      <th class="line-right">No. Surat</th>
                      <th class="line-right">Jadwal</th>
                      <th class="line-right">Edit</th>
                      <th class="line-right">View</th>
                    </tr>
                    </tfoot>
                </table>
                
				<script>
				$(function () {
				                $.post("http://ppf.fisip.ui.ac.id/backend/penggunaan/ruangRapat/datatableRuang", function(data){
				                    $("#data-pengajuan").html(data);
				                    $("#example1").DataTable({scrollX:true});
				                });
				});
				</script>';
	}

	public function cekJadwalBentrok(){

		$array_hari = array('Sun'=>'Minggu', 'Mon'=>'Senin', 'Tue'=>'Selasa', 'Wed'=>'Rabu', 'Thu'=>'Kamis', 'Fri'=>'Jumat', 'Sat'=>'Sabtu');
		$array_bulan = array('1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni', '7'=>'Juli',
		                    '8'=>'Agustus', '9'=>'September', '10'=>'Oktober', '11'=>'Nopember', '12'=>'Desember', );

		$event_id 		= $this->input->post('event_id');
		$ruang 			= $this->input->post('ruang');
		$_tgl_kegiatan 	= $this->input->post('tgl_kegiatan');
		$tgl_kegiatan 	= $this->format_tanggal($_tgl_kegiatan);
		$jam_awal 		= $this->input->post('jam_mulai');
		$menit_awal 	= $this->input->post('menit_mulai');
		$jam_akhir 		= $this->input->post('jam_selesai');
		$menit_akhir 	= $this->input->post('menit_selesai');

		$start_date 	= $tgl_kegiatan.' '.$jam_awal.':'.$menit_awal;
		$end_date 		= $tgl_kegiatan.' '.$jam_akhir.':'.$menit_akhir;

		//tentukan jadwal bentrok berdasarkan data yang sudah masuk sebelumnya dengan data yang baru diinput
		if ($event_id == 0) {
			$jadwal_bentrok = $this->ruangrapatmodel->cekJadwalBentrok( $start_date, $end_date, $ruang);  //untuk data baru
		} else {
			$jadwal_bentrok = $this->ruangrapatmodel->jadwalBentrok($event_id, $start_date, $end_date, $ruang);  //untuk data yang sudah ada sebelumnya
		}		
		
		//tampilkan informasi jadwal yang bentrok
		if ($jadwal_bentrok) {			
			foreach ($jadwal_bentrok as $key => $value) {
				//tentukan jadwal yang bentrok
				$event_name	= $value->event_name;
				$ruang 		= $value->nm_ruang;
				$d 			= date('D', strtotime($value->start_date));
				$waktu_awal = date('H:i', strtotime($value->start_date));
				$waktu_akhir= date('H:i', strtotime($value->end_date));
				$nama_hari 	= $array_hari[$d];
				$tgl 		= $value->tgl;
				$bulan 		= $array_bulan[$value->bulan];
				$tahun 		= $value->tahun;
				$tanggal 	= $tgl.' '.$bulan.' '.$tahun;
				$jenis_event = (substr($value->nomor, 0, 4) == 'siak' or substr($value->nomor, 0, 4) == 'siak') ? 'Mata Kuliah' : 'Kegiatan';

				//tampilkan pesan bentrok
				echo '
				<div>&nbsp;</div>
				<!--<pre style="text-align:center; color:red">Bentrok Dengan Kegiatan '.$event_name.', Hari '.$nama_hari.' Tanggal '.$tanggal.' Jam '.$waktu_awal.'-'.$waktu_akhir.' Ruang '.$ruang.'</pre>-->
				<pre style="text-align:center; color:red">Bentrok Dengan '.$jenis_event. ' '.$event_name.'</pre>

';	
			}		
		}
	}

	public function disableCrud(){
		//$username = $this->input->post('username');
		$nomor = $this->input->post('event_id');
		$data = array(
			'nomor' 	=> $nomor,
			'flag_cetak'=> 1
		);
		echo $nomor;
		$this->ruangrapatmodel->disableCrud($data, $nomor);
	}
	
	public function format_tanggal($_tgl_kegiatan){
		$tgl = explode('/', $_tgl_kegiatan);
		$d = $tgl[1];
		$m = $tgl[0];
		$y = $tgl[2];
		$tgl_kegiatan = $y.'-'.$m.'-'.$d;
		return $tgl_kegiatan;
	}
	
	function tanggal($parameter){

		$array_hari = array('Sun'=>'Minggu', 'Mon'=>'Senin', 'Tue'=>'Selasa', 'Wed'=>'Rabu', 'Thu'=>'Kamis', 'Fri'=>'Jumat', 'Sat'=>'Sabtu');
		$array_bulan = array('1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni', '7'=>'Juli',
		                    '8'=>'Agustus', '9'=>'September', '10'=>'Oktober', '11'=>'Nopember', '12'=>'Desember', );

		$hari = date('D', strtotime($parameter));
		$d = date('d', strtotime($parameter));
		$m = date('n', strtotime($parameter));
		$y = date('Y', strtotime($parameter));

		$nama_hari = $array_hari[$hari];
		$tgl = $d;
		$bulan = $array_bulan[$m];
		$tahun = $y;
		$tanggal = $nama_hari.', '.$tgl.' '.$bulan.' '.$tahun;
		return $tanggal;
	}

	public function dataUser()
	{
		$this->template();
		$username = $this->session->userdata['logged_in']['username'];
		$data['script'] = $this->load->view('layout/template-2', null, true);
		$data['data'] = $this->ruangrapatmodel->getDataUser($username);
		$this->load->view('penggunaan/formDataPengguna', $data);
	}

	public function updateDataUser()
	{

		$username 		= $this->session->userdata['logged_in']['username'];
		$nama_peminjam 	= ($this->input->post('nama_peminjam')) ? $this->input->post('nama_peminjam') : '' ;
		$prodi 			= ($this->input->post('prodi')) ? $this->input->post('prodi') : '' ;
		$id_peminjam 	= ($this->input->post('id_peminjam')) ? $this->input->post('id_peminjam') : '' ;
		$no_telp 		= ($this->input->post('no_telp')) ? $this->input->post('no_telp') : '' ;
		$email 			= ($this->input->post('email')) ? $this->input->post('email') : '' ;

		//cek data user ada apa nggak
		$data_user = $this->ruangrapatmodel->getDataUser($username);
		
		if (count($data_user)==0) {  //jika user belum ada maka tambah data
			$data_add = array(
				'user_name'		=> $username,
				'nama_peminjam' => $nama_peminjam,
				'prodi'			=> $prodi,
				'id_peminjam'	=> $id_peminjam,
				'no_telp'		=> $no_telp,
				'user_email'	=> $email
			);			
			$this->ruangrapatmodel->addDataUser($data_add);
			echo 'data sudah ditambahkan';
		} else {  	//jika user sudah ada maka edit data
			$data_edit = array(
				'nama_peminjam' => $nama_peminjam,
				'prodi'			=> $prodi,
				'id_peminjam'	=> $id_peminjam,
				'no_telp'		=> $no_telp,
				'user_email'	=> $email
			);			
			$this->ruangrapatmodel->editDataUser($data_edit, $username);
			echo 'data sudah diupdate';
		}
	}

	public function kalender(){
		//scheduler's view
		$this->load->model('peminjaman/schedulerRuangRapatModel');
		$userlogin 			= ($this->session->userdata['logged_in']['username']);
		$data['foto'] 		= $this->service->getFoto($userlogin);
		$data['nama'] 		= $this->service->getNama($userlogin);
		$data['ruang'] 		= $this->ruangrapatmodel->getRuang();
		$data['menu'] 	 	= $this->load->view('layout/3_menu', $data, true);
		
		$data['ruang'] = (int) $this->uri->segment(4);

		$sql = "SELECT nm_ruang FROM ruang_rapat WHERE kd_ruang = ".$this->uri->segment(4);
		$result = mysql_query($sql) or die(mysql_error());
		while($row = mysql_fetch_assoc($result)){
			$nama_ruang = $row;
		}

		$data['nama_ruang'] = $nama_ruang['nm_ruang'];
		$data['content'] = $this->load->view('penggunaan/kalender', $data, true);
		$this->load->view('layout/template', $data);
	}

	public function kalenderPerKelas(){
		//scheduler's view
		$this->load->model('peminjaman/schedulerRuangRapatModel');		
		$userlogin 			= ($this->session->userdata['logged_in']['username']);
		$data['foto'] 		= $this->service->getFoto($userlogin);
		$data['nama'] 		= $this->service->getNama($userlogin);
		$data['ruang'] 		= $this->ruangrapatmodel->getRuang();
		$data['menu'] 	 	= $this->load->view('layout/3_menu', $data, true);
		
		$data['ruang'] 		= (int) $this->uri->segment(4);
		$sql = "SELECT nm_ruang FROM ruang_rapat WHERE kd_ruang = ".$this->uri->segment(4);
		$result = mysql_query($sql) or die(mysql_error());
		while($row = mysql_fetch_assoc($result)){
			$nama_ruang = $row;
		}
		$data['nama_ruang'] = $nama_ruang['nm_ruang'];
		$data['content'] = $this->load->view('penggunaan/kalenderPerKelas', $data, true);
		$this->load->view('layout/template', $data);
	}
	
	public function kalenderKelas(){
		//scheduler's view
		$this->load->model('peminjaman/schedulerRuangRapatModel');
		$userlogin 			= ($this->session->userdata['logged_in']['username']);
		$data['foto'] 		= $this->service->getFoto($userlogin);
		$data['nama'] 		= $this->service->getNama($userlogin);
		$data['ruang'] 		= $this->ruangrapatmodel->getRuang();
		$data['menu'] 	 	= $this->load->view('layout/3_menu', $data, true);
		$data['content'] = $this->load->view('penggunaan/kalenderKelas', $data, true);
		$this->load->view('layout/template', $data);
	}
	
	public function testDhtmlx(){
		//scheduler's view
		$this->load->model('peminjaman/schedulerRuangRapatModel');
		$data['ruang'] = (int) $this->uri->segment(4);

		$sql = "SELECT nm_ruang FROM ruang_rapat WHERE kd_ruang = ".$this->uri->segment(4);
		$result = mysql_query($sql) or die(mysql_error());
		while($row = mysql_fetch_assoc($result)){
			$nama_ruang = $row;
		}

		$data['nama_ruang'] = $nama_ruang['nm_ruang'];
		//$data['template_1'] = $this->load->view('layout/template-1', NULL, TRUE);
		//$data['template_2'] = $this->load->view('layout/template-2', NULL, TRUE);
		//$this->load->view('peminjaman/schedulerRuangRapatView', $data);
		//$data['data_dhtmlx'] = $this->load->view('peminjaman/testSchedulerRuangRapatView', $data, TRUE);
		$this->load->view('peminjaman/kalender', $data);
	}

	public function daftarRuang(){
		
		$userlogin 			= ($this->session->userdata['logged_in']['username']);
		$data['foto'] 		= $this->service->getFoto($userlogin);
		$data['nama'] 		= $this->service->getNama($userlogin);
		$data['ruang'] 		= $this->ruangrapatmodel->getRuang();
		//$data['daftar_ruang'] 	= $this->load->view('layout/menu_daftar_ruang', $data, true);
		$data['menu'] 	 	= $this->load->view('layout/3_menu', $data, true);		
		$data['content'] 	= $this->load->view('penggunaan/daftarRuang', $data, true);
		$this->load->view('layout/template', $data);

		/*
		//$this->session->userdata['logged_in']['username'] = 'x';
		$this->load->view('layout/1-head-title');
		$this->load->view('layout/2-header', $data_header);
		$data['menu'] = $this->load->view('layout/3_menu', null, true);
		$this->load->view('layout/3-menu', $data);		
		$data['script'] = $this->load->view('layout/template-2', null, true);
		$data['ruang'] = $this->ruangrapatmodel->getRuang();
		$this->load->view('penggunaan/daftarRuang', $data);
		*/
	}

	public function test(){
		$userlogin 			= ($this->session->userdata['logged_in']['username']);
		$data['foto'] 		= $this->service->getFoto($userlogin);
		$data['nama'] 		= $this->service->getNama($userlogin);		
		$data['ruang'] 		= $this->ruangrapatmodel->getRuang();
		$this->load->view('layout/1-head-title');
		$this->load->view('layout/2-header', $data);
		$data['daftar_ruang'] 	= $this->load->view('layout/menu_daftar_ruang', $data, true);
		$data['menu'] = $this->load->view('layout/3_menu', $data, true);
		$this->load->view('layout/3-menu', $data);
		
		$data['script'] = $this->load->view('layout/template-2');

		$sql = "SELECT nm_ruang FROM ruang_rapat WHERE kd_ruang = ".$this->uri->segment(4);
		$result = mysql_query($sql) or die(mysql_error());
		while($row = mysql_fetch_assoc($result)){
			$nama_ruang = $row;
		}

		$data['nama_ruang'] = $nama_ruang['nm_ruang'];

		$this->load->view('penggunaan/kalender', $data);
		$this->load->view('layout/template-2');
		/*$data['content'] 	= '';
		$this->load->view('layout/template', $data);*/
	}
	
	public function kalenderNonKelas(){
		$userlogin 			= ($this->session->userdata['logged_in']['username']);
		$data['foto'] 		= $this->service->getFoto($userlogin);
		$data['nama'] 		= $this->service->getNama($userlogin);
		$data['ruang'] 		= $this->ruangrapatmodel->getRuang();
		$data['menu'] 		= $this->load->view('layout/3_menu', $data, true);
		$data['content'] 	= $this->load->view('penggunaan/kalenderNonKelas', $data, true);
		$this->load->view('layout/template', $data);
	}
	
	public function dataUjian()
	{
		//$this->sessionUser();
		$userlogin = ($this->session->userdata['logged_in']['username']);
		$data_header['foto'] = $this->service->getFoto($userlogin);
		$data_header['nama'] = $this->service->getNama($userlogin);
		$this->load->view('layout/1-head-title');
		$this->load->view('layout/2-header', $data_header);
		$data['ruang'] 		= $this->ruangrapatmodel->getRuang();
		$data['menu'] 		= $this->load->view('layout/3_menu', $data, true);
		$this->load->view('layout/3-menu', $data);		
		$data['script'] 	= $this->load->view('layout/template-2', null, true);
		$data['data'] = $this->ruangrapatmodel->getDataUjian();
		$this->load->view('penggunaan/dataUjian', $data);
	}
}