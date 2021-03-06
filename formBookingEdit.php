<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class FormBookingEdit extends CI_Controller 
{
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('service');
		$this->load->helper('tanggal');
		$this->load->helper('formBookingEdit');
		$this->load->model('penggunaan/ruangrapatmodel');
		$this->load->model('kemahasiswaan/statuspinjammodel');
		$this->load->model('kemahasiswaan/formbookingmodel');
		$this->load->library('Ajax_pagination');
		$this->perPage = 10;
		date_default_timezone_set('Asia/Jakarta');

		//buat test doang --1--
		$this->data_header['foto'] = 'x'; //$this->service->getFoto($userlogin);
		$this->data_header['nama'] = 'mnurulamri'; //$this->service->getNama($userlogin);
		$this->session->userdata['logged_in']['username'] = 'mnurulamri';
		$this->session->userdata['logged_in']['hak_akses'] = 0;				
		$this->hak_akses = $this->session->userdata['logged_in']['hak_akses'];
		$this->userlogin = $this->session->userdata['logged_in']['username'];
		$this->username = $this->session->userdata['logged_in']['username'];
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
		$data['ruang_new'] = $this->getRuangAddRow();;

		//set ruang berdasarkan hak akses
		$hak_akses = ($this->session->userdata['logged_in']['hak_akses']);
		if($hak_akses == 1){ //ruang untuk admin
			$ruang = $this->ruangrapatmodel->getRuang();
		} else {
			$ruang = $this->ruangrapatmodel->getRuangUser(); //untuk mengeluarkan ruang F.201
		}
		$data['ruang'] 		= $ruang;
		
		$this->load->view('kemahasiswaan/formBookingEditView', $data);
	}

	public function getRuangAddRow(){
		$ruang = $this->ruangrapatmodel->getRuang();

		$html='';
		foreach ($ruang as $k => $v) {
			$html.= '<option value="'.$v->kd_ruang.'">'.$v->nm_ruang.'</option>';
		}
		return $html;		
	}	

	/*
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
	*/
	public function simpan()
	{
		//set variabel insert kegiatan
		$nomor			= $this->input->post('nomor');
		$tgl_proses		= $this->input->post('tgl_proses');
		$tgl_permohonan = $this->input->post('tgl_permohonan');
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

		//$tgl_proses 	= tanggalToDb($tgl_proses);		
		$tgl_permohonan = tanggalToDb($tgl_permohonan);
		$username = $this->session->userdata['logged_in']['username'];

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
			'flag'			=> 0,
			'tema' 			=> $tema,
			'deskripsi' 	=> $deskripsi,
			'tujuan' 		=> $tujuan,
			'pengisi_acara'	=> $pengisi_acara
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

		//edit jadwal
		$event_id		= $this->input->post('event_id');
		$ruang 			= $this->input->post('ruang');
		$_tgl_kegiatan 	= $this->input->post('tgl_kegiatan');
		$jam_awal 		= $this->input->post('jam_mulai');
		$menit_awal 	= $this->input->post('menit_mulai');
		$jam_akhir 		= $this->input->post('jam_selesai');
		$menit_akhir 	= $this->input->post('menit_selesai');

		$array = array();
		//event_id
		$event_id = explode(",", $event_id);
		$i=0;		
		foreach ($event_id as $k => $v) {
			$array[$i]['event_id'] = $v;
			$i++;
		}

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

		$i=0;
		foreach ($array as $k => $v) {

			$event_id = $v['event_id'];
			$ruang = $v['ruang'];
			$start_date = $v['tgl_kegiatan'].' '.$v['jam_awal'].':'.$v['menit_awal'];
			$end_date = $v['tgl_kegiatan'].' '.$v['jam_akhir'].':'.$v['menit_akhir'];

			/*$data_jadwal[$i] = array(
				'event_id' => $v['event_id'],
				'nomor' => $nomor,
				'ruang' => $v['ruang'],
				'start_date' => $v['tgl_kegiatan'].' '.$v['jam_awal'].':'.$v['menit_awal'],
				'end_date' => $v['tgl_kegiatan'].' '.$v['jam_akhir'].':'.$v['menit_akhir']
			);*/
			$i++;
			$sql = "REPLACE INTO waktu (event_id,ruang,nomor,start_date,end_date) VALUES('$event_id', '$ruang', '$nomor', '$start_date', '$end_date')";
			mysql_query($sql) or die(mysql_error());
		}

		$this->formbookingmodel->updateKegiatanMhs($nomor, $data_kegiatan, $data_entitas, $data_kategori, $data_jenis, $data_peserta);
		$this->upload($_FILES, $nomor);
		
		//$this->testing($data_kegiatan);
		//$this->testing($data_jadwal);
		

		//$this->editJadwal($nomor);
		//
		//$values = '';
		//foreach ($data_jadwal as $key => $value) {
			//$values[]= '('.implode(", ", $value).')'; 
		//}
		//$data = implode(',', $values);
		
		//$sql = "REPLACE INTO waktu (event_id,ruang,nomor,start_date,end_date) VALUES $data";
		//mysql_query($sql) or die(mysql_error());
		//$this->testing($data);
		

	}

	public function upload($files, $nomor)
	{       
        //kosongkan record dokumen dulu
        //$this->formbookingmodel->clear_dokumen($nomor);  //bug -> sat edit dokumen ilang semua, file dokumen masih ada

        foreach ($files as $key => $value) { 

        	if($value['name']){
	            //$config['file_name']    = $key;
	            $config['upload_path']   = './dokumen/kemahasiswaan/';
	            $config['allowed_types'] = 'gif|jpg|jpeg|png|svg|pdf';  
	            $config['max_size']		 = '50000'; // KB	

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

	public function hapusDokumen()
	{
		$nomor 		= $this->input->post('nomor');
		$field 		= $this->input->post('field');
		$nama_file 	= $this->input->post('nama_file');
		$this->formbookingmodel->hapus_dokumen($nomor, $field, $nama_file);
	}

	public function test_hapus(){
		//$path = 
		//unlink('filename');
	}

	public function testing($data){
		echo '<pre>';
		print_r($data);
		echo '</pre>';
	}
}