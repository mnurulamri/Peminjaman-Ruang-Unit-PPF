<?php
if(!empty($posts)){
	test($posts, $data_jadwal);
} else {
	echo '<p>Post(s) not available.</p>';
}

echo $this->ajax_pagination->create_links();

function test($posts, $data_jadwal){
  $hak_akses = 1;
  header_table();
  content_table($posts, $data_jadwal);
  footer_table();
}

function content_table($posts, $data_jadwal){
    foreach ($posts as $rows) {
		echo '<tr><td>'.$rows['id_kegiatan'].'</td></tr>';
    }

    foreach ($data_jadwal as $rows) {
        $jadwal[$rows['id_kegiatan']][$rows['start_date']][] = $rows;
    }

    echo '<pre>';
    //print_r($jadwal);
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
?>