<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class StatusPersetujuan extends CI_Controller 
{
	var $hak_akses = null;
	var $userlogin = null;
	var $username = null;
	var $data_header = array();

	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('service');
		$this->load->helper('tanggal');
		$this->load->model('penggunaan/ruangrapatmodel');
		$this->load->model('kemahasiswaan/statuspinjammodel');
		$this->load->model('kemahasiswaan/formbookingmodel');
		$this->load->model('organisasi');
		$this->load->helper('formBookingEdit');
		$this->load->helper('cetakJadwal');
		$this->load->helper('dokumen');
		$this->load->library('Ajax_pagination');
		$this->perPage = 10;
		date_default_timezone_set('Asia/Jakarta');

		//buat test doang --1--
		#$this->data_header['foto'] = 'x'; //$this->service->getFoto($userlogin);
		#$this->data_header['nama'] = 'mnurulamri'; //$this->service->getNama($userlogin);
		#$this->session->userdata['logged_in']['username'] = 'mnurulamri';
		#$this->session->userdata['logged_in']['hak_akses'] = 1;
		$userlogin = ($this->session->userdata['logged_in']['username']);
		$this->data_header['foto'] = $this->service->getFoto($userlogin);
		$this->data_header['nama'] = $this->service->getNama($userlogin);
		$this->data_header['cn'] = $this->session->userdata['logged_in']['cn'];
		$this->data_header['organisasi'] = $this->organisasi->nama_organisasi($this->session->userdata['logged_in']['kode_org']);
		
		$this->hak_akses = $this->session->userdata['logged_in']['hak_akses'];
		$this->userlogin = $this->session->userdata['logged_in']['username'];
		$this->username = $this->session->userdata['logged_in']['username'];
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
		$this->load->view('kemahasiswaan/statusPersetujuanView');		
	}

    function ajaxRiwayatPinjam(){
    	$data['data_jadwal'] = $this->statuspinjammodel->getListStatusPinjam();
        $conditions = array();
        
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
        $totalRec = count($this->statuspinjammodel->getRows($conditions));
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'index.php/kemahasiswaan/statusPersetujuan/ajaxRiwayatPinjam';
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
        $data['posts'] = $this->statuspinjammodel->getRows($conditions);
        $data['offset'] = $offset;
        //load the view
        $this->load->view('kemahasiswaan/ajax-status-persetujuan-data', $data, false);
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

	public function statusKonfirmasi()
	{  //form edit pengajuan
		$nomor 			= $this->input->post('nomor');
		$data['data'] 	= $this->getDataFormPengajuan($nomor);
		//$data['data_kegiatan'] 	= $this->ruangrapatmodel->getKegiatan($nomor);
		//$data['data_jadwal'] 	= $this->ruangrapatmodel->getJadwalRuang($nomor);
		$this->load->view('penggunaan/statusKonfirmasi', $data);
		//print_r($nomor);
	}

	public function statusKonfirmasiPersetujuan(){
		$nomor = $this->input->post('nomor');
		$alasan = $this->input->post('alasan');
		$jenis_persetujuan = $this->input->post('jenis_persetujuan');

		switch ($jenis_persetujuan) {
			case 'tunda':
				$ket_status = '<span style="color:#C85EC7">Ditunda</span>';
				$status = 4;
				$flag_cetak = 0;
				break;
			case 'tolak':
				$ket_status = '<span style="color:#808000">Ditolak</span>';
				$status = 5;
				$flag_cetak = 0;
				break;
			case 'setuju':
				$ket_status = '<span style="color:#009966">Menunggu Persetujuan Wakil Manajer PPF</span>';
				$status = 1;
				$flag_cetak = 1;
				break;
			default:
				$ket_status = '???';
				break;
		}

		$tgl_approval_manajer_kemahasiswaan = date('Y-m-d h:i:s');

		$data = array(
			'nomor' => $nomor,
			'status' => $status,
			'alasan' => $alasan,
			'flag_cetak' => $flag_cetak,
			'tgl_approval_manajer_kemahasiswaan' => $tgl_approval_manajer_kemahasiswaan
		);
		$this->formbookingmodel->updateKegiatan($nomor, $data);

		$view_screen = array(
			'keterangan' => '<span style="color:#009966;font-size:11px;">'.$ket_status.'<i>'.$alasan.'</i></span>'
		);
		echo json_encode($view_screen);
		
		/*
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
		*/
	}
	
	public function getData()
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
		$this->load->view('kemahasiswaan/statusPersetujuanKonfirmasi', $data);
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
}