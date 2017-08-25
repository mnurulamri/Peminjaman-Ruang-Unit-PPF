<?php
/*
  view untuk menampilkan daftar ruang rapat
*/

if (isset($this->session->userdata['logged_in'])) {
  $username = ($this->session->userdata['logged_in']['username']);
} else {
  header("location: http://ppf.fisip.ui.ac.id/backend/autentikasi/test_ldap_login_form");
}
?>

    <div id="list-kegiatan" class="modal fade" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="height:100%; width:100%"></div>
        </div>
    </div>
    
      <div class="row">
        <div class="col-xs-12">

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Detail Ruang Rapat</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-hover">
                <thead>
                  <tr style="background:#d2d6de">
                    <th>No</th>
                    <th>Nama Ruang</th>
                    <th>Lokasi</th>
                    <th>Fungsi</th>
                    <th>Luas Ruang</th>
                    <th>Kapasitas</th>
                    <th>Pengelola</th>
                    <th>Fasilitas</th>
                    <th>Jadwal</th>
                    <th>Daftar Kegiatan</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  foreach ($ruang as $k => $v) {
					$link = 'window.open(\''.base_url().'peminjaman/schedulerRuangRapat/ruang/'.$v->kd_ruang.'\',\'_blank\',\'toolbar=no, scrollbars=no, resizable=no, top=20, left=300, width=700, height=600\')';  
                    echo '
                    <tr>
                      <td>'.$v->kd_ruang.'</td>
                      <td>'.$v->nm_ruang.'</td>
                      <td>'.$v->lokasi.'</td>
                      <td>'.$v->fungsi.'</td>
                      <td>'.$v->luas.'</td>
                      <td>'.$v->kapasitas.'</td>
                      <td>'.$v->pengelola.'</td>
                      <td>'.$v->fasilitas.'</td>
                      
					  <td><a href="'.base_url().'peminjaman/schedulerRuangRapat/ruang/'.$v->kd_ruang.'" rel="1" target="_blank"><i class="fa fa-calendar"></i>&nbsp;view</a></td>
					  
					  <!--<td onclick="'.$link.'" style="cursor:pointer"><i class="fa fa-calendar">&nbsp;view</i></td><span id='.$v->kd_ruang.' class="test-modal">&nbsp;&nbsp;testing..</span>-->
                       <td><i id="'.$v->kd_ruang.'" class="list-modal fa fa-calendar-o" data-toggle="modal" data-target="#list-kegiatan" style="cursor:pointer"></i></td>
                    </tr>';
                  }
                ?>
                </tbody>
                <tfoot>
                  <tr style="color:#fff; ">
                    <th style="border-bottom:1px solid #fff; border-left:1px solid #fff; border-left:1px solid #fff;">No</th>
                    <th style="border-bottom:1px solid #fff; border-left:1px solid #fff; border-right:1px solid #fff;">Nama Ruang</th>
                    <th style="border-bottom:1px solid #fff; border-left:1px solid #fff; border-right:1px solid #fff;">Lokasi</th>
                    <th style="border-bottom:1px solid #fff; border-left:1px solid #fff; border-right:1px solid #fff;">Fungsi</th>
                    <th style="border-bottom:1px solid #fff; border-left:1px solid #fff; border-right:1px solid #fff;">Luas Ruang</th>
                    <th style="border-bottom:1px solid #fff; border-left:1px solid #fff; border-right:1px solid #fff;">Kapasitas</th>
                    <th style="border-bottom:1px solid #fff; border-left:1px solid #fff; border-right:1px solid #fff;">Pengelola</th>
                    <th style="border-bottom:1px solid #fff; border-left:1px solid #fff; border-right:1px solid #fff;">Fasilitas</th>
                    <th style="border-bottom:1px solid #fff; border-left:1px solid #fff; border-right:1px solid #fff;">Jadwal</th>
                    <th style="border-bottom:1px solid #fff; border-left:1px solid #fff; border-right:1px solid #fff;">Daftar Kegiatan</th>
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
      <!-- /.row -->
<?=$script?>
<!-- page script -->
<?php //echo $script?>
<script>
  $(function () {
    $("#example1").DataTable({
      scrollX:true
    });
   
	$(document).on('click', '.test-modal', function(){
		alert('test');
	});
	  
  $(document).on('click', '.list-modal', function(){
    var kd_ruang = $(this).attr('id');
    //alert(kd_ruang);

    $.ajax({
        type: "POST",
        //url: "<?=base_url()?>" + "peminjaman/daftarRuangRapat/listKegiatan",
        url: "<?=base_url()?>" + "penggunaan/ruangRapat/listKegiatan",
        data: {kd_ruang:kd_ruang},
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
  });
</script>
</body>
</html>
