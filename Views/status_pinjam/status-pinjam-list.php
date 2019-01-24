<?php
/*
  view untuk menampilkan daftar pengajuan
*/

if (isset($this->session->userdata['logged_in'])) {
  $username = ($this->session->userdata['logged_in']['username']);
	$hak_akses = ($this->session->userdata['logged_in']['hak_akses']);
} else {
  header("location: http://ppf.fisip.ui.ac.id/backend/autentikasi/ldapLogin/loginForm");
}
?>

   <div class="modal fade verifikasi" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
         <div class="modal-content"></div>
      </div>
   </div>
      
    <div class="row">
        <div class="col-xs-12">

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Pengajuan Pemakaian Ruang</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?php

                $no = 1;
                $array_hari = array('Sun'=>'Minggu', 'Mon'=>'Senin', 'Tue'=>'Selasa', 'Wed'=>'Rabu', 'Thu'=>'Kamis', 'Fri'=>'Jumat', 'Sat'=>'Sabtu');
                $array_bulan = array('1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni', '7'=>'Juli',
                                      '8'=>'Agustus', '9'=>'September', '10'=>'Oktober', '11'=>'Nopember', '12'=>'Desember', );
                echo '
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
                                                <table class="" border="1" cellspacing="1" cellpadding="2">';
                                                    
                                                foreach ($v_no_surat as $k_start_date => $v_start_date) {
                                                    echo '<tr>';
                                                    # set variabel
                                                    //$d = date('D', strtotime($k_start_date));
                                                    /*$nama_hari = $array_hari[$d];
                                                    $tgl = $v->tgl;
                                                    $bulan = $array_bulan[$v->bulan];
                                                    $tahun = $v->tahun;   

                                                    echo '
                                                    <tr style="border:1px solid #eee">                                                  
                                                      <td style="padding-left:3px; width:150px; vertical-align:top; padding-bottom:5px; border-bottom:1px solid #eee">'.$nama_hari.', '.$tgl.' '.$bulan.' '.$tahun.'</td>
                                                      <td style="width:80px; vertical-align:top; padding-bottom:5px; border-bottom:1px solid #eee">'.$waktu_awal.'-'.$waktu_akhir.'</td>
                                                      <td style="text-align:center; width:150px; vertical-align:top; padding-bottom:5px; border-bottom:1px solid #eee">'.$v->nm_ruang.'</td>
                                                    </tr>';
                                                    */

                                                    echo '<td>';

                                                    foreach ($v_start_date as $k_end_date => $v_end_date) {
                                                        $waktu_awal = date('H:i', strtotime($k_start_date));
                                                        $waktu_akhir = date('H:i', strtotime($k_end_date));    

                                                        echo tanggal($k_start_date).'<td>'.$waktu_awal.'-'.$waktu_akhir.'</td>';
                                                        foreach ($v_end_date as $k => $v) {
                                                            echo '<td>';
                                                            print_r($v->nm_ruang);
                                                            echo '</td>';                                               
                                                        }

                                                    }

                                                    echo '</td></tr>';

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
										}
        							}
                                }
                            }
                        }
                    }
                  

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
                </table>'
                ?>
              <!-- /.table -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
<?php
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
<?=$script?>
<script>
$(function () {
  /*$("#example1").DataTable({
    scrollX:true
  });*/
	
    $(document).on('click', '.status', function(){ 
        var id = $(this).attr('id');
        id = id.split('_');
        var nomor = id[1];
        //alert(id);
        
        //$('.modal-content').html(id);
        //
        //var url = "<?=base_url()?>" + peminjaman/statusPinjam/ruangRapat;
        $.ajax({
            type: "POST",
            //url: "<?=base_url()?>" + "peminjaman/statusPinjam/viewJadwalRapat",
            url: "<?=base_url()?>" + "penggunaan/ruangRapat/statusKonfirmasi",      
            data: {nomor:nomor},
            success: function(res) {
                //$(".modal-dialog").html(res);
                if (res){
                    $(".modal-content").html(res);
                } else {
                    $("#event_name").html('ada error');
                }
            }
        });
    });
    
    //filter table
    var table = $('#example1').DataTable();
	// Setup - add a text input to each footer cell
	$('#example1 thead th').each( function () {
        var title = $('#example1 thead th').eq( $(this).index() ).text();
		$(this).html( '<div style="padding:2px">'+title+'</div><div style="padding-bottom:3px"><input type="text" placeholder="Search '+title+'" style="width:90%; font-size:11px"/></div>' );
    } );
	// Apply the search
    table.columns().eq( 0 ).each( function ( colIdx ) {
        $( 'input', table.column( colIdx ).header() ).on( 'keyup change', function () {
            table
                .column( colIdx )
                .search( this.value )
                .draw();
        } );
    } );
});
</script>
<style>
.line-left{
  border-bottom:1px solid #fff; border-left:1px solid #fff; border-left:1px solid #fff;
}
.line-right {
  border-bottom:1px solid #fff; border-left:1px solid #fff; border-right:1px solid #fff;
}
</style>
</body>
</html>
