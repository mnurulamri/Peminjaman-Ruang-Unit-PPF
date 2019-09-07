<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RiwayatPinjamMhs extends CI_Controller 
{
	var $hak_akses = null;
	var $userlogin = null;
	var $username = null;
	var $data_header = array();
	
	var $kode_org = null;
	var $nama_prodi = null;
	var $nama_dep = null;

	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('service');
		$this->load->helper('tanggal');
		$this->load->helper('formBookingEdit');
		$this->load->helper('cetakJadwal');
		$this->load->model('penggunaan/ruangrapatmodel');
		$this->load->model('kemahasiswaan/formbookingmodel');
		$this->load->model('kemahasiswaan/statuspinjammodel');
		$this->load->model('organisasi');
		$this->load->library('Ajax_pagination');
		$this->perPage = 10;
		date_default_timezone_set('Asia/Jakarta');

		$userlogin = ($this->session->userdata['logged_in']['username']);
		$this->data_header['foto'] = $this->service->getFoto($userlogin);
		$this->data_header['nama'] = $this->service->getNama($userlogin);
		
		$this->data_header['cn'] = $this->session->userdata['logged_in']['cn'];
		$this->data_header['organisasi'] = $this->organisasi->nama_organisasi($this->session->userdata['logged_in']['kode_org']);
		
		//buat test doang --1--
		#$this->session->userdata['logged_in']['hak_akses'] =0;	
		#$this->data_header['foto'] = 'x'; //$this->service->getFoto($userlogin);
		#$this->data_header['nama'] = 'mnurulamri'; //$this->service->getNama($userlogin);
		#$this->session->userdata['logged_in']['username'] = 'mnurulamri';
		#$this->session->userdata['logged_in']['hak_akses'] =0;
		
		$this->data_header['cn'] = $this->session->userdata['logged_in']['cn'];
		$this->data_header['organisasi'] = $this->organisasi->nama_organisasi($this->session->userdata['logged_in']['kode_org']);
		
		$this->hak_akses = $this->session->userdata['logged_in']['hak_akses'];
		$this->userlogin = $this->session->userdata['logged_in']['username'];
		$this->username = $this->session->userdata['logged_in']['username'];
		
		$this->kode_org = $this->session->userdata['logged_in']['kode_org'];
		$this->nama_dep = $this->organisasi->nama_dep($this->kode_org);
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
		
		//update tgl 6 Sept
		$kd_dep = substr($this->kode_org, 3, 2);
		$data_org = $this->formbookingmodel->getPejabatDepartemen($kd_dep);
		$data['data_org'] = $data_org;
		$data['nama_dep'] = $this->nama_dep;
		
		$this->load->view('kemahasiswaan/riwayatView', $data);		
	}

	public function selectRuang(){
		$data['vruang'] 		= $this->getFieldRuang();
		$data['today'] 		= $this->today();
		return $data['form_script'] 	= $this->load->view('kemahasiswaan/formBookingScript', $data, true);		
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
		$nama_hari = array( 0=>'Minggu', 1 => 'Senin', '2' => 'Selasa', '3' => 'Rabu', '4' => 'Kamis', '5' => 'Jumat', '6' => 'Sabtu' );
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

	/*public function format_tanggal($_tgl_kegiatan){
		$tgl = explode('/', $_tgl_kegiatan);
		$d = $tgl[1];
		$m = $tgl[0];
		$y = $tgl[2];
		$tgl_kegiatan = $y.'-'.$m.'-'.$d;
		return $tgl_kegiatan;
	}*/
	
	public function riwayatPinjam(){        
        //load the view
        $userlogin = ($this->session->userdata['logged_in']['username']);
		$data_header['foto'] = $this->service->getFoto($userlogin);
		$data_header['nama'] = $this->service->getNama($userlogin);
		$data['ruang'] 		= $this->statuspinjammodel->getRuang();
		$data['menu'] 		= $this->load->view('layout/3_menu', $data, true);		
		$data['script'] 	= $this->load->view('layout/template-2', null, true);
		$data['data'] 		= $this->statuspinjammodel->getRowsTest();
		//$data['data_jadwal'] 		= $this->statuspinjammodel->getJadwal();
		$this->load->view('layout/1-head-title');
		$this->load->view('layout/2-header', $data_header);		
		$this->load->view('layout/3-menu', $data);
        $this->load->view('kemahasiswaan/ajax-riwayat-pinjam-index', $data);
	}

    function ajaxRiwayatPinjam(){
    	$data['data_jadwal'] = $this->statuspinjammodel->getJadwal($this->username);
        $conditions = array();
        $conditions['username'] = $this->username;
        
        //calc offset number
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        
        //set conditions for search
        $keywords = $this->input->post('keywords');
        $sortBy = $this->input->post('sortBy');
        if(!empty($keywords)){
            $conditions['search']['keywords'] = $keywords;
        }
        if(!empty($sortBy)){
            $conditions['search']['sortBy'] = $sortBy;
        }
        
        //total rows count
        $totalRec = count($this->statuspinjammodel->getRowsTest($conditions));
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'index.php/kemahasiswaan/RiwayatPinjamMhs/ajaxRiwayatPinjam';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['uri_segment']   = 4;

		// Bootstrap Stylings
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = '<i class="glyphicon glyphicon-step-backward"></i>';
		$config['last_link'] = '<i class="glyphicon glyphicon-step-forward"></i>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '<i class="glyphicon glyphicon-triangle-left"></i>';
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '<i class="glyphicon glyphicon-triangle-right"></i>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        
        //get posts data
        $data['posts'] = $this->statuspinjammodel->getRowsTest($conditions);
        $data['offset'] = $offset;
        //load the view
        $this->load->view('kemahasiswaan/ajax-riwayat-pinjam-data', $data, false);
    }

    function viewDokumen(){
    	$data['ext_file'] = $this->input->post('ext_file');
    	$data['nama_file'] = $this->input->post('nama_file');
    	$this->load->view('kemahasiswaan/viewDokumen', $data);
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

	public function konfirmasiCetak()
	{  //form edit pengajuan
		//$nomor 			= $this->uri->segment[4];
		$nomor 			= $this->input->post('nomor');
		$username			= $this->input->post('username');
		$data['username'] 			= $username;
		$data['data'] 	= $this->getDataFormPengajuan($nomor);
		$this->load->view('kemahasiswaan/konfirmasiCetak', $data);
		//print_r($nomor);print_r($username);
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

          //masukkan ke dalam array
          $jadwal[$i]['ruang'] 		  = $ruang;
          $jadwal[$i]['tgl_kegiatan'] = $tgl_kegiatan;
          $jadwal[$i]['waktu']    	  = $waktu;

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
	/*
	public function getDataKonfirmasi()
	{  
		//menampilkan isian data pada edit form peminjaman
		$nomor = $this->input->post('nomor');
		
		$data['data_kegiatan'] = $this->formbookingmodel->getDataKegiatan($nomor);
		$data['data_kegiatan_entitas'] = $this->formbookingmodel->getDataKegiatanEntitas($nomor);
		$data['data_kegiatan_jenis'] = $this->formbookingmodel->getDataKegiatanJenis($nomor);
		$data['data_kegiatan_kategori'] = $this->formbookingmodel->getDataKegiatanKategori($nomor);
		$data['data_kegiatan_peserta'] = $this->formbookingmodel->getDataKegiatanPeserta($nomor);
		$data['data_jadwal'] = $this->formbookingmodel->getDataJadwal($nomor);
		$ruang = $this->ruangrapatmodel->getRuang();
		$data['ruang'] 		= $ruang;
		//echo '<pre>'; print_r($data); echo '</pre>';
		$this->load->view('kemahasiswaan/statusPersetujuanKonfirmasi', $data);
	}
	*/
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
}