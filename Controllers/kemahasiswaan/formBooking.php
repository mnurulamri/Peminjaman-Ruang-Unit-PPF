<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class FormBooking extends CI_Controller 
{
	var $hak_akses = null;
	var $userlogin = null;
	var $username = null;
	var $prodi = null;
	var $data_header = array();

	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('service');
		$this->load->helper('tanggal');
		$this->load->model('penggunaan/ruangrapatmodel');
		$this->load->model('kemahasiswaan/formbookingmodel');
		$this->load->model('organisasi');
		date_default_timezone_set('Asia/Jakarta');

		error_reporting(E_ALL);
		ini_set('display_errors', 1);

		//buat test doang --1--
		$userlogin = ($this->session->userdata['logged_in']['username']);
		$this->data_header['foto'] = $this->service->getFoto($userlogin);
		$this->data_header['nama'] = $this->service->getNama($userlogin);
		#$this->session->userdata['logged_in']['username'] = 'mnurulamri';
		#$this->session->userdata['logged_in']['hak_akses'] = 0;				
		$this->hak_akses = $this->session->userdata['logged_in']['hak_akses'];
		$this->userlogin = $this->session->userdata['logged_in']['username'];
		$this->username = $this->session->userdata['logged_in']['username'];
		//$this->prodi = $this->organisasi->nama_organisasi($this->session->userdata['logged_in']['kode_org']);
	}

	public function template()
	{
		// --1--
		$data['ruang'] 		= $this->ruangrapatmodel->getRuang();
		$data['menu'] 		= $this->load->view('layout/3_menu', $data, true);		
		$data['script'] 	= $this->load->view('layout/template-2', null, true);
		
		$data['data'] 		= $this->ruangrapatmodel->getData($this->hak_akses, $this->userlogin);
		$data['data_user']	= $this->ruangrapatmodel->getDataUser($this->username);
		$this->load->view('layout/1-head-title');
		$this->load->view('layout/2-header', $this->data_header);		
		$this->load->view('layout/3-menu', $data);
	}

	public function index()
	{	
		$this->template();
		$tanggal 			= $this->today();
        $nosurat 			= $this->getToken();
		$data['tanggal']	= $tanggal;
		$data['nomor'] 		= $nosurat;
		$data['form_script'] = $this->selectRuang();
		$data['start_time']	= $this->waktuMulai();
		$data['end_time']	= $this->waktuSelesai();
		$this->load->view('kemahasiswaan/formBookingView', $data);		
	}

	public function add()
	{
		//$this->load->view('kemahasiswaan/formBookingAddView');
		echo "test";
	}

	public function selectRuang(){
		$data['vruang'] 		= $this->getFieldRuang();
		$data['today'] 		= $this->today();
		return $data['form_script'] 	= $this->load->view('kemahasiswaan/formBookingScript', $data, true);		
	}

	public function test_simpan()
	{
		echo "testing";
	}

	public function simpan()
	{
		//set variabel insert kegiatan
		$tgl_proses	= $this->input->post('tgl_proses');
		$tgl_permohonan= $this->input->post('tgl_permohonan');
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
		//tambahan
		$entitas		= $this->input->post('entitas');
		$entitas_lainnya= $this->input->post('entitas_lainnya');
		$kategori		= $this->input->post('kategori');
		$jenis			= $this->input->post('jenis');
		$jenis_lainnya 	= $this->input->post('jenis_lainnya');
		$tema 			= $this->input->post('tema');
		$deskripsi 		= $this->input->post('deskripsi');
		$tujuan 		= $this->input->post('tujuan');
		$pengisi_acara 	= $this->input->post('pengisi_acara');
		$peserta 		= $this->input->post('peserta');
		
		//update tgl 6 Sept
		$kode_org_mhs 		= $this->input->post('kode_org_mhs');
		$ketua_org_mhs 	= $this->input->post('ketua_org_mhs');
		$pejabat_dep		= $this->input->post('pejabat_dep');
		$nip		= $this->input->post('nip');

		//set tanggal
		$tgl_proses 	= tanggalToDb($tgl_proses);		
		$tgl_permohonan = tanggalToDb($tgl_permohonan);
		$username = $this->session->userdata['logged_in']['username'];

		$nomor = 'ppf'.$this->getToken();

		$data_kegiatan = array(			
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
			'status'		=> 0,
			'username' 		=> $username,
			'flag'			=> 1,
			'tema' 			=> $tema,
			'deskripsi' 	=> $deskripsi,
			'tujuan' 		=> $tujuan,
			'pengisi_acara'	=> $pengisi_acara,
			'kode_org'		=> $this->session->userdata['logged_in']['kode_org'],
			
			'kode_org_mhs' 	=> $kode_org_mhs,
			'ketua_org_mhs'	=> $ketua_org_mhs,
			'pejabat_dep'	=> $pejabat_dep,
			'nip'	=> $nip
		);

        $entitas = explode(",", $entitas);
		foreach ($entitas as $key => $value) {
			if ($value == 'lainnya') {
				$value = $entitas_lainnya;
			}
			$data_entitas[] = $value;
		}

		$kategori = explode(",", $kategori);
		foreach ($kategori as $key => $value) {
			$data_kategori[] = $value;
		}

		$jenis = explode(",", $jenis);
		foreach ($jenis as $key => $value) {
			if ($value == 'lainnya') {
				$value = $jenis_lainnya;
			}
			$data_jenis[] = $value;
		}

		$peserta = explode(",", $peserta);
		foreach ($peserta as $key => $value) {
			$data_peserta[] = $value;
		}
		$this->test_data($data_kegiatan);
		$this->editJadwal($nomor);
		//$this->formbookingmodel->insertKegiatanMhs($nomor, $data_kegiatan, $data_entitas, $data_kategori, $data_jenis, $data_peserta);
		//$this->upload($_FILES, $nomor);
		//$this->editJadwal($nomor);
		
	}

	public function upload($files, $nomor)
	{       
        foreach ($files as $key => $value) { 

        	if($value['name']){
	            //$config['file_name']    = $key;
	            $config['upload_path']   = './dokumen/kemahasiswaan/';
	            $config['allowed_types'] = 'gif|jpg|jpeg|png|svg|pdf';
	            $config['overwrite']	= true;
	            $config['max_size']		 = 500000; // KB	

	            $this->load->library('upload');
	            $this->upload->initialize($config);  
	            
	            //$this->upload->do_upload($key);

	            if($this->upload->do_upload($key)) {  
	            	$file = $this->upload->data();
	            	//proses update ke database 
	            	$data = array($key => $file['file_name']);

	            	$this->formbookingmodel->edit_dokumen($nomor, $data); 
	            } else {
	                echo "<pre>";
	                print_r($this->upload->display_errors());
	                echo "</pre>";
	            }        		
        	}            
        }
	}
