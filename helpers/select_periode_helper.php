<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (! function_exists('optBulan'))
{
	function optBulan()
	{
		$array_bulan = array(
			'Januari','Februari','Maret','April','Mei', 'Juni','Juli','Agustus','September','Oktober','November','Desember'
		);
		$array_bulan2 = array(
			'01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'
		);

		$m = date('n')-1;
		$day = date('d');
		$bulan = $array_bulan[ $m-1 ];
		$opt_bulan = '';
		foreach($array_bulan as $k => $v){
			$selected = ($v == $bulan) ? 'selected' : '' ;
			$opt_bulan .= '<option value="'.$v.'" '.$selected.'>'.$v.'</option>';
		}
		return $opt_bulan;
	}
}

if (! function_exists('optTahun'))
{
	function optTahun()
	{
		$tahun = date('Y');
		$tahun_1 = date('Y')-1;
		$tahun_2 = date('Y')+1;

		$opt_tahun = '';
		for($i=$tahun_1; $i <= $tahun_2; $i++ ){
			$selected = ($i == $tahun) ? 'selected' : '' ;
			$opt_tahun .= '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
		}
		return $opt_tahun;
	}
}

/* End of file MY_url_helper.php */
/* Location: ./application/helpers/MY_url_helper.php */