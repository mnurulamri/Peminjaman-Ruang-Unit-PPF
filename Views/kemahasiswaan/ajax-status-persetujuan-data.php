<?php
if (isset($this->session->userdata['logged_in'])) {
    $username = ($this->session->userdata['logged_in']['username']);
    $hak_akses = ($this->session->userdata['logged_in']['hak_akses']);
    $role = ($this->session->userdata['logged_in']['role']);  #'mahasiswa';
} else {
    //header("location: http://ppf.fisip.ui.ac.id/backend/autentikasi/ldapLogin/logout");
    header("location: http://localhost:8080/app/autentikasi/ldapLogin/logout");
}

if(!empty($posts)){
	test($posts, $data_jadwal, $offset, $hak_akses, $username);
} else {
	echo '<p>Post(s) not available.</p>';
}

echo $this->ajax_pagination->create_links();
//echo $offset;
function test($posts, $data_jadwal, $offset, $hak_akses, $username){
  header_table($hak_akses);
  content_table($posts, $data_jadwal, $offset, $hak_akses, $username);
  footer_table($hak_akses);
}

function content_table($posts, $data_jadwal, $offset, $hak_akses, $username){
    //set info persetujuan
    $status = array(
        0 => '<i class="fa fa-circle-o text-gray"></i> <font class="text-gray">-</font> <i class="fa fa-circle-o text-gray"></i> <font class="text-gray">-</font> <i class="fa fa-circle-o text-gray"></i>',
        1 => '<i class="fa fa-circle-o text-aqua"></i> <font class="text-aqua">-</font> <i class="fa fa-circle-o text-gray"></i> <font class="text-gray">-</font> <i class="fa fa-circle-o text-gray"></i>',
        2 => '<i class="fa fa-circle-o text-aqua"></i> <font class="text-aqua">-</font> <i class="fa fa-circle-o text-yellow"></i> <font class="text-yellow">-</font> <i class="fa fa-circle-o text-gray"></i>',
        3 => '<i class="fa fa-circle-o text-aqua"></i> <font class="text-aqua">-</font> <i class="fa fa-circle-o text-yellow"></i> <font class="text-yellow">-</font> <i class="fa fa-circle-o text-green"></i>',
    );
    /*$status = array(
        0 => '<li class="kemahasiswaan"></li><li class="koordinator"></li><li class="manajer_ppf"></li>',  //belum ada approval
        1 => '<li class="active kemahasiswaan"></li><li class="koordinator"></li><li class="manajer_ppf"></li>', //approval Wakil Manajer
        2 => '<li class="active kemahasiswaan"></li><li class="active koordinator"></li><li class="manajer_ppf"></li>', //approval Koordinator PPF
        3 => '<li class="active kemahasiswaan"></li><li class="active koordinator"></li><li class="active manajer_ppf"></li>' //approval Wakil Manajer
    );*/

    foreach ($data_jadwal as $rows) {
        $jadwal[$rows['nomor']][$rows['start_date']][$rows['end_date']][] = $rows;
    }
    $n=$offset+1;
    foreach ($posts as $rows) {
        $schedule = $jadwal[$rows['nomor']];

        if (!empty($rows['file_tor'])) {
          $view_tor = '<i class="fa fa-file-text-o fa-lg"></i>';
          $ext_tor = ekstensi_file($rows['file_tor']);
          $nama_file_tor = $rows['file_tor'];
          $style_tor = 'style="cursor:pointer"';
        } else {
          $view_tor = '';
          $ext_tor = '';
          $nama_file_tor = '';
          $style_tor = '';
        }

        if (!empty($rows['file_rundown'])) {
          $view_rundown = '<i class="fa fa-file-text-o fa-lg"></i>';
          $ext_rundown = ekstensi_file($rows['file_rundown']);
          $nama_file_rundown = $rows['file_rundown'];
          $style_rundown = 'style="cursor:pointer"';
        } else {
          $view_rundown = '';
          $ext_rundown = '';
          $nama_file_rundown = '';
          $style_rundown = '';
        }

        if (!empty($rows['file_undangan'])) {
          $view_undangan = '<i class="fa fa-file-text-o fa-lg"></i>';
          $ext_undangan = ekstensi_file($rows['file_undangan']);
          $nama_file_undangan = $rows['file_undangan'];
          $style_undangan = 'style="cursor:pointer"';
        } else {
          $view_undangan = '';
          $ext_undangan = '';
          $nama_file_undangan = '';
          $style_undangan = '';
        }

        if (!empty($rows['file_lampiran'])) {
          $view_lampiran = '<i class="fa fa-file-text-o fa-lg"></i>';
          $ext_lampiran = ekstensi_file($rows['file_lampiran']);
          $nama_file_lampiran = $rows['file_lampiran'];
          $style_lampiran = 'style="cursor:pointer"';
        } else {
          $view_lampiran = '';
          $ext_lampiran = '';
          $nama_file_lampiran = '';
          $style_lampiran = '';
        }

        echo '
        <tr>
            <td>'.$n.'</td>
            <td width="220px">'.$rows['event_name'].'</td>
            <td>'.$rows['prodi'].'</td>
            <td>'.$rows['no_surat'].'</td>
            
            <td width="350px">
                <!--'.$rows['tema'].'
                 cetak jadwal-->
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
                
            </td>';

            //if () {
            if (($rows['status']==0 or $rows['status']==4 or $rows['status']==5) and ($hak_akses==4 or $hak_akses==5)) {
              $class = 'class="status"';
              $style = 'style="cursor:pointer"';
            } else {
              $class = 'class="statusx"';
              $style = 'style=""';
            }
            

            echo ' 
            <td id="status_'.$rows['nomor'].'" '.$class.' '.$style.'>
                '.status_persetujuan($rows['status'], $rows['alasan']).'
            </td>
            <td id="crud_view_'.$rows['nomor'].'" style="text-align:top">';
                if($hak_akses > 0){
                    echo '<i id='.$rows['nomor'].' class="testing '.$rows['username'].' fa fa-file-pdf-o fa-align-center fa-lg faa-vertical" style="color:red; cursor:pointer; width:20px"></i>';
                    /*echo'
                    <a href="'.base_url().'penggunaan/formPdf/ruangRapat/'.$rows['nomor'].' " target="_blank" class="fa fa-file-pdf-o fa-align-center fa-lg faa-vertical" style="color:red; cursor:pointer; width:20px"></a>
                    </span>';*/
                }
                echo '
            </td>';
            dokumen($style_tor,$ext_tor,$nama_file_tor,$view_tor,$style_rundown,$ext_rundown,$nama_file_rundown,$view_rundown,$style_undangan,$ext_undangan,$nama_file_undangan,$view_undangan,$style_lampiran,$ext_lampiran,$nama_file_lampiran,$view_lampiran);
        echo'
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
                <div class="box-body" style="overflow:auto">
                    <table id="example1" class="table">
                      <thead>
                        <tr>
                          <th colspan="7"></th>
                          <th colspan="4" style="text-align:center">Dokumen</th>
                        </tr>
                        <tr>
                          <th>No</th>
                          <th width="220px">Nama Kegiatan</th>
                          <th>Unit Pengguna</th>                      
                          <th>No. Surat</th>
                          <th>Jadwal</th>
                          <th>Status Persetujuan</th>';
                        
                        if($hak_akses > 0){
                            echo'<th>Surat Izin Kegiatan</th>';
                        } else {
                            echo '<th>View|Del</th>';
                        }
                        echo '
                        <th>Tor</th>
                        <th>Rundown</th>
                        <th>Undangan</th>
                        <th>Lampiran</th>                                                  
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
                      <th>Status Persetujuan</th>';
                      
                        if($hak_akses > 0){
                            echo'<th>Edit|View|Del</th>';
                        } else {
                            echo '<th>View|Del</th>';
                        }
                     echo '
                        <th>file<br>tor</th>
                        <th>file<br>rundown</th>
                        <th>file<br>undangan</th>
                        <th>file<br>lampiran</th>
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

/*function ekstensi_file($str){
  $str = substr($str, -6);
  $str = explode('.', $str);
  $str = $str[1];
  return $ext_tor = '.'.$str;
}

function dokumen($style_tor,$ext_tor,$nama_file_tor,$view_tor,$style_rundown,$ext_rundown,$nama_file_rundown,$view_rundown,$style_undangan,$ext_undangan,$nama_file_undangan,$view_undangan,$style_lampiran,$ext_lampiran,$nama_file_lampiran,$view_lampiran){
    echo '
    <td '.$style_tor.' class="view-dok text-light-blue operator" data-ext="'.$ext_tor.'" data-file="'.$nama_file_tor.'" data-tt="tooltip" title="'.$nama_file_tor.'">'.$view_tor.'</td>
    <td '.$style_rundown.' class="view-dok text-light-blue" data-ext="'.$ext_rundown.'" data-file="'.$nama_file_rundown.'" data-tt="tooltip" title="'.$nama_file_rundown.'">'.$view_rundown.'</td>
    <td '.$style_undangan.' class="view-dok text-light-blue" data-ext="'.$ext_undangan.'" data-file="'.$nama_file_undangan.'" data-tt="tooltip" title="'.$nama_file_undangan.'">'.$view_undangan.'</td>
    <td '.$style_lampiran.' class="view-dok text-light-blue" data-ext="'.$ext_lampiran.'" data-file="'.$nama_file_lampiran.'" data-tt="tooltip" title="'.$nama_file_lampiran.'">'.$view_lampiran.'</td>';
}*/

function status_persetujuan($status, $alasan){
  if($status == 0){
    $keterangan = '<span style="color:#C85EC7;font-size:11px;">Menunggu Persetujuan Wakil Manajer kemahasiswaan</span>';
  } else if($status == 1 or $status == 2) {
    $keterangan = '<span style="color:#808000;font-size:11px;">Menunggu Persetujuan Wakil Manajer PPF</span>';
  } else if($status == 3){
    $keterangan = '<span style="color:#009966;font-size:11px;">Disetujui</span>';
  } else if($status == 4){
    if ($alasan=='') {
      $keterangan = '<span style="color:#009966;font-size:11px;">Ditunda</span>';
    } else {
      $keterangan = '<span style="color:#009966;font-size:11px;">Ditunda<i>'.$alasan.'</i></span>';
    }
  } else if($status == 5){
    if ($alasan=='') {
      $keterangan = '<span style="color:#009966;font-size:11px;">Ditolak</span>';
    } else {
      $keterangan = '<span style="color:#009966;font-size:11px;">Ditolak<i>'.$alasan.'</i></span>';
    }
  } else if($status == 6){
    if ($alasan=='') {
      $keterangan = '<span style="color:#009966;font-size:11px;">Menunggu Persetujuan Wakil Manajer PPF<br><i>- Ditunda -</i></span>';
    } else {
      $keterangan = '<span style="color:#009966;font-size:11px;">Menunggu Persetujuan Wakil Manajer PPF<br><i>- Ditunda -</i><i>'.$alasan.'</i></span>';
    }
  } else if($status == 7){
    if ($alasan=='') {
      $keterangan = '<span style="color:#009966;font-size:11px;">Menunggu Persetujuan Wakil Manajer PPF<br><i>- Ditolak -</i></span>';
    } else {
      $keterangan = '<span style="color:#009966;font-size:11px;">Menunggu Persetujuan Wakil Manajer PPF<br><i>- Ditolak -</i><i>'.$alasan.'</i></span>';
    }
  } else {
    $keterangan = ' ';
  }
  return $keterangan;
}
?>