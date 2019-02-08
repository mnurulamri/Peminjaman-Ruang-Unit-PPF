<?php
if(!empty($posts)){
	test($posts, $data_jadwal, $offset);
} else {
	echo '<p>Post(s) not available.</p>';
}

echo $this->ajax_pagination->create_links();
echo $offset;
function test($posts, $data_jadwal, $offset){
  $hak_akses = 1;
  header_table($hak_akses);
  content_table($posts, $data_jadwal, $offset, $hak_akses);
  footer_table($hak_akses);
}

function content_table($posts, $data_jadwal, $offset, $hak_akses){
    //set info persetujuan
    $status = array(
        0 => '<li class="kemahasiswaan"></li><li class="koordinator"></li><li class="manajer_ppf"></li>',  //belum ada approval
        1 => '<li class="active kemahasiswaan"></li><li class="koordinator"></li><li class="manajer_ppf"></li>', //approval Wakil Manajer
        2 => '<li class="active kemahasiswaan"></li><li class="active koordinator"></li><li class="manajer_ppf"></li>', //approval Koordinator PPF
        3 => '<li class="active kemahasiswaan"></li><li class="active koordinator"></li><li class="active manajer_ppf"></li>' //approval Wakil Manajer
    );

    foreach ($data_jadwal as $rows) {
        $jadwal[$rows['nomor']][$rows['start_date']][$rows['end_date']][] = $rows;
    }
    $n=$offset+1;
    foreach ($posts as $rows) {
        $schedule = $jadwal[$rows['nomor']];
        echo '
        <tr>
            <td>'.$n.'</td>
            <td width="220px">'.$rows['event_name'].'</td>
            <td>'.$rows['prodi'].'</td>
            <td>'.$rows['no_surat'].'</td>
            <td>
                <table>'; 
                foreach ($schedule as $k_start_date => $v_start_date) {
                    foreach ($v_start_date as $k_end_date => $v_end_date) {
                        $waktu_awal = date('H:i', strtotime($k_start_date));
                        $waktu_akhir = date('H:i', strtotime($k_end_date));
                        echo '<tr><td class="day">'.tanggal($k_start_date).'</td><td class="time">'.$waktu_awal.' '.$waktu_akhir.'</td><td>';
                        $i=1;
                        foreach ($v_end_date as $v) {
                            //echo '<div>'.$v->nm_ruang.'</div>';
                           if($i<count($v_end_date)){
                            $koma = '<div></div>';
                           } else {
                            $koma = '';
                           }
                            echo $v['nm_ruang'].$koma;
                            $i++;                                             
                        }
                        echo '<td></tr>';
                    }
                    //
                }
            echo'
                </table>
            </td>
            <td class="containerx">
                <ul class="progressbar">'.$status[$rows['status']].'</ul>
            </td>
            <td>';
                if($hak_akses > 0){
                    echo'
                    <span>
                    <i id='.$rows['nomor'].' data-toggle="modal" data-target=".form-booking-edit" class="edit-kegiatan fa fa-edit fa-align-center" style="color:#00a65a; font-size:20px; cursor:pointer; width:20px"></i>
                    </span>&nbsp;&nbsp;&nbsp;&nbsp;
                    <span>
                    <a href="'.base_url().'penggunaan/formPdf/ruangRapat/'.$rows['nomor'].' " target="_blank" class="fa fa-file-pdf-o fa-align-center fa-lg faa-vertical" style="color:red; cursor:pointer; width:20px"></a>
                    </span>
                    <span>
                    <i id='.$rows['nomor'].' rel="'.$rows['event_name'].'" class="del fa fa-trash fa-align-center fa-lg" style="color:red; cursor:pointer; width:20px"></i>
                    </span>';
                }
                echo '
            </td>
        </tr>';
        $n++;
    }

    echo '<pre>';
    //print_r($jadwal);
    echo '</pre>';
}

function header_table($hak_akses){
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
                          <th width="220px">Nama Kegiatan</th>
                          <th>Unit Pengguna</th>                      
                          <th>No. Surat</th>
                          <th>Jadwal</th>
                          <th width="220px">Status Persetujuan</th>';
                        
                        if($hak_akses > 0){
                            echo'<th>Edit|View|Del</th>';
                        } else {
                            echo '<th>View|Del</th>';
                        }
                        echo '
                      </tr>
                  </thead>
                  <tbody>';
}

function footer_table($hak_akses){
                  echo '
                  </tbody>
                  <tfoot>
                    <tr style="color:#fff; ">
                      <th class="line-left">No</th>
                      <th width="220px" class="line-right">Nama Kegiatan</th>
                      <th class="line-right">Unit Pengguna</th>                      
                      <th class="line-right">No. Surat</th>
                      <th class="line-right">Jadwal</th>
                      <th width="220px">Status Persetujuan</th>';
                      
                        if($hak_akses > 0){
                            echo'<th>Edit|View|Del</th>';
                        } else {
                            echo '<th>View|Del</th>';
                        }
                     echo '
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

function tanggal($string){
    $BulanIndo = array(
        "01"=>"Januari", "02"=>"Februari", "03"=>"Maret",
        "04"=>"April", "05"=>"Mei", "06"=>"Juni",
        "07"=>"Juli", "08"=>"Agustus", "09"=>"September",
        "10"=>"Oktober", "11"=>"November", "12"=>"Desember"
    );
    $array_hari = array('Sun'=>'Minggu', 'Mon'=>'Senin', 'Tue'=>'Selasa', 'Wed'=>'Rabu', 'Thu'=>'Kamis', 'Fri'=>'Jumat', 'Sat'=>'Sabtu');
    $array = explode(" ", $string);
    $array_tanggal = explode("-", $array[0]);
    $d = date('D', strtotime($string));
    $nama_hari = $array_hari[$d];
    return $nama_hari.', '.$array_tanggal[2].' '.$BulanIndo[$array_tanggal[1]].' '.$array_tanggal[0];
}
?>