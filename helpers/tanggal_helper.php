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

/* End of file MY_url_helper.php */
/* Location: ./application/helpers/MY_url_helper.php */
