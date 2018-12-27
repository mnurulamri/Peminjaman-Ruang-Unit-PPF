<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class FormPdf extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('penggunaan/ruangrapatmodel');
		$this->load->model('peminjaman/daftarpengajuanmodel');  //sementara buat ngetes
		$this->load->library("Pdf");
		date_default_timezone_set('Asia/Jakarta');
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

	function getDataFormPengajuan(){
		$nomor = $this->uri->segment('4');
		//$nomor = '676';
		$data_kegiatan = $this->ruangrapatmodel->getKegiatan($nomor);
		$data_jadwal = $this->ruangrapatmodel->getJadwalRuang($nomor);

		foreach ($data_kegiatan as $k => $v) {
            $id_kegiatan    = $v->id_kegiatan;
            $nomor          = $v->nomor;
			$no_surat = $v->no_surat;
            $tgl_proses 	= $this->tanggal($v->tgl_proses);
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
		}

		$i=0;
		foreach ($data_jadwal as $k => $v) {
          $ruang      = $v->ruangan;
          $tgl_kegiatan = $this->tanggal($v->start_date);
          $waktu_awal   = date('H:i', strtotime($v->start_date));
          $waktu_akhir  = date('H:i', strtotime($v->end_date));
          $waktu      = $waktu_awal.' - '.$waktu_akhir;

          //masukkan ke dalam array
          $jadwal[$i]['ruang'] 		  = $ruang;
          $jadwal[$i]['tgl_kegiatan'] = $tgl_kegiatan;
          $jadwal[$i]['waktu']    	  = $waktu;

          //counter
          $i++;
		}

		$array = array(
			'tgl_proses'	=> $tgl_proses,
			'nomor'			=> $nomor,
			'no_surat' => $no_surat,
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
			'catatan'		=> $catatan
		);

		return $array;
		//$data['kegiatan'] = $data_kegiatan;
		//$data['data'] = $array;
		//$this->load->view('penggunaan/test', $data);
	}

	function getDataRuangRapat($id){
		$data = $this->daftarpengajuanmodel->viewFormRuangRapat($id);
		
		foreach ($data as $k => $v) {
			$tgl_proses 	= $v->tgl_proses;
			$nomor 			= $v->nomor;
			$ruang 			= $v->ruang;
			$tgl_permohonan = $v->tgl_permohonan;
			$prodi 			= $v->prodi;
			$nama_peminjam 	= $v->nama_peminjam;
			$id_peminjam 	= $v->id_peminjam;
			$no_telp 		= $v->no_telp;
			$email 			= $v->email;
			$event_name 	= $v->event_name;
			$jml_peserta 	= $v->jml_peserta;
			$start_date 	= $v->start_date;
			$end_date 		= $v->end_date;
			$details 		= $v->details;
		}

		$tgl_proses 	= $this->tanggal($tgl_proses);
		$tgl_permohonan = $this->tanggal($tgl_permohonan);
		$tgl_kegiatan 	= $this->tanggal($start_date);

		$waktu_awal 	= date('H:i', strtotime($start_date));
		$waktu_akhir 	= date('H:i', strtotime($end_date));
		$waktu 			= $waktu_awal.' - '.$waktu_akhir;

		$_ruang = $this->ruangrapatmodel->namaRuangRapat($ruang);
		foreach ($_ruang as $k => $v) { $ruang = $v->nm_ruang; }

		$nomor = (empty($nomor)) ? '     ' : $nomor;

		$array = array(
			'tgl_proses'	=>$tgl_proses,
			'nomor'			=>$nomor,
			'ruang'			=>$ruang,
			'tgl_permohonan'=>$tgl_permohonan,
			'tgl_kegiatan'	=>$tgl_kegiatan,
			'prodi'			=>$prodi,
			'nama_peminjam'	=>$nama_peminjam,
			'id_peminjam'	=>$id_peminjam,
			'no_telp'		=>$no_telp,
			'email'			=>$email,
			'event_name'	=>$event_name,
			'jml_peserta'	=>$jml_peserta,
			'waktu'			=>$waktu,
			'details'		=>$details
		);
		return $array;
	}

	public function ruangRapat(){

	    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);    
	 
	    // set document information
	    $pdf->SetCreator(PDF_CREATOR);
	    $pdf->SetAuthor('Muhammad Nuurul Amri');
	    $pdf->SetTitle('Form Permohonan Pemakaian Ruangan');
	    $pdf->SetSubject('TCPDF From Permohonan');
	    $pdf->SetKeywords('TCPDF, PDF, Permohonan, Pemakaian, Ruangan');   
	 
	 	/*
	    // set default header data
	    $pdf->SetHeaderData(PDF_HEADER_LOGO, '50', 'FORMULIR PERMOHONAN PEMAKAIAN RUANGAN', 'G-05/PPF/WD SUMDAVUM', array(0,64,255), array(0,64,128));  //PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128)
	    $pdf->setFooterData(array(0,64,0), array(0,64,128)); 
	 
	    // set header and footer fonts
	    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', '13'));  //(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN)
	    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
	 	*/
	    // set default monospaced font
	    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); 
	 
	    // set margins
	    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	    
	    // remove default header/footer
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
	 
	    // set auto page breaks
	    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM); 
	 
	    // set image scale factor
	    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);  
	 
	    // set some language-dependent strings (optional)
	    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	        require_once(dirname(__FILE__).'/lang/eng.php');
	        $pdf->setLanguageArray($l);
	    }   
	 
	    // ---------------------------------------------------------    
	 
	    // set default font subsetting mode
	    $pdf->setFontSubsetting(true);   
	 
	    // Set font
	    // dejavusans is a UTF-8 Unicode font, if you only need to
	    // print standard ASCII chars, you can use core fonts like
	    // helvetica or times to reduce file size.
	    $pdf->SetFont('dejavusans', '', 8, '', true); 
	 
	    // Add a page
	    // This method has several options, check the source code documentation for more information.
	    $pdf->AddPage(); 
	 

	    //content
	    //Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=0, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')

		$id = $this->uri->segment('4');
		$data = $this->getDataFormPengajuan($id);
		//$data = $this->getDataRuangRapat($id);
	    $bulan = date('m');
	    $tahun = date('Y');

		// Image example with resizing
		// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
		$url_image = 'http://ppf.fisip.ui.ac.id/backend/assets/images/logo-fisip.png';
		$url_fisip = 'http://fisip.ui.ac.id';
		$pdf->Image($url_image, 15, 15, 50, 18, 'PNG', $url_fisip, '', false, 300, '', false, false, 1, false, false, false);	
		$pdf->SetFont('dejavusans', '', 13, '', true);
		$pdf->SetXY('75','18');
		$pdf->Cell(80, 7, 'FORMULIR PERMOHONAN PEMAKAIAN RUANGAN', 0, 1, 'L', 0, '', 0);
		$pdf->SetXY('75','23');
		$pdf->SetFont('dejavusans', '', 10, '', true);
		$pdf->Cell(80, 7, 'G-05/PPF/WD SUMDAVUM', 0, 1, 'L', 0, '', 0);
		#cetak garis paling atas
		$style = array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0,0,0));
		$pdf->Line(73, 16, 73, 32, $style);  //garis horizontal box tanda tangan
		$pdf->Ln(10);

		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('dejavusans', 'B', 8, '', true);
		if($data['no_surat']==''){
			$no_surat = '               ';
		} else{
			$no_surat = $data['no_surat'];
		}
		$pdf->Cell(100, 7, 'Nomor : '.$no_surat.' /G.05/1/UN2.F9.D4.2/RTK.00/'.$tahun, 1, 0, 'C', 1, '', 0); //$pdf->Cell(100, 7, 'Nomor : '.$no_surat.' /G.05/1/UN2.F9.D4.2/RTK.00/'.$bulan.'/'.$tahun, 1, 0, 'C', 1, '', 0);
		$pdf->SetFont('dejavusans', '', 8, '', true);
		
		if($this->session->userdata['logged_in']['hak_akses'] == 1){
			$pdf->Cell(80, 7, ' Tanggal : '.$data['tgl_proses'], 1, 1, 'L', 1, '', 0);
		} else {
			$pdf->Cell(80, 7, ' Tanggal : ', 1, 1, 'L', 1, '', 0);
		}
		
		//$pdf->Cell(180, 7, '', 1, 1, 'L', 1, '', 0);
		//$pdf->Cell(180, 7, 'Lokasi Ruangan : '.$data['ruang'], 1, 1, 'L', 1, '', 0);
		//$pdf->Ln(3);

		$pdf->SetFillColor(210,214,222);
		$pdf->SetFont('dejavusans', 'B', 8, '', true);
		$pdf->Cell(180, 7, 'Data Kegiatan', 1, 1, 'L', 1, '', 0);

		//$pdf->SetFont('dejavusans', 'I', 8, '', true);
		//$pdf->Cell(100, 7, 'Bagian Untuk Diisi Pemohon', 1, 0, 'L', 1, '', 0);
		//$pdf->Cell(100, 7, '', 1, 0, 'L', 1, '', 0);
		//$pdf->SetFont('dejavusans', '', 8, '', true);
		//$pdf->Cell(80, 7, ' Tanggal Pengajuan : '.$data['tgl_permohonan'], 1, 1, 'L', 1, '', 0);

		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('dejavusans', '', 8, '', true);
		$pdf->Cell(55, 7, 'Nama Kegiatan : ', 1, 0, 'R', 1, '', 0);
		$pdf->Cell(125, 7, ' '.$data['event_name'], 1, 1, 'L', 1, '', 0);

		$border = array(
		'L' => array('width' => 0.2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
		$pdf->Cell(55, 7, 'Lokasi dan Jadwal Pemakaian : ', $border, 0, 'R', 1, '', 0);

		//$pdf->SetFillColor(210,214,222);
		$pdf->SetFillColor(255,255,255);
		$pdf->Cell(40, 7, 'Nama Ruang', 1, 0, 'C', 1, '', 0);	
		$pdf->Cell(50, 7, 'Tanggal Pemakaian', 1, 0, 'C', 1, '', 0);
		$pdf->Cell(35, 7, 'Waktu Pemakaian', 1, 1, 'C', 1, '', 0);


		$border = array(
		'L' => array('width' => 0.2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
		$pdf->SetFillColor(255,255,255);
		//$pdf->MultiCell(55,7,'test',0,'L',1,0);
		$pdf->SetFont('dejavusans', '', 8, '', true);
		foreach($data['jadwal'] as $row) {
			
			$maxnocells = 0;
			$cellcount = 0;

			//write text first
			$startX = $pdf->GetX();
			$startY = $pdf->GetY();
			//draw cells and record maximum cellcount
			//cell height is 7 and width is 80
			// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
			$cellcount = $pdf->MultiCell(55, 5, '', 0, 'J', 0, 0, $startX, $startY+1, true, 0, false, true, 40, 'M');  //$cellcount = $pdf->MultiCell(55,7,'',0,'L',0,0);
			if ($cellcount > $maxnocells ) {$maxnocells = $cellcount;}
				$cellcount = $pdf->MultiCell(40,5,$row['ruang'],0,'C',0,0);
			if ($cellcount > $maxnocells ) {$maxnocells = $cellcount;}
				$cellcount = $pdf->MultiCell(50,5,$row['tgl_kegiatan'],0,'C',0,0);
			if ($cellcount > $maxnocells ) {$maxnocells = $cellcount;}
				$cellcount = $pdf->MultiCell(35,5,$row['waktu'],0,'C',0,0);
			if ($cellcount > $maxnocells ) {$maxnocells = $cellcount;}
				$pdf->SetXY($startX,$startY);
		 
			//now do borders and fill
			//cell height is 5 times the max number of cells
			$pdf->MultiCell(55,$maxnocells * 5,'','LR','L',0,0);
			$pdf->MultiCell(40,$maxnocells * 5,'','LR','L',0,0);
			$pdf->MultiCell(50,$maxnocells * 5,'','LR','L',0,0);
			$pdf->MultiCell(35,$maxnocells * 5,'','LR','L',0,0);
		 
			$pdf->Ln();  //psak 15 atau 20
		}

		$pdf->Cell(55, 7, 'Jumlah Peserta : ', 1, 0, 'R', 1, '', 0);
		$pdf->Cell(125, 7, ' '.$data['jml_peserta'], 1, 1, 'L', 1, '', 0);

		$pdf->Cell(55, 7, 'Kebutuhan Tambahan : ', 1, 0, 'R', 1, '', 0);
		$pdf->MultiCell(125, 7, $data['kebutuhan'], 1, 'L', 1, 1, '', '', true);		
		//$pdf->Cell(125, 7, ' '.$data['kebutuhan'], 1, 1, 'L', 1, '', 0);

		//$pdf->Ln(3);

		$pdf->SetFillColor(210,214,222);
		$pdf->SetFont('dejavusans', 'B', 8, '', true);
		$pdf->Cell(180, 7, 'Data Pemohon', 1, 1, 'L', 1, '', 0);

		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('dejavusans', '', 8, '', true);

		$pdf->Cell(55, 7, 'Tanggal Permohonan : ', 1, 0, 'R', 1, '', 0);
		$pdf->Cell(125, 7, ' '.$data['tgl_permohonan'], 1, 1, 'L', 1, '', 0);

		$pdf->Cell(55, 7, 'PAF/Dept/Prog/HM : ', 1, 0, 'R', 1, '', 0);
		$pdf->Cell(125, 7, ' '.$data['prodi'], 1, 1, 'L', 1, '', 0);

		$pdf->Cell(55, 7, 'Penanggung Jawab/Contact Person : ', 1, 0, 'R', 1, '', 0);
		$pdf->Cell(125, 7, ' '.$data['nama_peminjam'], 1, 1, 'L', 1, '', 0);

		$pdf->Cell(55, 7, 'NPM/NIP/NUP : ', 1, 0, 'R', 1, '', 0);
		$pdf->Cell(125, 7, ' '.$data['id_peminjam'], 1, 1, 'L', 1, '', 0);

		$pdf->Cell(55, 7, 'No. Telepon : ', 1, 0, 'R', 1, '', 0);
		$pdf->Cell(55, 7, ' '.$data['no_telp'], 1, 0, 'L', 1, '', 0);

		$pdf->Cell(20, 7, 'e-Mail : ', 1, 0, 'C', 1, '', 0);
		$pdf->Cell(50, 7, ' '.$data['email'], 1, 1, 'L', 1, '', 0);

		/*
		$pdf->Cell(55, 7, 'Hari dan Tanggal Pemakaian : ', 1, 0, 'R', 1, '', 0);
		$pdf->Cell(125, 7, ' '.$data['tgl_kegiatan'], 1, 1, 'L', 1, '', 0);

		$pdf->Cell(55, 7, 'Waktu Pemakaian : ', 1, 0, 'R', 1, '', 0);
		$pdf->Cell(125, 7, ' '.$data['waktu'], 1, 1, 'L', 1, '', 0);
		*/

		$pdf->SetFont('dejavusans', 'BI', 8, '', true);
		$pdf->SetFillColor(210,214,222);
		$pdf->Cell(180, 7, 'Contoh layout publikasi / kopi surat harap dilampirkan', 1, 1, 'C', 1, '', 0);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('dejavusans', '', 8, '', true);
		$border = array(
		'T' => array('width' => 0.2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)),
		'L' => array('width' => 0.2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)),
		'R' => array('width' => 0.2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
		$pdf->Cell(180, 5, 'Catatan', $border, 1, 'L', 1, '', 0);

		$border = array(
		'L' => array('width' => 0.2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)),
		'R' => array('width' => 0.2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)),
		'B' => array('width' => 0.2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
		$pdf->MultiCell(180, 5, $data['catatan'], $border, 'L', 1, 1, '', '', true); // MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
		//$pdf->Cell(180, 15, $data['catatan'], $border, 1, 'L', 0, '', 0);
		
		//$pdf->SetLineWidth(1);
		$border = array(
		'L' => array('width' => 0.2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)),
		'R' => array('width' => 0.2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
		$pdf->Cell(180, 5, '', $border, 1, 'L', 0, '', 0);

		$border = array(
		'L' => array('width' => 0.2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));	
		$pdf->MultiCell(60, 15, "\n\n     Pemohon", $border, 'L', 1, 0, '', '', true);
		
		$pdf->MultiCell(60, 15, "\n  Staf\n  Pengelolaan dan\n  Pemeliharaan\n  Fasilitas", 0, 'L', 1, 0, '', '', true);  // MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)	

		$border = array(
		'R' => array('width' => 0.2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));		
		$pdf->MultiCell(60, 15, "\n Menyetujui\n Wakil Manajer Pengelolaan\n danPemeliharaan Fasilitas", $border, 'L', 1, 1, '', '', true);
		
		$border = array(
		'R' => array('width' => 0.2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
		//$pdf->MultiCell(45, 15, "\nMengetahui\nWakil Dekan\nBidang Sumdavum", $border, 'L', 1, 1, '', '', true);

		$border = array(
		'L' => array('width' => 0.2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)),
		'R' => array('width' => 0.2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
		$pdf->Cell(180, 20, '', $border, 1, 'L', 0, '', 0); 
		
		$border = array(
		'L' => array('width' => 0.2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
		$pdf->Cell(5, 4, '', $border, 0, 'L', 0, '', 0);

		$border = array(
		'B' => array('width' => 0.2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
		$pdf->Cell(50, 4, $data['nama_peminjam'], $border, 0, 'L', 1, '', 0);  
		$pdf->Cell(8, 4, '', 0, 0, 'L', 0, '', 0);
			
		$border = array(
		'B' => array('width' => 0.2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
		$pdf->Cell(50, 4, '', $border, 0, 'L', 1, '', 0);   //nama_operator
		$pdf->Cell(8, 4, '', 0, 0, 'L', 0, '', 0);

		$border = array(
		'B' => array('width' => 0.2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
		$pdf->Cell(50, 4, 'Drs. Dadang Sudiadi, M.Si', $border, 0, 'L', 1, '', 0);
		$pdf->Cell(5, 4, '', 0, 0, 'L', 0, '', 0);

		$border = array(
		'B' => array('width' => 0.2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
		//$pdf->Cell(35, 4, 'Dr. Titi Muswati, M.Si', $border, 0, 'L', 1, '', 0);

		$border = array(
		'R' => array('width' => 0.2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));  //kolom setelah nama wakil dekan
		$pdf->Cell(4, 4, '', $border, 1, 'L', 0, '', 0);

		$border = array(
		'L' => array('width' => 0.2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)),   //baris terakhir
		'R' => array('width' => 0.2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
		$pdf->Cell(180, 10, '', $border, 1, 'L', 0, '', 0);

		#cetak garis paling bawah
		$border = array(
		'T' => array('width' => 0.2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
		$pdf->Cell(180, 0, '', $border, 1, 'L', 0, '', 0);

		/*$style = array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0,0,0));
		$pdf->Line(15, 245, 195, 245, $style);  //garis horizontal box tanda tangan*/

		$pdf->Ln(7);

		$txt = "1. Pemohon  2. Cleaning Service  3. IT  4.Teknisi  4. Satpam  6. Arsip";
		$pdf->MultiCell(45, 15, "Salinan : ", 0, 'R', 1, 0, '', '', true);
		$pdf->MultiCell(135, 15, $txt, 0, 'L', 1, 1, '', '', true);

	    // Close and output PDF document
	    // This method has several options, check the source code documentation for more information.
	    $pdf->Output('form Permohonan.pdf', 'D');    
	 
	    //============================================================+
	    // END OF FILE
	    //============================================================+	}
	}

	public function test(){
		$this->load->view('peminjaman/formPdfRuangRapatView');
	}
}