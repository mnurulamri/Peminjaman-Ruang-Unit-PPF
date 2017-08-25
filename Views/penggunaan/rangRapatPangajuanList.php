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
//$username = 'badi';
//$hak_akses = 0;
?>


<div class="modal fade edit-jadwal-rapat" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"></div>
    </div>
</div>
      
    <div class="row">
        <div class="col-xs-12">

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Data Pengajuan Peminjaman Ruang</h3>
					<div class="box-tools pull right" style="color:red; border:1px solid red; font-size:10px; padding:1px 3px">
						<!--<span class="label label-warning">-->
							<i><div>Apabila status peminjaman sudah disetujui</div>
								<div>mohon segera memberikan konfirmasi bila ada pembatalan kegiatan</div></i>
						<!--</span>-->
					</div>
                </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="col-sm-8" style="text-align:center">
                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target=".modal" id="pengajuan-baru"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;<b style="font-size:14px">Pengajuan Baru</b></button> 
                </div>
                <?php

                $no = 1;
                $array_hari = array('Sun'=>'Minggu', 'Mon'=>'Senin', 'Tue'=>'Selasa', 'Wed'=>'Rabu', 'Thu'=>'Kamis', 'Fri'=>'Jumat', 'Sat'=>'Sabtu');
                $array_bulan = array('1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni', '7'=>'Juli',
                                      '8'=>'Agustus', '9'=>'September', '10'=>'Oktober', '11'=>'Nopember', '12'=>'Desember', );
                echo '
                <table id="example1" class="table table-hover">
                <thead>
                    <tr>
                        <th style="width:50px">No</th>
                        <th>Nama Kegiatan</th>
                        <th>Unit Pengguna</th>                      
                        <th style="width:50px">No. Surat</th>
                        <th>Jadwal</th>';
                        if($hak_akses > 0){
                            echo'<th>Edit|View|Del</th>';
                        } else {
                            echo '<th>View</th>';
                        }
                    echo'
                    </tr>
                </thead>
                <tbody>';
                    foreach ($data as $k_nomor => $v_nomor) {                      
                        foreach ($v_nomor as $k_event_name => $v_event_name) {
                            foreach ($v_event_name as $k_prodi => $v_prodi) {
								foreach ($v_prodi as $k_no_surat => $v_no_surat){
                                echo '
                                <tr>
                                    <td>'.$no.'</td>
                                    <td id="event_name_'.$k_nomor.'"  style="width:280px">'.$k_event_name.'</td>
                                    <td>'.$k_prodi.'</td>
                                    <td style="width:50px">'.$k_no_surat.'</td>
                                    <td style="width:380px">
                                        <table class="">';

                                        foreach ($v_no_surat as $k => $v) {
                                            //setting waktu dan tanggal
                                            $d = date('D', strtotime($v->start_date));
                                            $waktu_awal = date('H:i', strtotime($v->start_date));
                                            $waktu_akhir = date('H:i', strtotime($v->end_date));
                                            $nama_hari = $array_hari[$d];
                                            $tgl = $v->tgl;
                                            $bulan = $array_bulan[$v->bulan];
                                            $tahun = $v->tahun;

                                            echo '
                                            <tr style="border:1px solid #eee">                                      
                                                <td style="padding-left:3px; width:150px; vertical-align:top; padding-bottom:5px; border-bottom:1px solid #eee">'.$nama_hari.', '.$tgl.' '.$bulan.' '.$tahun.'</td>
                                                <td style="width:80px; vertical-align:top; padding-bottom:5px; border-bottom:1px solid #eee">'.$waktu_awal.'-'.$waktu_akhir.'</td>
                                                <td style="text-align:center; width:150px; vertical-align:top; padding-bottom:5px; border-bottom:1px solid #eee">'.$v->nm_ruang.'</td>
                                            </tr>';
                                        }  
                                        echo '
                                        </table>
                                    </td>
                                    <td id="crud_view_'.$k_nomor.'" style="text-align:top">';

                                    if($hak_akses > 0){
                                        echo'
                                        <span><i id='.$k_nomor.' data-toggle="modal" data-target=".edit-jadwal-rapat" class="edit-kegiatan fa fa-edit fa-align-center" style="color:#00a65a; font-size:20px; cursor:pointer; width:20px"></i></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <span><i id='.$k_nomor.' class="view_final fa fa-file-pdf-o fa-align-center fa-lg faa-vertical" style="color:red; cursor:pointer; width:20px"></i></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <span><i id='.$k_nomor.' rel="'.$k_event_name.'" class="del fa fa-trash fa-align-center fa-lg" style="color:red; cursor:pointer; width:20px"></i></span>';
                                    } elseif($hak_akses == 0 && $v->username == $username && $v->flag_cetak == 0) {
                                        echo'
                                        <span><i id='.$k_nomor.' data-toggle="modal" data-target=".edit-jadwal-rapat" class="edit-kegiatan '.$v->username.' fa fa-edit fa-align-center" style="color:#00a65a; font-size:20px; cursor:pointer; width:20px"></i></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <span><i id='.$k_nomor.' class="view_confirm '.$v->username.' fa fa-file-pdf-o fa-align-center fa-lg faa-vertical" style="color:red; cursor:pointer; width:20px"></i></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <span><i id='.$k_nomor.' rel="'.$k_event_name.'" class="del '.$v->username.' fa fa-trash fa-align-center fa-lg" style="color:red; cursor:pointer; width:20px"></i></span>';                             
                                    } elseif($hak_akses == 0 && $v->username == $username && $v->flag_cetak == 1) {
                                        echo'
                                        <span><i id='.$k_nomor.' class="view_final '.$v->username.' fa fa-file-pdf-o fa-align-center fa-lg faa-vertical" style="color:red; cursor:pointer; width:20px"></i></span>&nbsp;&nbsp;&nbsp;&nbsp;';
                                    } else {
                                        echo '<span><i id='.$k_nomor.'"></i><span>';
                                    }

                                    echo'
                                    </td>
                                </tr>';
                                $no++;
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
                            <th class="line-right">Jadwal</th>';

                            if($hak_akses > 0) {
                                echo '<th class="line-right">Edit|View|Del</th>';
                            } else {
                                echo '<th class="line-right">View</th>';
                            }

                            echo'
                          <!--<th class="line-right">View</th>-->
                        </tr>
                    </tfoot>
                </table>';
                ?>
            </div>
            <!-- /.box-body -->
        </div>
          <!-- /.box -->
    </div>
        <!-- /.col -->
</div>
      <!-- /.row -->

<?=$script?>

<script>
$(function () {

    //$('table#example1 tbody').load("http://ppf.fisip.ui.ac.id/backend/penggunaan/ruangRapat/datatableRuang");

    /* $(document).on('shown.bs.modal', '.modal', function(){
    $('#jadwal')
    });*/

    $(document).on('hidden.bs.modal', '.modal', function(){    
        window.location.replace("<?php echo base_url(); ?>" + "penggunaan/ruangRapat/pengajuanList");
    });

    $("#example1").DataTable({
        scrollX:true
    });
        
    $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false
    });

    $(document).on('click', '#pengajuan-baru', function(){
        //alert('test')
        $('.modal-content').load("<?=base_url()?>" + "penggunaan/ruangRapat/pengajuanAdd");
    });

    $(document).on('click', '.edit-kegiatan', function(){
        var id =  $(this).attr('id');
		
        //$(".modal-content").remove();
        //$('.modal-dialog').html('<div class="modal-content"></div>');
        $.ajax({
            type: "POST",
            url: "<?=base_url()?>" + "penggunaan/ruangRapat/pengajuanEdit",      
            data: {id:id},
            success: function(res) {
                //$(".modal-dialog").html(res);
                if (res){
                    $(".modal-content").html('').html(res);
                } else {
                    $("#event_name").html('ada error');
                }
            }
        });
    });

    $(document).on('click', '.view_final', function(){
        var event_id    = $(this).attr('id');
        window.location.assign("<?=base_url()?>" + "penggunaan/formPdf/ruangRapat/" + event_id);
    });

    //fungsi untuk menanyakan mau dicetak apa tidak, bila dicetak maka fungsi crud akan hilang
    $(document).on('click', '.view_confirm', function(){
        var event_id = $(this).attr('id');
        var nomor    = $(this).attr('id');
        var username = $(this).attr('class').split(' ');
        username     = username[1];
        var r = confirm('Apakah data yang diinput sudah benar? Mencetak form akan menghilangkan fungsi udpate data!');
        if(r==true){
            $.ajax({
                type: 'POST',
                url: "<?=base_url()?>" + "penggunaan/ruangRapat/disableCrud",
                data:{event_id:event_id, username:username},
                success: function(data){
                    $('#crud_view_'+nomor).html('<span><i id='+nomor+' class="view_final '+nomor+' fa fa-file-pdf-o fa-align-center fa-lg faa-vertical" style="color:red; cursor:pointer; width:20px"></i></span>&nbsp;&nbsp;&nbsp;&nbsp;'); 
                    window.location.assign("<?=base_url()?>" + "penggunaan/formPdf/ruangRapat/" + event_id);
                }
            });
        }
    });
    
    $(document).on('click', '.del', function(){
        var event_name = $(this).attr('rel');
        var r = confirm('Anda Yakin akan menghapus data kegiatan ' + event_name );
        if(r == true){
            var nomor = $(this).attr('id');
            $.ajax({
                type: 'POST',
                url: "<?=base_url()?>" + "penggunaan/ruangRapat/delKegiatan",
                data:{nomor:no
