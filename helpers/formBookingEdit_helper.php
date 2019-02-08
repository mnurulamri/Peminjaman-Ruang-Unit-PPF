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
		            <div class="checkbox">
		                <label>            
		                <input type="checkbox" name="edit_entitas" class="entitas" value="'.$value.'" '.$array_checkbox[$value].'>'.$value.'
		                </label>
		            </div>';
		        } else {
		        	//buat inputan checkbox lainnya yg blm ditandain untuk semua data yg tidak ada dalam array checkbox
		            $data_checkbox.= '
		            <div class="checkbox">
		                <label>              
		                    <input type="checkbox" name="edit_entitas" class="entitas" value="'.$value.'" >'.$value.'
		                </label>
		            </div>';
		        }

		        //buat checkbox khusus untuk isian checkbox lainnya
		        foreach ($data_kegiatan_entitas as $k => $v) {
		            if( $v['entitas'] != 'individu' AND $v['entitas'] != 'lembaga' AND $v['entitas'] != 'instansi'){
		                $lainnya = '
		                <div class="checkbox">
		                    <label>
		                        <input type="checkbox" name="edit_entitas" class="entitas" value="'.$value.'" checked>
		                        <input type="text" id="edit_entitas-lainnya" name="edit_entitas-lainnya" placeholder="Lainnya" class="form-control input-md" value="'.$v['entitas'].'">
		                    </label>
		                </div>';
		            } else {
		                $lainnya = '
		                <div class="checkbox">
		                    <label>                
		                        <input type="checkbox" name="entitas" class="entitas" value="lainnya" >
		                        <input type="text" id="edit_entitas-lainnya" name="edit_entitas-lainnya" placeholder="Lainnya" class="form-control input-md" value="">
		                    </label>
		                </div>';
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
	                <div class="checkbox">
	                    <label>
	                        <input type="checkbox" name="edit_entitas" class="entitas" value="'.$value.'" > '. $value.'
	                    </label>
	                </div>';
			}
			$html .= '
	                <div class="checkbox">
	                    <label>
	                        <input type="checkbox" name="edit_entitas" class="entitas" value="lainnya" >
	                        <input type="text" id="edit_entitas-lainnya" name="edit_entitas-lainnya" placeholder="Lainnya" class="form-control input-md" value="">
	                    </label>
	                </div>';
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
		            <div class="checkbox">
		                <label>            
		                <input type="checkbox" name="kategori" class="kategori" value="'.$value.'" '.$array_checkbox[$value].'>'.$value.'
		                </label>
		            </div>';
		        } else {
		        	//buat inputan checkbox lainnya yg blm ditandain untuk semua data yg tidak ada dalam array checkbox
		            $data_checkbox.= '
		            <div class="checkbox">
		                <label>              
		                    <input type="checkbox" name="kategori" class="kategori" value="'.$value.'" >'.$value.'
		                </label>
		            </div>';
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
	                <div class="checkbox">
	                    <label>
	                        <input type="checkbox" name="kategori" class="kategori" value="'.$value.'" > '. $value.'
	                    </label>
	                </div>';
			}
			$html .= '
	                <div class="checkbox">
	                    <label>
	                        <input type="checkbox" name="kategori" class="kategori" value="lainnya" >
	                        <input type="text" id="kategori-lainnya" name="kategori-lainnya" placeholder="Lainnya" class="form-control input-md" value="">
	                    </label>
	                </div>';
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
		            <div class="checkbox">
		                <label>            
		                <input type="checkbox" name="jenis" class="jenis" value="'.$value.'" '.$array_checkbox[$value].'>'.$value.'
		                </label>
		            </div>';
		        } else {
		        	//buat inputan checkbox lainnya yg blm ditandain untuk semua data yg tidak ada dalam array checkbox
		            $data_checkbox.= '
		            <div class="checkbox">
		                <label>              
		                    <input type="checkbox" name="jenis" class="jenis" value="'.$value.'" >'.$value.'
		                </label>
		            </div>';
		        }

		        //buat checkbox khusus untuk isian checkbox lainnya
		        foreach ($data as $k => $v) {
		            if( $v['jenis'] != 'Rapat' AND $v['jenis'] != 'Seminar' AND $v['jenis'] != 'Pementasan Seni' AND $v['jenis'] != 'Pertandingan Olahraga' AND $v['jenis'] != 'Instalasi/Pemasangan Alat Peraga'){
		                $lainnya = '
		                <div class="checkbox">
		                    <label>
		                        <input type="checkbox" name="jenis" class="jenis" value="'.$value.'" checked>
		                        <input type="text" id="jenis-lainnya" name="jenis-lainnya" placeholder="Lainnya" class="form-control input-md" value="'.$v['jenis'].'">
		                    </label>
		                </div>';
		            } else {
		                $lainnya = '
		                <div class="checkbox">
		                    <label>                
		                        <input type="checkbox" name="jenis" class="jenis" value="lainnya" >
		                        <input type="text" id="jenis-lainnya" name="jenis-lainnya" placeholder="Lainnya" class="form-control input-md" value="">
		                    </label>
		                </div>';
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
	                <div class="checkbox">
	                    <label>
	                        <input type="checkbox" name="jenis" class="jenis" value="'.$value.'" > '. $value.'
	                    </label>
	                </div>';
			}
			$html .= '
	                <div class="checkbox">
	                    <label>
	                        <input type="checkbox" name="jenis" class="jenis" value="lainnya" >
	                        <input type="text" id="jenis-lainnya" name="jenis-lainnya" placeholder="Lainnya" class="form-control input-md" value="">
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
		                <input type="checkbox" name="peserta" class="peserta" value="'.$value.'" '.$array_checkbox[$value].'>'.$value.'
		                </label>
		            </div>';
		        } else {
		        	//buat inputan checkbox lainnya yg blm ditandain untuk semua data yg tidak ada dalam array checkbox
		            $data_checkbox.= '
		            <div class="checkbox">
		                <label>              
		                    <input type="checkbox" name="peserta" class="peserta" value="'.$value.'" >'.$value.'
		                </label>
		            </div>';
		        }

		        //buat checkbox khusus untuk isian checkbox lainnya
		        foreach ($data as $k => $v) {
		            if( $v['peserta'] != 'Internal FISIP UI' AND $v['peserta'] != 'Internal FISIP UI dan Universitas Indonesia' AND $v['peserta'] != 'Umum'){
		                $lainnya = '
		                <div class="checkbox">
		                    <label>
		                        <input type="checkbox" name="peserta" class="peserta" value="'.$value.'" checked>
		                        <input type="text" id="peserta-lainnya" name="peserta-lainnya" placeholder="Lainnya" class="form-control input-md" value="'.$v['jpesertanis'].'">
		                    </label>
		                </div>';
		            } else {
		                $lainnya = '
		                <div class="checkbox">
		                    <label>                
		                        <input type="checkbox" name="peserta" class="peserta" value="lainnya" >
		                        <input type="text" id="peserta-lainnya" name="peserta-lainnya" placeholder="Lainnya" class="form-control input-md" value="">
		                    </label>
		                </div>';
		            }
		        }    
		    }
			$html = $data_checkbox.$lainnya;
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
	                        <input type="checkbox" name="peserta" class="peserta" value="'.$value.'" > '. $value.'
	                    </label>
	                </div>';
			}
			$html .= '
	                <div class="checkbox">
	                    <label>
	                        <input type="checkbox" name="peserta" class="peserta" value="lainnya" >
	                        <input type="text" id="peserta-lainnya" name="peserta-lainnya" placeholder="Lainnya" class="form-control input-md" value="">
	                    </label>
	                </div>';
		}		
		return $html;
	}
}
/* End of file MY_url_helper.php */
/* Location: ./application/helpers/MY_url_helper.php */