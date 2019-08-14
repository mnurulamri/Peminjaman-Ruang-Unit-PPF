<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (! function_exists('checkbox_entitas'))
{
	function checkbox_entitas($data_kegiatan_entitas){
		if(!empty($data_kegiatan_entitas)) {
			//buat array data entitas, untuk looping pencetakan
			$array_entitas = array(
				1 => 'Individu', 2 => 'Lembaga', 3=>'Instansi/Lembaga Eksternal'
			);

			//yang ada data checkboxnya, tandain checked
			foreach ($data_kegiatan_entitas as $k => $v) {
				$array_checkbox[$v['entitas']] = 'checked';
			}

			//buat variabel data_checkbox untuk menampung data hasil mana yg di check dan mana yg tidak dicheck 
			$data_checkbox = '';
			$html = '';
		    foreach ($array_entitas as $key => $value) {
		        if (!empty($array_checkbox[$value])) {
		        	//kalo dalam array check box ada datanya maka buat inputan checkbox yang sudah ditandain
		            $data_checkbox.= '
		            
		                <label>            
		                <span style="font-family: wingdings; font-size: 125%; ">&#9745;</span>'.$value.'
		                </label>
		            ';
		        } else {
		        	//buat inputan checkbox lainnya yg blm ditandain untuk semua data yg tidak ada dalam array checkbox
		            $data_checkbox.= '
		            
		                <label>              
		                    <span style="font-family: wingdings; font-size: 125%;">&#9744;</span>'.$value.'
		                </label>
		            ';
		        }

		        //buat checkbox khusus untuk isian checkbox lainnya
		        foreach ($data_kegiatan_entitas as $k => $v) {
		            if( $v['entitas'] != 'Individu' AND $v['entitas'] != 'Lembaga' AND $v['entitas'] != 'Instansi/Lembaga Eksternal'){
		                $lainnya = '
		                
		                    <label>
		                        <span style="font-family: wingdings; font-size: 150%; font-weight: bold;">&#9745;</span>
		                        <input type="text" id="edit_entitas-lainnya" name="edit_entitas-lainnya" placeholder="Lainnya" class="form-control input-md" value="'.$v['entitas'].'">'.$v['entitas'].'
		                    </label>
		                ';
		            } else {
		                $lainnya = '
		                
		                    <label>                
		                        <span style="font-family: wingdings; font-size: 150%; font-weight: bold;">&#9744;</span>
		                        <input type="text" id="edit_entitas-lainnya" name="edit_entitas-lainnya" placeholder="Lainnya" class="form-control input-md" value="">
		                    </label>
		                ';
		            }
		        }        
		    }
		    $html = $data_checkbox.$lainnya;
		} else {
			#jika belum ada sama sekali data identitas kegiatannya, cetak blanko kosong isian identitas kegiatan

			$html = '';

			$array_entitas = array(
				1 => 'Individu', 2 => 'Lembaga', 3=>'Instansi/Lembaga Eksternal'
			);

			foreach ($array_entitas as $key => $value) {
				$html .= '
	                
	                    <label>
	                        <span style="font-family: wingdings; font-size: 150%; font-weight: bold;">&#9744;</span> '. $value.'
	                    </label>
	                ';
			}
			$html .= '
	                
	                    <label>
	                        <span style="font-family: wingdings; font-size: 150%; font-weight: bold;">&#9744;</span>
	                        <input type="text" id="edit_entitas-lainnya" name="edit_entitas-lainnya" placeholder="Lainnya" class="form-control input-md" value="">
	                    </label>
	                ';
		}
		return $html;
	}	
}

if (! function_exists('checkbox_kategori'))
{
	function checkbox_kategori($data){
		if(!empty($data)){
			//buat array data kategori, untuk looping pencetakan
			$array_kategori = array(
				1=>'Penalaran', 2=>'Seni dan Budaya', 3=>'Olahraga'
			);

			//yang ada data checkboxnya, tandain checked
			foreach ($data as $k => $v) {
				$array_checkbox[$v['kategori']] = 'checked';
			}

			//buat variabel data_checkbox untuk menampung data hasil mana yg di check dan mana yg tidak dicheck 
			$data_checkbox = '';
		    foreach ($array_kategori as $key => $value) {
		        if (!empty($array_checkbox[$value])){
		        	//kalo dalam array check box ada datanya maka buat inputan checkbox yang sudah ditandain
		            $data_checkbox.= '
		            
		                <label>            
		                <span style="font-family: wingdings; font-size: 150%; font-weight: bold;">&#9745;</span>'.$value.'
		                </label>
		            ';
		        } else {
		        	//buat inputan checkbox lainnya yg blm ditandain untuk semua data yg tidak ada dalam array checkbox
		            $data_checkbox.= '
		            
		                <label>              
		                    <span style="font-family: wingdings; font-size: 150%; font-weight: bold;">&#9744;</span>'.$value.'
		                </label>
		            ';
		        }   
		    }
		    $html = $data_checkbox;
		} else {
			#jika belum ada sama sekali data kategori kegiatannya, cetak blanko kosong isian kategori kegiatan
			$html = '';

			$array_kategori = array(
				1=>'Penalaran', 2=>'Seni dan Budaya', 3=>'Olahraga'
			);

			foreach ($array_kategori as $key => $value) {
				$html .= '
	                
	                    <label>
	                        <input type="checkbox" name="edit_kategori" class="edit_kategori" value="'.$value.'" > '. $value.'
	                    </label>
	                ';
			}
			$html .= '
	                
	                    <label>
	                        <input type="checkbox" name="edit_kategori" class="edit_kategori" value="lainnya" >
	                        <input type="text" id="kategori-lainnya" name="edit_kategori-lainnya" placeholder="Lainnya" class="form-control input-md" value="">
	                    </label>
	                ';
		}

		return $html;
	}
}

