<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (! function_exists('cetak_jadwal_konfirmasi'))
{
	function cetak_jadwal_konfirmasi($ruang, $data_jadwal){
		
		$data ='test';
		
		foreach($data_jadwal as $k => $v)
		{
			#select dan set ruang
			$ruangan = $v['nm_ruang'];
			
			#set tanggal
			$array_tgl = explode(" ", $v['start_date']);
			$tgl = explode("-", $array_tgl[0]);
			$d = $tgl[2];
	        $m = $tgl[1];
	        $y = $tgl[0];
	
			#set hari
			$nama_hari = array( 0 => 'Minggu', '1' => 'Senin', '2' => 'Selasa', '3' => 'Rabu', '4' => 'Kamis', '5' => 'Jumat', '6' => 'Sabtu' );
			$kd_hari = date("w", mktime(0, 0, 0, $m, $d, $y));
			$hari = $nama_hari[$kd_hari];
			
			#set bulan
			$nama_bulan = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
			$bulan = $nama_bulan[$m];
	        $tanggal = $hari.', '.$d.' '.$bulan.' '.$y;
        
			#set jadwal
			$event_id = $v['event_id'];
            $tgl_kegiatan           = date('m/d/Y', strtotime($v['start_date']));    
            $waktu_awal             = date('H:i', strtotime($v['start_date']));
            $array_mulai            = explode(':', $waktu_awal);
            $_jam_mulai             = $array_mulai[0]; 
            $_menit_mulai           = $array_mulai[1];
            
            $waktu_akhir            = date('H:i', strtotime($v['end_date']));
            $array_akhir            = explode(':', $waktu_akhir);
            $_jam_akhir             = $array_akhir[0];
            $_menit_akhir           = $array_akhir[1];
            
            $data .= '                                                                        
            <tr>
				<td style="text-align:center">'.$ruangan.'</td>
				<td style="text-align:center">'.$tanggal.'</td>
				<td style="text-align:center">'.$_jam_mulai.':'.$_menit_mulai.'&nbsp;-&nbsp;'.$_jam_akhir.':'.$_menit_akhir.'</td>
			</tr>';
            
		}
		
		return $data;
	}
}