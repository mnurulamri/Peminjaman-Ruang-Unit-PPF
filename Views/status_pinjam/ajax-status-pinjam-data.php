<?php
if(!empty($posts)){
	test($posts);
} else {
	echo '<p>Post(s) not available.</p>';
}

echo $this->ajax_pagination->create_links();

function test($posts){
  $hak_akses = 1;
  header_table();
  content_table($posts);
  footer_table();
}

function content_table($posts){
    foreach ($posts as $rows) {
		$data[$rows['id_kegiatan']][$rows['nomor']][$rows['event_name']][$rows['prodi']][$rows['status']][$rows['no_surat']][$rows['start_date']][$rows['end_date']][] = array(
       		'start_date' => $rows['start_date'],
       		'end_date' => $rows['end_date'],
            'tgl' => $rows['tgl'],
            'bulan' => $rows['bulan'],
            'tahun' => $rows['tahun'],
       		'nm_ruang' => $rows['nm_ruang']
		);
        $waktu[$rows['id_kegiatan']][$rows['start_date']][] = $rows['nm_ruang'];
    }
    
    foreach ($data as $k_id_kegiatan => $v_id_kegiatan) {
        echo '<tr>';
        foreach ($v_id_kegiatan as $k_nomor => $v_nomor) {
            echo '<td>'.$k_id_kegiatan.'</td>';
			foreach ($v_nomor as $k_event_name => $v_event_name) {
				foreach ($v_event_name as $k_prodi => $v_prodi) {
                    echo '<td id="event_name_'.$k_nomor.'">'.$k_event_name.'</td>';
					foreach ($v_prodi as $k_status => $v_status){
                        echo '<td>'.$k_prodi.'</td>';
	                    foreach ($v_status as $k_no_surat => $v_no_surat){
	                    	//set nama status approval
                            if($k_status == 1){
                                $status = '<span style="color:#C85EC7">Menunggu Persetujuan Koordinator PPF</span>';
                            } else if($k_status == 2) {
                                $status = '<span style="color:#808000">Menunggu Persetujuan Wakil Manajer PPF</span>';
                            } else if($k_status == 3){
                                $status = '<span style="color:#009966">Disetujui</span>';
                            } else {
                                $status = ' ';
                            }
                            echo '
                                <td id="no_surat_'.$k_nomor.'" class="status" >'.$k_no_surat.'</td>
                            	<td width="27%">
                                
                                    <table class="">';
				                    	foreach ($v_no_surat as $k_start_date => $v_start_date) {

                                            foreach ($v_start_date as $k_end_date => $v_end_date) {

                                                $waktu_awal = date('H:i', strtotime($k_start_date));
                                                $waktu_akhir = date('H:i', strtotime($k_end_date));
                                                echo '
                                                <tr>
                                                    <td>'.$v_end_date['tgl'].'</td>
                                                    <td>'.$waktu_awal.'</td>
                                                    <td>'.$waktu_akhir.'</td>
                                                    <td>
                                                        <table>';
                                                            foreach ($v_end_date as $v) {
                                                                
                                                                echo '
                                                                <tr style="border:1px solid #eee">
                                                                    <!--<td>'.tanggal($v['start_date'], $v['end_date'], $v['tgl'], $v['bulan'], $v['tahun']).'</td>-->
                                                                    <td>'.$v['nm_ruang'].'</td>
                                                                </tr>';
                                                                
                                                            }                                                        
                                                 echo '
                                                        </table>
                                                    </td>';

                                                echo '</tr>';                                             
                                            }

				                    	} // end of no_surat
	                    	echo '
	                    			</table>
                                    
	                    		</td>
                                <td>'.$status.'</td>';
	                    } // end of status
	                } // end of prodi
	            } // end of event_name
	        } // end of nomor
	    } // end of id_kegiatan
        echo '</tr>';
	} // end of data

    echo '<pre>';
    //print_r($waktu);
    echo '</pre>';
}

function header_table(){
      echo '
    <div class="row">
        <div class="col-xs-12">

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Data Pengajuan Pemakaian Ruang</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama Kegiatan</th>
                          <th>Unit Pengguna</th>                      
                          <th>No. Surat</th>
                          <th>Jadwal</th>
                          <th>Status</th>
                      </tr>
                  </thead>
                  <tbody>';
}

function footer_table(){
                  echo '
                  </tbody>
                  <tfoot>
                    <tr style="color:#fff; ">
                      <th class="line-left">No</th>
                      <th class="line-right">Nama Kegiatan</th>
                      <th class="line-right">Unit Pengguna</th>                      
                      <th class="line-right">No. Surat</th>
                      <th class="line-right">Jadwal</th>
                      <th class="line-right">Status</th>
                    </tr>
                    </tfoot>
                </table>
              <!-- /.table -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->';
}

function tanggal($start_date, $end_date, $var_tgl, $var_bulan, $var_tahun){
    $array_hari = array('Sun'=>'Minggu', 'Mon'=>'Senin', 'Tue'=>'Selasa', 'Wed'=>'Rabu', 'Thu'=>'Kamis', 'Fri'=>'Jumat', 'Sat'=>'Sabtu');
    $array_bulan = array('1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni', '7'=>'Juli',
                          '8'=>'Agustus', '9'=>'September', '10'=>'Oktober', '11'=>'Nopember', '12'=>'Desember', ); 
    $d = date('D', strtotime($start_date));
    //$waktu_awal = date('H:i', strtotime($start_date));
    //$waktu_akhir = date('H:i', strtotime($end_date));
    $nama_hari = $array_hari[$d];
    $tgl = $var_tgl;
    $bulan = $array_bulan[$var_bulan];
    $tahun = $var_tahun;
    return $nama_hari.', '.$tgl.' '.$bulan.' '.$tahun;
}
?>