if (! function_exists('checkbox_jenis'))
{
	function checkbox_jenis($data){
		if ($data) {
			//buat array data jenis, untuk looping pencetakan
			$array_jenis = array(
				1 => 'Rapat', 2 => 'Seminar', 3=>'Pementasan Seni', 4=>'Pertandingan Olahraga', 5=>'Instalasi/Pemasangan Alat Peraga'
			);

			//yang ada data checkboxnya, tandain checked
			foreach ($data as $k => $v) {
				$array_checkbox[$v['jenis']] = 'checked';
			}

			//buat variabel data_checkbox untuk menampung data hasil mana yg di check dan mana yg tidak dicheck 
			$data_checkbox = '';
		    foreach ($array_jenis as $key => $value) {
		        if (!empty($array_checkbox[$value])){
		        	//kalo dalam array check box ada datanya maka buat inputan checkbox yang sudah ditandain
		            $data_checkbox.= '
		            
		                <label>            
		                <span style="font-family: wingdings; font-size: 150%; font-weight: bold;">&#9745;</span>'.$value.'
		                </label>
		            ';
		        } else {
		        	//buat inputan checkbox lainnya yg blm ditandain untuk semua data yg tidak ada dalam array checkbox
		            $data_checkbox.= '
		            
		                <label>              
		                    <span style="font-family: wingdings; font-size: 150%; font-weight: bold;">&#9744;</span>'.$value.'
		                </label>
		            ';
		        }

		        //buat checkbox khusus untuk isian checkbox lainnya
		        foreach ($data as $k => $v) {
		            if( $v['jenis'] != 'Rapat' AND $v['jenis'] != 'Seminar' AND $v['jenis'] != 'Pementasan Seni' AND $v['jenis'] != 'Pertandingan Olahraga' AND $v['jenis'] != 'Instalasi/Pemasangan Alat Peraga'){
		                $lainnya = '
		                <div class="checkbox">
		                    <label>
		                        <span style="font-family: wingdings; font-size: 150%; font-weight: bold;">&#9745;</span>
		                        <input type="text" id="edit_jenis-lainnya" name="edit_jenis-lainnya" placeholder="Lainnya" class="form-control input-md" value="'.$v['jenis'].'">
		                    </label>
		                </div>';
		            } else {
		                $lainnya = '
		               
		                    <label>                
		                        <span style="font-family: wingdings; font-size: 150%; font-weight: bold;">&#9744;</span>
		                        <input type="text" id="edit_jenis-lainnya" name="edit_jenis-lainnya" placeholder="Lainnya" class="form-control input-md" value="">
		                    </label>
		                ';
		            }
		        }    
		    }
			$html = $data_checkbox.$lainnya;
		} else {
			#jika belum ada sama sekali data jenis kegiatannya, cetak blanko kosong isian jenis kegiatan
			$html = '';

			$array_jenis = array(
				1 => 'Rapat', 2 => 'Seminar', 3=>'Pementasan Seni', 4=>'Pertandingan Olahraga', 5=>'Instalasi/Pemasangan Alat Peraga'
			);

			foreach ($array_jenis as $key => $value) {
				$html .= '
	                
	                    <label>
	                        <span style="font-family: wingdings; font-size: 150%; font-weight: bold;">&#9744;</span> '. $value.'
	                    </label>
	                ';
			}
			$html .= '
	                <div class="checkbox">
	                    <label>
	                        <span style="font-family: wingdings; font-size: 150%; font-weight: bold;">&#9744;</span>
	                        <input type="text" id="jenis-lainnya" name="edit_jenis-lainnya" placeholder="Lainnya" class="form-control input-md" value="">
	                    </label>
	                </div>';
		}		
		return $html;
	}
}