/*
	public function editKegiatan(){
		//fetch input data form
		$id_kegiatan	= $this->input->post('id_kegiatan');
		$nomor 			= $this->input->post('nomor');
		$no_surat 		= $this->input->post('no_surat');
		$tgl_proses		= tanggalToDb($this->input->post('tgl_proses'));
		$tgl_permohonan = tanggalToDb($this->input->post('tgl_permohonan'));
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
*/
	public function editJadwal($nomor)
	{  //edit dari form pengajuan


		//fetch input data form
		$event_id		= $this->input->post('event_id');
		//$nomor 			= $this->input->post('nomor');
		$ruang 			= $this->input->post('ruang');
		$_tgl_kegiatan 	= $this->input->post('tgl_kegiatan');
		$jam_awal 		= $this->input->post('jam_mulai');
		$menit_awal 	= $this->input->post('menit_mulai');
		$jam_akhir 		= $this->input->post('jam_selesai');
		$menit_akhir 	= $this->input->post('menit_selesai');


		$array = array();

		$event_id = '';

		//ruang
 		$ruang = explode(",", $ruang);    
		$i=0;		
		foreach ($ruang as $k => $v) {
			$array[$i]['ruang'] = $v;
			$i++;
		}

		//tanggal kegiatan
		$temp = str_replace(', ', '|', $_tgl_kegiatan);
        $_tgl_kegiatan = explode(",", $temp);
       
		$i=0;
		foreach ($_tgl_kegiatan as $k => $v) {
			$v = str_replace('|', ', ', $v);
			$tgl_kegiatan = tanggalToDb($v);
			$array[$i]['tgl_kegiatan'] = $tgl_kegiatan;
			$array[$i]['nomor'] = $nomor;
			//$array[$i]['event_id'] = $event_id;
			$i++;
		}

		//jam mulai
		$jam_awal = explode(",", $jam_awal);
		$i=0;		
		foreach ($jam_awal as $k => $v) {
			$array[$i]['jam_awal'] = $v;
			$i++;
		}

		//jam akhir
		$jam_akhir = explode(",", $jam_akhir);
		$i=0;		
		foreach ($jam_akhir as $k => $v) {
			$array[$i]['jam_akhir'] = $v;
			$i++;
		}
		
		//menit awal
		$menit_awal = explode(",", $menit_awal);
		$i=0;
		foreach ($menit_awal as $k => $v) {
			$array[$i]['menit_awal'] = $v;
			$i++;
		}
		
		//menit selesai
		$menit_akhir = explode(",", $menit_akhir);
		$i=0;		
		foreach ($menit_akhir as $k => $v) {
			$array[$i]['menit_akhir'] = $v;
			$i++;
		}
		echo '<pre>'; print_r($array); echo '</pre>';
				//kelola input/edit data dengan mempertimbangkan jadwal yang bentrok
		//tampilkan pesan bila terjadi jadwal yang bentrok kemudian simpan data bila sudah tidak ada jadwal yang bentrok
		$array_hari = array('Sun'=>'Minggu', 'Mon'=>'Senin', 'Tue'=>'Selasa', 'Wed'=>'Rabu', 'Thu'=>'Kamis', 'Fri'=>'Jumat', 'Sat'=>'Sabtu');
		$array_bulan = array('1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni', '7'=>'Juli',
		                    '8'=>'Agustus', '9'=>'September', '10'=>'Oktober', '11'=>'Nopember', '12'=>'Desember', );
		$data_bentrok = array();
		
		$i=0;		
		foreach ($array as $k => $v) {
			//$event_id = $v['event_id'];
			$ruang = $v['ruang'];
			$start_date = $v['tgl_kegiatan'].' '.$v['jam_awal'].':'.$v['menit_awal'];
			$end_date = $v['tgl_kegiatan'].' '.$v['jam_akhir'].':'.$v['menit_akhir'];

			//$jadwal_bentrok = $this->ruangrapatmodel->jadwalBentrok($event_id, $start_date, $end_date, $ruang);
			//echo '<pre>'; print_r($jadwal_bentrok); echo '</pre>';
			echo $sql = "REPLACE INTO waktu_testing (event_id,ruang,nomor,start_date,end_date) VALUES('$event_id', '$ruang', '$nomor', '$start_date', '$end_date')";
			//mysql_query($sql) or die(mysql_error());
			echo '<div>event_id'.$nomor.' data sudah di simpan!...</div>';
			
			/*
			if ($ruang == 236 OR $ruang == 237) {
				# code...
			} else {
				$jadwal_bentrok = $this->ruangrapatmodel->jadwalBentrok($event_id, $start_date, $end_date, $ruang);
			}
			
			echo $cek = (count($jadwal_bentrok)>0) ? 'Ada yang bentrok' : 'Aman' ;

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
					//echo '<div class="well well-sm">Bentrok Dengan Kegiatan '.$event_name.', Hari '.$nama_hari.' Tanggal '.$tanggal.' Jam '.$waktu_awal.'-'.$waktu_akhir.' Ruang '.$ruang.'</div>';	
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
				//$sql = "REPLACE INTO waktu (event_id,ruang,nomor,start_date,end_date) VALUES('$event_id', '$ruang', '$nomor', '$start_date', '$end_date')";
				//mysql_query($sql) or die(mysql_error());
				//echo '<div>event_id'.$nomor.' data sudah di simpan!...</div>';
				//echo '<pre>'; print_r($sql); echo '</pre>';
			}
			*/
		}
		
		//tutup modal bila sudah tidak ada jadwal yang bentrok
		if (count($data_bentrok) == 0) {
			//echo '<script>window.location.replace("daftar-pengajuan");</script>';
		}
	}

