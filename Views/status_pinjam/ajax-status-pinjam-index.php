<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
function searchFilter(page_num) {
    page_num = page_num?page_num:0;
    var keywords = $('#keywords').val();
    var sortBy = $('#sortBy').val();
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>index.php/penggunaan/statusPinjamMhs/ajaxStatusPinjam/'+page_num,
        data:'page='+page_num+'&keywords='+keywords+'&sortBy='+sortBy,
        beforeSend: function () {
            $('.loading').show();
        },
        success: function (html) {
            $('#postList').html(html);
            $('.loading').fadeOut("slow");
        }
    });
}
function fetch_data()  
{  
    page_num = 0;
    var keywords = "";
    var sortBy = "asc";
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>index.php/penggunaan/statusPinjamMhs/ajaxStatusPinjam/'+page_num,
        data:'page='+page_num+'&keywords='+keywords+'&sortBy='+sortBy,
        beforeSend: function () {
            $('.loading-overlay').show();
        },
        success: function (html) {
            $('#postList').html(html);
            $('.loading-overlay').fadeOut("slow");
        }
    });
}
fetch_data();
</script>

<div class="container">
    <h1>Ajax Pagination with Search in CodeIgniter</h1>
    <div class="row">
        <div class="post-search-panel">
            <input type="text" id="keywords" placeholder="Type keywords to filter posts" onkeyup="searchFilter()"/>
            <select id="sortBy" onchange="searchFilter()">
                <option value="">Sort By</option>
                <option value="asc">Ascending</option>
                <option value="desc">Descending</option>
            </select>
        </div>
        <div class="loading-overlay"><div class="overlay-content">Loading.....</div></div>
        <div class="post-list" id="postList">
            <?php test($posts); ?>

            <?php /*if(!empty($posts)): foreach($posts as $post): ?>
                <div class="list-item"><a href="javascript:void(0);"><span><?php echo $post['event_name']; ?></span></a></div>
            <?php endforeach; else: ?>
            <p>Post(s) not available.</p>
            <?php endif; */?>
            <?php echo $this->ajax_pagination->create_links(); ?>
        </div>
        <div class="loading" style="display: none;"><div class="content"><img src="<?php echo base_url().'assets/images/spinner.gif'; ?>"/></div></div>
    </div>
</div>

<?php
function test($posts){
  $hak_akses = 1;
  header_table();
  content_table($posts);
  footer_table();
}

function content_table($posts){
    foreach ($posts as $rows) {
        $tanggal = $rows['tgl'].' '.$rows['bulan'].' '.$rows['tahun'];
        echo '
        <tr>
            <td>'.$rows['id_kegiatan'].'</td>
            <td>'.$rows['event_name'].'</td>
            <td>'.$rows['prodi'].'</td>
            <td>'.$tanggal.'</td>
            <td>'.$rows['status'].'</td>
        </tr>';
    }
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

function data($posts){
    $hak_akses = 1; //$this->session->userdata['logged_in']['hak_akses'];
    //set array multidimensi
    foreach ($posts as $rows) {
       $data[$rows['id_kegiatan']][$rows['nomor']][$rows['event_name']][$rows['prodi']][$rows['status']][$rows['no_surat']] = $rows;
    }
                
    $no = 1;
    $array_hari = array('Sun'=>'Minggu', 'Mon'=>'Senin', 'Tue'=>'Selasa', 'Wed'=>'Rabu', 'Thu'=>'Kamis', 'Fri'=>'Jumat', 'Sat'=>'Sabtu');
    $array_bulan = array('1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni', '7'=>'Juli',
                          '8'=>'Agustus', '9'=>'September', '10'=>'Oktober', '11'=>'Nopember', '12'=>'Desember', );    
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

                    foreach ($data as $k_id_kegiatan => $v_id_kegiatan) {  
                        foreach ($v_id_kegiatan as $k_nomor => $v_nomor) {
                          foreach ($v_nomor as $k_event_name => $v_event_name) {
                            foreach ($v_event_name as $k_prodi => $v_prodi) {
                                foreach ($v_prodi as $k_status => $v_status){
                                    foreach ($v_status as $k_no_surat => $v_no_surat){

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
                                    <tr>
                                        <td>'.$no.'</td>
                                        <td id="event_name_'.$k_nomor.'">'.$k_event_name.'</td>
                                        <td>'.$k_prodi.'</td>
                                        <td id="no_surat_'.$k_nomor.'" class="status" >'.$k_no_surat.'</td>
                                        <td width="27%">
                                            <table class="">';

                                            foreach ($v_no_surat as $v) {
                                                echo $v_no_surat['start_date'].'<br>';
                                                /*
                                                $d = date('D', strtotime($v_no_surat['start_date']));
                                                $waktu_awal = date('H:i', strtotime($v_no_surat['start_date']));
                                                $waktu_akhir = date('H:i', strtotime($v_no_surat['end_date']));
                                                $nama_hari = $array_hari[$d];
                                                $tgl = $v_no_surat['tgl'];
                                                $bulan = $array_bulan[$v_no_surat['bulan']];
                                                $tahun = $v_no_surat['tahun'];

                                                echo '
                                                <tr style="border:1px solid #eee">                                                  
                                                  <td style="padding-left:3px; width:150px; vertical-align:top; padding-bottom:5px; border-bottom:1px solid #eee">'.$nama_hari.', '.$tgl.' '.$bulan.' '.$tahun.'</td>
                                                  <td style="width:80px; vertical-align:top; padding-bottom:5px; border-bottom:1px solid #eee">'.$waktu_awal.'-'.$waktu_akhir.'</td>
                                                  <td style="text-align:center; width:150px; vertical-align:top; padding-bottom:5px; border-bottom:1px solid #eee">'.$v_no_surat['nm_ruang'].'</td>
                                                </tr>';
                                                */
                                          }  
                                          echo '
                                        </table>
                                  </td>';
                                if($hak_akses > 0){
                                    echo '<td id="status_'.$k_nomor.'" class="status" data-toggle="modal" data-target=".verifikasi" style="cursor:pointer"><span>'.$status.'</span></td>';
                                } else {
                                    echo '<td>'.$status.'</td>';
                                }
                                echo' </tr>';
                                $no++;
                            } //end of status
                        } //end of prodi
                    } //end of event_name
                } //end of nomor
            } //end of id_kegiatan
        } //end of $data

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

} //end of data
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
function searchFilter(page_num) {
    page_num = page_num?page_num:0;
    var keywords = $('#keywords').val();
    var sortBy = $('#sortBy').val();
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>index.php/penggunaan/statusPinjamMhs/ajaxStatusPinjam/'+page_num,
        data:'page='+page_num+'&keywords='+keywords+'&sortBy='+sortBy,
        beforeSend: function () {
            $('.loading').show();
        },
        success: function (html) {
            $('#postList').html(html);
            $('.loading').fadeOut("slow");
        }
    });
}
</script>