if (! function_exists('checkbox_peserta'))
{
	function checkbox_peserta($data){
		if ($data) {
			//buat array data jenis, untuk looping pencetakan
			$array_peserta = array(
				1=>'Internal FISIP UI', 2=>'Internal FISIP UI dan Universitas Indonesia', 3=>'Umum'
			);

			//yang ada data checkboxnya, tandain checked
			foreach ($data as $k => $v) {
				$array_checkbox[$v['peserta']] = 'checked';
			}

			//buat variabel data_checkbox untuk menampung data hasil mana yg di check dan mana yg tidak dicheck 
			$data_checkbox = '';
		    foreach ($array_peserta as $key => $value) {
		        if (!empty($array_checkbox[$value])){
		        	//kalo dalam array check box ada datanya maka buat inputan checkbox yang sudah ditandain
		            $data_checkbox.= '
		            <div class="checkbox">
		                <label>            
		                <span style="font-family: wingdings; font-size: 150%; font-weight: bold;">&#9745;</span>'.$value.'
		                </label>
		            </div>';
		        } else {
		        	//buat inputan checkbox lainnya yg blm ditandain untuk semua data yg tidak ada dalam array checkbox
		            $data_checkbox.= '
		            <div class="checkbox">
		                <label>              
		                    <span style="font-family: wingdings; font-size: 150%; font-weight: bold;">&#9744;</span>'.$value.'
		                </label>
		            </div>';
		        }

		        //buat checkbox khusus untuk isian checkbox lainnya
		        foreach ($data as $k => $v) {
		            if( $v['peserta'] != 'Internal FISIP UI' AND $v['peserta'] != 'Internal FISIP UI dan Universitas Indonesia' AND $v['peserta'] != 'Umum'){
		                $lainnya = '
		                <div class="checkbox">
		                    <label>
		                        <span style="font-family: wingdings; font-size: 150%; font-weight: bold;">&#9745;</span>
		                        <input type="text" id="edit_peserta-lainnya" name="edit_peserta-lainnya" placeholder="Lainnya" class="form-control input-md" value="'.$v['jpesertanis'].'">
		                    </label>
		                </div>';
		            } else {
		                $lainnya = '
		                <div class="checkbox">
		                    <label>                
		                        <span style="font-family: wingdings; font-size: 150%; font-weight: bold;">&#9744;</span>
		                        <input type="text" id="edit_peserta-lainnya" name="edit_peserta-lainnya" placeholder="Lainnya" class="form-control input-md" value="">
		                    </label>
		                </div>';
		            }
		        }   
		    }
			$html = $data_checkbox;
		} else {
			#jika belum ada sama sekali data jenis kegiatannya, cetak blanko kosong isian jenis kegiatan
			$html = '';

			$array_peserta = array(
				1=>'Internal FISIP UI', 2=>'Internal FISIP UI dan Universitas Indonesia', 3=>'Umum'
			);

			foreach ($array_peserta as $key => $value) {
				$html .= '
	                <div class="checkbox">
	                    <label>
	                        <span style="font-family: wingdings; font-size: 150%; font-weight: bold;">&#9744;</span> '. $value.'
	                    </label>
	                </div>';
			}
			/*
			$html .= '
	                <div class="checkbox">
	                    <label>
	                        <input type="checkbox" name="edit_peserta" class="edit_peserta" value="lainnya" >
	                        <input type="text" id="edit_peserta-lainnya" name="edit_peserta-lainnya" placeholder="Lainnya" class="form-control input-md" value="">
	                    </label>
	                </div>';
	        */
		}		
		return $html;
	}

	if (! function_exists('checkbox_peserta'))
	{
		function data_kegiatan($data){
			foreach ($data as $k => $v) {
			    $nomor          = $v['nomor'];
			    $nama_peminjam  = $v['nama_peminjam'];
			    $id_peminjam    = $v['id_peminjam'];
			    $prodi          = $v['prodi'];
			    $tgl_permohonan = $v['tgl_permohonan'];
			    $tgl_proses 	= $v['tgl_proses'];
			    $catatan        = $v['catatan'];
			    $details        = $v['details'];
			    $jml_peserta    = $v['jml_peserta'];
			    $no_telp        = $v['no_telp'];
			    $email          = $v['email'];
			}
		}
	}
}

if (! function_exists('cetak_ruang')) //buat ngetes aja
{
	function cetak_ruang($ruang){
		#select dan set ruang
		$nm_ruang = 'E.E303';
		$html='<select id="ruang" name="ruang" class="cek-bentrok-1 ruang form-control" style="width: 100px">';
		$opt = '';
		foreach($ruang as $key => $value){
			//$opt .= $v['nm_ruang'];
			//$opt .= $v->nm_ruang;
			if($value->nm_ruang == $nm_ruang){
                $html.= '<option value="'.$value->kd_ruang.'" selected >'.$value->nm_ruang.'</option>'; 
            } else {
                $html.= '<option value="'.$value->kd_ruang.'">'.$value->nm_ruang.'</option>';
            }       
		}
		$html.='</select>';
		return $html;
	}
}

