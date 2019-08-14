<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (! function_exists('waktuMulai'))
{
	function waktuMulai($start_time, $end_time)
	{
		if(!empty($start_time)){
			$jam_mulai = explode(':', $start_time)[0];
			$menit_mulai = explode(':', $start_time)[1];
			$jam_selesai = explode(':', $end_time)[0];
		} else {
			$jam_mulai = '08';
			$menit_mulai = '00';
		}
		
		
		$start = '<select name="jam_mulai" id="jam_mulai" class="jam_mulai">';
		for ($i=8; $i<24; $i++) {
			$retVal = (strlen($i)==1) ? '0'.$i : $i ;
			$option = ($i==$jam_mulai) ? '<option value="'.$retVal.'" selected>'.$retVal.'</option>' : '<option>'.$retVal.'</option>' ;
			$start.= $option;
		}
		$start.= '</select>';
		
		$start.= '<select name="menit_mulai" id="menit_mulai">'; //menit awal
		for ($i=0; $i<61; $i+=5) { 
			$retVal = (strlen($i)==1) ? '0'.$i : $i ;
			$option = ($i==$menit_mulai) ? '<option value="'.$retVal.'" selected>'.$retVal.'</option>' : '<option>'.$retVal.'</option>' ;
			$start.= $option;
		}
		$start.= '</select>';
		return $start;
	}
}

if (! function_exists('waktuSelesai'))
{
	function waktuSelesai($start_time, $end_time)
	{
		if(!empty($end_time)){
			$jam_akhir = explode(':', $end_time)[0];
			$menit_akhir = explode(':', $end_time)[1];
		} else {
			$jam_akhir = '09';
			$menit_akhir = '00';
		}
		
		$end = '<select name="jam_selesai" id="jam_selesai" class="jam_selesai">';
		
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
}

/* End of file MY_url_helper.php */
/* Location: ./application/helpers/MY_url_helper.php */