<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (! function_exists('tanggalToDb'))
{
	function tanggalToDb($tgl_kegiatan)
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
	}
}

if (! function_exists('format_tanggal'))
{
	function format_tanggal($_tgl_kegiatan){
		$tgl = explode('/', $_tgl_kegiatan);
		$d = $tgl[1];
		$m = $tgl[0];
		$y = $tgl[2];
		$tgl_kegiatan = $y.'-'.$m.'-'.$d;
		return $tgl_kegiatan;
	}
}

if (! function_exists('today'))
{
	function today()
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
}

if (! function_exists('dbToTanggal'))
{
	function dbToTanggal($tanggal)
	{
		$array = explode('-', $tanggal);
		//set tanggal
        $d = $array[2];
        $m = $array[1];
        $y = $array[0];
		//set hari
		$nama_hari = array( '1' => 'Senin', '2' => 'Selasa', '3' => 'Rabu', '4' => 'Kamis', '5' => 'Jumat', '6' => 'Sabtu' );
		$kd_hari = date("w", mktime(0, 0, 0, $m, $d, $y));
		$hari = $nama_hari[$kd_hari];
		//set bulan
		$nama_bulan = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
		$bulan = $nama_bulan[$m];
        $tanggal = $hari.', '.$d.' '.$bulan.' '.$y;
        return $tanggal;
	}	
}
/* End of file MY_url_helper.php */
/* Location: ./application/helpers/MY_url_helper.php */