if (! function_exists('cetak_jadwal'))
{
	function cetak_jadwal($ruang, $data_jadwal){
		
		$data ='test';
		
		foreach($data_jadwal as $k => $v)
		{
			#select dan set ruang
			$nm_ruang = $v['nm_ruang'];
			$ruangan='<select id="edit_ruang" name="edit_ruang" class="edit_ruang form-control" style="width: 100px; font-size:12px">';
			$opt = '';
			
			foreach($ruang as $key => $value){
				if($value->nm_ruang == $nm_ruang){
	                $ruangan.= '<option value="'.$value->kd_ruang.'" selected >'.$value->nm_ruang.'</option>'; 
	            } else {
	                $ruangan.= '<option value="'.$value->kd_ruang.'">'.$value->nm_ruang.'</option>';
	            }       
			}
			$ruangan.='</select>';
			
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
			$tanggal = '<input id="edit_tgl_kegiatan" name="edit_tgl_kegiatan" class="edit_tgl_kegiatan form-control" value="'.$tanggal.'" size="20" style="font-size:12px"/>';
        
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
            
            //tampilkan select option beserta waktu awal dan akhirnya
            $mulai_jam= '<select name="edit_jam_mulai" id="edit_jam_mulai" class="edit_jam_mulai form-control" style="font-size:12px">';   //jam awal
            $jam_mulai = $_jam_mulai;
            for ($i=8; $i<24; $i++) {
                $retVal = (strlen($i)==1) ? '0'.$i : $i ;
                $option = ($i==$jam_mulai) ? '<option value="'.$retVal.'" selected>'.$retVal.'</option>' : '<option>'.$retVal.'</option>' ;
                $mulai_jam.= $option;
            }
            $mulai_jam.= '</select>';
            $menit_mulai = $_menit_mulai;
            $mulai_menit = '<select name="edit_menit_mulai" id="edit_menit_mulai" class="edit_menit_mulai form-control" style="font-size:12px">'; //menit awal
            for ($i=0; $i<61; $i+=5) { 
                $retVal = (strlen($i)==1) ? '0'.$i : $i ;
                $option = ($i==$menit_mulai) ? '<option value="'.$retVal.'" selected>'.$retVal.'</option>' : '<option>'.$retVal.'</option>' ;
                $mulai_menit.= $option;
            }
            $mulai_menit.= '</select>';

            $selesai_jam= '<select name="edit_jam_selesai" id="edit_jam_selesai" class="edit_jam_selesai form-control" style="font-size:12px">';   //jam akhir
            $jam_akhir = $_jam_akhir;
            for ($i=8; $i<24; $i++) {
                $retVal = (strlen($i)==1) ? '0'.$i : $i ;
                $option = ($i==$jam_akhir) ? '<option value="'.$retVal.'" selected>'.$retVal.'</option>' : '<option>'.$retVal.'</option>' ;
                $selesai_jam.= $option;
            }
            $selesai_jam.= '</select>';
            $menit_akhir = $_menit_akhir;
            $selesai_menit = '<select name="edit_menit_selesai" id="edit_menit_selesai" class="edit_menit_selesai form-control" style="font-size:12px">'; //menit akhir
            for ($i=0; $i<61; $i+=5) { 
                $retVal = (strlen($i)==1) ? '0'.$i : $i ;
                $option = ($i==$menit_akhir) ? '<option value="'.$retVal.'" selected>'.$retVal.'</option>' : '<option>'.$retVal.'</option>' ;
                $selesai_menit.= $option;
            }
            $selesai_menit.= '</select>';
            
            $data .= '                                                                        
            <tr id="row_'.$event_id.'" class="form-inline cek-bentrok">
				<td><input type="hidden" id="edit_event_id" name="edit_event_id" class="edit_event_id" value="'.$event_id.'"></td>
				
				<td>'.$ruangan.'</td>
				<td>'.$tanggal.'</td>
				<td>&nbsp;</td>
				<td>'.$mulai_jam.'</td>
				<td>'.$mulai_menit.'</td>
				<td>&nbsp;</td>
				<td>'.$selesai_jam.'</td>
				<td>'.$selesai_menit.'</td>
				<td style="padding-left:5px">
                    <button id="del_'.$event_id.'" class="del btn-xs btn btn-danger">Delete</button>
                </td>
			</tr>';
            
		}
		
		return $data;
	}
}
/* End of file MY_url_helper.php */
/* Location: ./application/helpers/MY_url_helper.php */