/*
	public function formEdit()
	{  //menampilkan isian data pada edit form peminjaman
		//$nomor = $this->uri->segment(4);
		$nomor = $this->input->post('nomor');
		$data = $this->model->getDataFormEdit($nomor);
		
		$data_ruang = $this->model->getRuang();
		foreach ($data_ruang as $k => $v) {
			$select_ruang[$v->kd_ruang] = $v->nm_ruang;
		}

		//set array komponen array bulan
		$array_bulan = array('1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni', '7'=>'Juli',
		                      '8'=>'Agustus', '9'=>'September', '10'=>'Oktober', '11'=>'Nopember', '12'=>'Desember', );

		//set data variabel
		foreach ($data as $k => $v) {
			$event_id 		= $v->event_id;
			$nomor 			= $v->nomor;
			$nama_kegiatan 	= $v->event_name;
			$prodi 			= $v->prodi;
			$jml_peserta	= $v->jml_peserta;
			$ruang 			= $v->kd_ruang;
			$nama_peminjam 	= $v->nama_peminjam;
			$id_peminjam 	= $v->id_peminjam;
			$no_telp 		= $v->no_telp;
			$email 			= $v->email;

			//manipulasi tanggal permohonan
			$hari_permohonan	= $v->hari_permohonan;
			$day_permohonan		= $v->day_permohonan;
			$bulan_permohonan	= $array_bulan[$v->bulan_permohonan];
			$tahun_permohonan	= $v->tahun_permohonan;
			$tgl_permohonan		= $hari_permohonan.', '.$day_permohonan.' '.$bulan_permohonan.' '.$tahun_permohonan;			

			//manipulasi tanggal kegiatan
			$d 			 	= date('D', strtotime($v->start_date));
			$jam_mulai 	 	= date('H', strtotime($v->start_date));
			$menit_mulai 	= date('i', strtotime($v->start_date));
			$jam_selesai 	= date('H', strtotime($v->end_date));
			$menit_selesai 	= date('i', strtotime($v->end_date));
			$hari 			= $v->hari;
			$tgl 		 	= $v->tgl;
			$bulan 		 	= $array_bulan[$v->bulan];
			$tahun		 	= $v->tahun;
			$tgl_kegiatan 	= $hari.', '.$tgl.' '.$bulan.' '.$tahun;
		}			
		
		//untuk ngisi komponen field form edit
		$array = array(
			'event_id' 		=> $event_id,
			'nomor' 		=> $nomor,
			'nama_kegiatan' => $nama_kegiatan,
			'prodi' 		=> $prodi,
			'jml_peserta'	=> $jml_peserta,
			'nama_peminjam' => $nama_peminjam,
			'id_peminjam' 	=> $id_peminjam,
			'no_telp' 		=> $no_telp, 
			'email' 		=> $email, 
			'ruang' 		=> $ruang,
			'select_ruang' 	=> $select_ruang,
			'tgl_permohonan'=> $tgl_permohonan,
			'tgl_kegiatan' 	=> $tgl_kegiatan,
			'jam_mulai' 	=> $jam_mulai,
			'menit_mulai' 	=> $menit_mulai,
			'jam_selesai' 	=> $jam_selesai,
			'menit_selesai' => $menit_selesai
		);

		//print_r($array) ;
		echo json_encode($array);
	}

	public function editData()
	{
		//set variabel
		$event_id			= $this->input->post('event_id');
		$nomor				= $this->input->post('nomor');
		$tgl_permohonan 	= $this->input->post('tgl_permohonan');
		$tgl_kegiatan 		= $this->input->post('tgl_kegiatan');
		$event_name 		= $this->input->post('nama_kegiatan');
		$prodi 				= $this->input->post('prodi');
		$nama_peminjam 		= $this->input->post('nama_peminjam');
		$id_peminjam 		= $this->input->post('id_peminjam');
		$ruang 				= $this->input->post('ruang');
		$jam_mulai 			= $this->input->post('jam_mulai');
		$menit_mulai 		= $this->input->post('menit_mulai');
		$jam_selesai		= $this->input->post('jam_selesai');
		$menit_selesai 		= $this->input->post('menit_selesai');
		$no_telp 			= $this->input->post('no_telp');
		$email 				= $this->input->post('email');
		$jml_peserta 		= $this->input->post('jml_peserta');

		//set tanggal
		$tgl_kegiatan 	= tanggalToDb($tgl_kegiatan);
		$tgl_permohonan = tanggalToDb($tgl_permohonan);

		$start_date = $tgl_kegiatan.' '.$jam_mulai.":".$menit_mulai;
		$end_date = $tgl_kegiatan.' '.$jam_selesai.":".$menit_selesai;

		//cek jadwal bentrok
		$array_hari = array('Sun'=>'Minggu', 'Mon'=>'Senin', 'Tue'=>'Selasa', 'Wed'=>'Rabu', 'Thu'=>'Kamis', 'Fri'=>'Jumat', 'Sat'=>'Sabtu');
		$array_bulan = array('1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni', '7'=>'Juli',
		                    '8'=>'Agustus', '9'=>'September', '10'=>'Oktober', '11'=>'Nopember', '12'=>'Desember', );
		$jadwal_bentrok = $this->model->jadwalBentrok($event_id, $start_date, $end_date, $ruang);  //cek bentrok tapi tidak memeriksa dirinya sendiri

		
		if (count($jadwal_bentrok)>0) {			
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

				//tampilkan pesan bentrok
				$ket = '<div class="alert alert-warning">Bentrok Dengan Kegiatan '.$event_name.', Hari '.$nama_hari.' Tanggal '.$tanggal.' Jam '.$waktu_awal.'-'.$waktu_akhir.' Ruang '.$ruang.'</div>';
				$pesan = array(
					'flag' => '1',
					'pesan'=> $ket
				);
				echo json_encode($pesan);
			}
		} else {
			//prepare simpan data
			$data_kegiatan = array(		
				'event_name' => $event_name, 
				'prodi' => $prodi,
				'jml_peserta' => $jml_peserta,
				'tgl_permohonan' => $tgl_permohonan,
				'nama_peminjam' => $nama_peminjam, 
				'id_peminjam' => $id_peminjam, 
				'no_telp' => $no_telp, 
				'email' => $email, 
				'status' => 3, 
				'flag' => 1, 
				'flag_ppaa' => 1
			);

			$data_jadwal = array(
				'start_date' => $start_date, 
				'end_date' => $end_date, 
				'ruang' => $ruang
			);

			//eksekusi edit data
			$this->model->editKegiatan($data_kegiatan, $nomor);
			$this->model->editJadwal($data_jadwal, $nomor);	

			//tampilkan pesan
			$ket = '<div class="alert alert-success">Data Sudah Disimpan</div>';
			$pesan = array(
				'flag' => '2',
				'pesan'=> $ket
			);
			echo json_encode($pesan);
		}
		
	}
*/	
	public function cekJadwalBentrok()
	{

		$array_hari = array('Sun'=>'Minggu', 'Mon'=>'Senin', 'Tue'=>'Selasa', 'Wed'=>'Rabu', 'Thu'=>'Kamis', 'Fri'=>'Jumat', 'Sat'=>'Sabtu');
		$array_bulan = array('1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni', '7'=>'Juli',
		                    '8'=>'Agustus', '9'=>'September', '10'=>'Oktober', '11'=>'Nopember', '12'=>'Desember', );

		$event_id 		= $this->input->post('event_id');
		//$event_id = '0';
		$ruang 			= $this->input->post('ruang');
		$_tgl_kegiatan 	= $this->input->post('tgl_kegiatan');
		//$tgl_kegiatan 	= format_tanggal($_tgl_kegiatan);
		$jam_awal 		= $this->input->post('jam_mulai');
		$menit_awal 	= $this->input->post('menit_mulai');
		$jam_akhir 		= $this->input->post('jam_selesai');
		$menit_akhir 	= $this->input->post('menit_selesai');

		$tgl_kegiatan 	= tanggalToDb($_tgl_kegiatan);
		$start_date 	= $tgl_kegiatan.' '.$jam_awal.':'.$menit_awal;
		$end_date 		= $tgl_kegiatan.' '.$jam_akhir.':'.$menit_akhir;
		
		//echo 'ruang=' . $ruang . 'tgl_kegiatan=' . $tgl_kegiatan . ' ' . $jam_awal . ' ' . $menit_awal . ' ' . $jam_akhir . ' ' . $menit_akhir;
		//echo $start_date.' '.$end_date;
		//echo $event_id;
		//tentukan jadwal bentrok berdasarkan data yang sudah masuk sebelumnya dengan data yang baru diinput
		if ($event_id == '0') {
			$jadwal_bentrok = $this->ruangrapatmodel->cekJadwalBentrok( $start_date, $end_date, $ruang);  //untuk data baru
		} else {
			$jadwal_bentrok = $this->ruangrapatmodel->jadwalBentrok($event_id, $start_date, $end_date, $ruang);  //untuk data yang sudah ada sebelumnya
		}		
		//echo print_r($jadwal_bentrok); exit();
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
				<pre style="text-align:center; color:red">Bentrok Dengan '.$jenis_event. ' '.$event_name.'</pre>';	
			}		
		}
	}

	public function downloadExcel(){
		$this->load->helper('download');
		$filename = 'template_upload_penggunaan_ruang.xls';
		$data = file_get_contents("http://ppf.fisip.ui.ac.id/backend/assets/download/data_test.xls");
		force_download($filename, $data);
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

	public function getFieldRuang($nm_ruang='')
	{
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

	public function getRuang()
	{  //form select ruang
		$ruang = $this->ruangrapatmodel->getRuang();

		$html='<select id="ruang_+i + " name="ruang" class="ruang form-control" style="width: 100px">';
		foreach ($ruang as $k => $v) {
			$html.= '<option value="'.$v->kd_ruang.'">'.$v->nm_ruang.'</option>';
		}
		$html.='</select>';
		return $html;
	}

	/*public function tanggalToDb($tgl_kegiatan)
	{
		$bulan = array('Januari','Februari','Maret','April','Mei', 'Juni','Juli','Agustus','September','Oktober','Nopember','Desember');
		$tgl_array = explode(" ", $tgl_kegiatan);
		$d = $tgl_array[1];
		$month = array_search($tgl_array[2], $bulan)+1;
		$m = (strlen($month)==2) ? $month : '0'.$month; 
		$y = $tgl_array[3];
		$tgl = $y."-".$m."-".$d;
		$tgl_kegiatan = $tgl;
		return $tgl;
	}*/

	public function waktuMulai()
	{
		$jam_mulai = '08';
		$start = '<select name="jam_mulai" id="jam_mulai" class="jam_mulai cek-bentrok form-control">';
		for ($i=8; $i<24; $i++) {
			$retVal = (strlen($i)==1) ? '0'.$i : $i ;
			$option = ($i==$jam_mulai) ? '<option value="'.$retVal.'" selected>'.$retVal.'</option>' : '<option>'.$retVal.'</option>' ;
			$start.= $option;
		}
		$start.= '</select>';
		$menit_mulai = '00';
		$start.= '<select name="menit_mulai" id="menit_mulai" class="menit_mulai cek-bentrok form-control">'; //menit awal
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
		$end = '<select name="jam_selesai" id="jam_selesai" class="jam_selesai cek-bentrok form-control">';
		$jam_akhir = '09';
		for ($i=8; $i<24; $i++) {
			$retVal = (strlen($i)==1) ? '0'.$i : $i ;
			$option = ($i==$jam_akhir) ? '<option value="'.$retVal.'" selected>'.$retVal.'</option>' : '<option>'.$retVal.'</option>' ;
			$end.= $option;
		}
		$end.= '</select>';
		$menit_akhir = '00';
		$end.= '<select name="menit_selesai" id="menit_selesai" class="menit_selesai cek-bentrok form-control">'; //menit akhir
		for ($i=0; $i<61; $i+=5) { 
			$retVal = (strlen($i)==1) ? '0'.$i : $i ;
			$option = ($i==$menit_akhir) ? '<option value="'.$retVal.'" selected>'.$retVal.'</option>' : '<option>'.$retVal.'</option>' ;
			$end.= $option;
		}
		$end.= '</select>';
		return $end;
	}

	public function today()
	{
		//set tanggal
        $d = date('d');
        $m = date('n');
        $y = date('Y');
		//set hari
		$nama_hari = array( '1' => 'Senin', '2' => 'Selasa', '3' => 'Rabu', '4' => 'Kamis', '5' => 'Jumat', '6' => 'Sabtu' );
		$kd_hari = date("w", mktime(0, 0, 0, $m, $d, $y));
		$hari = $nama_hari[$kd_hari];
		//set bulan
		$nama_bulan = array(' ','Januari','Februari','Maret','April','Mei', 'Juni','Juli','Agustus','September','Oktober','November','Desember');
		$bulan = $nama_bulan[$m];
        $tanggal = $hari.', '.$d.' '.$bulan.' '.$y;
        return $tanggal;
	}
	
	function validasiEmail($email=NULL) {
    	return (preg_match("/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/",$email) ? "$email adalah email yang valid" : "$email adalah email yang tidak valid");
	}

    public function deleteKegiatan()
	{
		#delete data kegiatan dan jadwal
		$nomor = $this->input->post('nomor');
		$this->formbookingmodel->deleteKegiatan($nomor);
	}

	/*public function format_tanggal($_tgl_kegiatan){
		$tgl = explode('/', $_tgl_kegiatan);
		$d = $tgl[1];
		$m = $tgl[0];
		$y = $tgl[2];
		$tgl_kegiatan = $y.'-'.$m.'-'.$d;
		return $tgl_kegiatan;
	}*/
	
	public function test_data($data){
		echo '<pre>';
		print_r($data);
		echo '</pre>';
	}
}