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
        <div class="col-xs-12 col-md-12">

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Pengajuan Pemakaian Ruang</h3>
            </div>
        
            <!-- /.box-header -->
            <div class="box-body">
            <div class="container-ket">
                <ul class="ketbar">
                    <li class="active">Wakil Manajer Kemahasiswaan</li>
                    <li class="">Koordinator PPF</li>
                    <li class="">Wakil Manajer PPF</li>
                </ul>
            </div>
                <!--
                <table>
                    <tr>
                        <td colspan="3">Keterangan Persetujuan:</td>
                    </tr>
                    <tr>
                        <td><span class="ket">1</span></td><td>Wakil Manajer Kemahasiswaan</td>
                        <td><span class="ket">2</span></td><td>Koordinator PPF</td>
                        <td><span class="ket">3</span></td><td>Wakil Manajer PPF</td>                     
                    </tr>
                </table>
                -->
                <?php
                $no = 1;
                $array_hari = array('Sun'=>'Minggu', 'Mon'=>'Senin', 'Tue'=>'Selasa', 'Wed'=>'Rabu', 'Thu'=>'Kamis', 'Fri'=>'Jumat', 'Sat'=>'Sabtu');
                $array_bulan = array('1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni', '7'=>'Juli',
                                      '8'=>'Agustus', '9'=>'September', '10'=>'Oktober', '11'=>'Nopember', '12'=>'Desember', );
                //set info persetujuan
                $status = array(
                    0 => '<li class="kemahasiswaan"></li><li class="koordinator"></li><li class="manajer"></li>',  //belum ada approval
                    1 => '<li class="active"></li><li></li><li></li>', //approval Wakil Manajer
                    2 => '<li class="active"></li><li class="active"></li><li></li>', //approval Koordinator PPF
                    3 => '<li class="active"></li><li class="active"></li><li class="active"></li>' //approval Wakil Manajer
                );
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
            								/*
                                            if($k_status == 1){
                                                $status = '<span style="color:#C85EC7">Menunggu Persetujuan Koordinator PPF</span>';
                                            } else if($k_status == 2) {
                                                $status = '<span style="color:#808000">Menunggu Persetujuan Wakil Manajer PPF</span>';
                                            } else if($k_status == 3){
                                                $status = '<span style="color:#009966">Disetujui</span>';
                                            } else {
                                                $status = ' ';
                                            }								
                							*/
                                          echo '
                                          <tr>
                                            <td>'.$no.'</td>
                                            <td id="event_name_'.$k_nomor.'">'.$k_event_name.'</td>
                                            <td>'.$k_prodi.'</td>
                                            <td id="no_surat_'.$k_nomor.'" class="status" >'.$k_no_surat.'</td>
                                            <td width="30%">
                                                <table>';
                                                    
                                                foreach ($v_no_surat as $k_start_date => $v_start_date) {

                                                    foreach ($v_start_date as $k_end_date => $v_end_date) {

                                                        $waktu_awal = date('H:i', strtotime($k_start_date));
                                                        $waktu_akhir = date('H:i', strtotime($k_end_date));    
                                                        echo '<tr style="border:1px solid #eee">';
                                                        echo '
                                                        <td class="day">'.tanggal($k_start_date).'</td>
                                                        <td class="time">'.$waktu_awal.'-'.$waktu_akhir.'</td>';
                                                        echo '<td style="vertical-align:top">';
                                                        $i=1;

                                                        foreach ($v_end_date as $k => $v) {
                                                            //echo '<div>'.$v->nm_ruang.'</div>';
                                                           if($i<count($v_end_date)){
                                                            $koma = '<div></div>';
                                                           } else {
                                                            $koma = '';
                                                           }
                                                            echo $v->nm_ruang.$koma;
                                                            $i++;                                             
                                                        }
                                                        echo '</td>'; 
                                                        echo '</tr>';
                                                    }

                                                }

                                                echo '
                                                </table>
                                            </td>';

											if($hak_akses > 0){
                                                echo '
                                                <td class="containerx">
                                                    <ul class="progressbar">'.$status[$k_status].'</ul>
                                                    <i id="status_'.$k_nomor.'" class="status btn btn-xs btn-default" data-toggle="modal" data-target=".verifikasi" style="color:#3aac5d">Approval</i>
                                                </td>';
											} else {
												echo '
                                                <td class="containerx">
                                                    <ul class="progressbar">'.$status[$k_status].'</ul>
                                                </td>';
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
.line-left{border-bottom:1px solid #fff; border-left:1px solid #fff; border-left:1px solid #fff;}
.line-right {border-bottom:1px solid #fff; border-left:1px solid #fff; border-right:1px solid #fff;}
.day{padding-left:3px; width:150px; vertical-align:top; padding-bottom:5px; border-bottom:1px solid #eee}
.time{width:80px; vertical-align:top; padding-bottom:5px; border-bottom:1px solid #eee}
table tr td div {border-bottom:1px solid #eee;}
/* status progress */
.containerx{
  width: 250px; /*100%;*/
  position: relative;
  z-index: 1;
}
.progressbar li{
  float: left;
  width: 30px;
  position: relative;
  text-align: center;
  list-style: none;
}

.progressbar li:before{
  content:counter(step);
  counter-increment: step;
  width: 20px;
  height: 20px;
  border: 1px solid #bebebe;
  display: block;
  border-radius: 50%;
  background: white;
  color: #bebebe;
  text-align: center;
  /*font-weight: bold;    
  margin: 0 auto 10px auto;
    line-height: 27px;
  */
}
.progressbar{
  counter-reset: step;
}
.progressbar li:after{
  content: '';
  position: absolute;
  width:100%;
  height: 1px;
  background: #bebebe;
  top: 11px;
  left: -50%;
  z-index: -1;
}

.progressbar li.active:before, .progressbar li.active:after {
  border-color: #3aac5d;
  /*background: gray;*/
  color: #3aac5d;
  font-size: 11px;
  font-family: arial
}
.progressbar li:first-child:after{
    content: none;
}
.ket{
  width: 20px;
  height: 20px;
  border: 1px solid #bebebe;
  display: block;
  border-radius: 50%;
  background: white;
  color: #bebebe;
  text-align: center;
    border-color: #3aac5d;
  color: #3aac5d;
}
.container-ket{
  width: 100%;
  position: absolute;
  z-index: 1;
  border:1px solid gray;
}
.ketbar li{
  float: left;
  width: 20%;
  position: relative;
  text-align: center;
  list-style: none;
}

.ketbar li:before{
  content:counter(step);
  counter-increment: step;
  width: 20px;
  height: 20px;
  border: 2px solid #bebebe;
  display: block;
  border-radius: 50%;
  background: white;
  color: #bebebe;
  text-align: center;
  font-weight: bold;
    /*
  margin: 0 auto 10px auto;
    line-height: 27px;
  */
}
.ketbar{
  counter-reset: step;
}
.ketbar li:after{
  content: '';
  position: absolute;
  width:100%;
  height: 3px;
  background: #979797;
  top: 11px;
  left: -50%;
  z-index: -1;
}

.ketbar li.active:before, .ketbar li.active:after {
  border-color: #3aac5d;
  background: #3aac5d;
  color: white
}
.ketbar li:first-child:after{
    content: none;
}
</style>
</body>
</html>
