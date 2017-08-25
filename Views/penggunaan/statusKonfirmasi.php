<?php
$m = date('m', strtotime($data['tgl_proses_mentah']));
$y = date('Y', strtotime($data['tgl_proses_mentah']));
$no_surat = $data['no_surat'].'/G.05/1/UN2.F9.D4.2/RTK.00/'.$m.'/'.$y;
?>
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Persetujuan Status Peminjaman</h3>
    </div>
    <div class="box-body">
        <form id="formInput" method="post" name="form" class="form-horizontal" >
            <div class="box-body">
                <div style="border-bottom:1px solid #ddd; text-align:right; color:#aaa"><b><i>Identitas Surat</i></b></div><br>
                <input type="hidden" name="id_kegiatan" id="id_kegiatan" value="<?=$data['id_kegiatan']?>" />
                <input type="hidden" class="form-control" name="status" id="status" value="<?=$data['status']?>"/>
				<input type="hidden" name="nomor" id="nomor" value="<?=$data['nomor']?>"/>
                <div class="form-inline">
                    <div class="col-sm-6">
                        <div class="input-group date">
                            <div class="input-group-addon" style="width:70px">
                                Nomor
                            </div>
                            <input id="tgl_permohonan" name="tgl_permohonan" class="form-control" value="<?=$no_surat?>" style="width:300px"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-6">
                        <div class="input-group date">
                            <div class="input-group-addon" style="width:100px">
                                Tanggal
                            </div>
                            <input id="tgl_proses" name="tgl_proses" class="form-control pull-right" value="<?=$data['tgl_proses']?>">
                        </div>                    
                    </div>
                </div>

                <div style="border-bottom:1px solid #ddd; text-align:right; color:#aaa"><b><i>Data Kegiatan</i></b></div>
                <!-- Bagian Untuk Diisi Pemohon -->
                <br>
                <div class="form-group">
                    <div class="col-sm-12">
                        <div class="input-group date">
                            <div class="input-group-addon">
                                Nama Kegiatan :
                            </div>
                            <input type="text" name="nama_kegiatan" id="nama_kegiatan" class="form-control pull-right" value="<?=$data['event_name']?>" style="width:600px"/>
                        </div>
                    </div>
                </div>

                <div class="form-inline">
                    <input class="form-control" value="Jadwal Pemakaian:" style="border:none" style="width:200px; text-align:right"/>
                    <input id="tgl_permohonan" name="tgl_permohonan" class="form-control" value="Tanggal" style="background: lightgray"/>
                    <input id="tgl_permohonan" name="tgl_permohonan" class="form-control" value="Waktu" style="background: lightgray"/>
                    <input id="tgl_permohonan" name="tgl_permohonan" class="form-control" value="Ruang" style="background: lightgray"/>                   
                </div>

                <?php
                foreach ($data['jadwal'] as $k => $v) {?>
                    <div class="form-inline">
                        <input class="form-control" value="" style="border:none" />
                        <input id="tgl_permohonan" name="tgl_permohonan" class="form-control" value="<?=$v['tgl_kegiatan']?>"/>
                        <input id="tgl_permohonan" name="tgl_permohonan" class="form-control" value="<?=$v['waktu']?>"/>
                        <input id="tgl_permohonan" name="tgl_permohonan" class="form-control" value="<?=$v['ruang']?>"/>
                    </div>
                <?php
                }
                ?>
                <br>
                <div class="form-group">
                    <div class="col-sm-12"> 
                        <div class="input-group date">
                            <div class="input-group-addon">
                                Jumlah Peserta :
                            </div>
                            <input type="text" id="jml_peserta" name="jml_peserta" value="<?=$data['jml_peserta']?>" class="form-control input-md" required="">                      
                        </div>
                    </div>                        
                </div>   
                <div class="form-group">
                    <div class="col-sm-12"> 
                        <div class="input-group date">
                            <div class="input-group-addon">
                                Kebutuhan Tambahan :
                            </div>
                            <input id="kebutuhan" name="kebutuhan" value="<?=$data['kebutuhan']?>" class="form-control input-md" required="" type="text">                      
                        </div>
                    </div>                        
                </div>
                <div style="border-bottom:1px solid #ddd; text-align:right; color:#aaa"><b><i>Data Pemohon</i></b></div>
                <br>
                <div class="form-group">
                    <!--<label for="tgl_permohonan" class="col-sm-2 control-label" style="text-align:right">Tanggal : </label>-->
                    <div class="col-sm-12">
                        <div class="input-group date">
                            <div class="input-group-addon" style="width:200px">
                                Tanggal Permohonan :
                            </div>
                            <input id="tgl_permohonan" name="tgl_permohonan" class="form-control" value="<?=$data['tgl_permohonan']?>"/>
                        </div>
                    </div>
                </div>   
                <div class="form-group">
                    <div class="col-sm-12">  
                        <div class="input-group date">
                            <div class="input-group-addon">
                                Program Studi/Unit :
                            </div>
                            <input type="text" name="prodi" id="prodi" class="form-control pull-right" value="<?=$data['prodi']?>"/>
                        </div>  
                    </div>
                </div>
                <div class="form-group">            
                    <div class="col-sm-6">
                        <div class="input-group date">
                            <div class="input-group-addon">
                                Penanggung Jawab :
                            </div>
                            <input type="text" id="nama_peminjam" name="nama_peminjam" value="<?=$data['nama_peminjam']?>" class="form-control input-md"/>
                        </div>                     
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group date">
                            <div class="input-group-addon" >
                                NPM/NIP/NUP :
                            </div>
                            <input type="text" id="id_peminjam" name="id_peminjam" value="<?=$data['id_peminjam']?>" class="form-control input-md" />
                        </div>
                    </div>
                </div>   
                <div class="form-group">
                     <div class="col-sm-6">
                        <div class="input-group date">
                            <div class="input-group-addon">
                                No. Telepon :
                            </div>
                            <input type="text" id="no_telp" name="no_telp" value="<?=$data['no_telp']?>" class="form-control input-md" required=""/>
                        </div>                  
                     </div>   
                    <div class="col-sm-6">
                        <div class="input-group date">
                            <div class="input-group-addon">
                               E-mail :
                            </div>
                            <input type="text" id="email" name="email" value="<?=$data['email']?>" class="form-control input-md" required=""/>
                        </div>                    
                    </div>                        
                </div>  

            </div>
        </form> 
    </div>
    <div class="box-footer">
        <div class="pesan" class="alert alert-success" role="alert"></div>
        <div id="process-info" style="display:none; text-align:center"><img src="<?=base_url();?>assets/images/spinner.gif"/></div>
        <span id="alert-riwayat" class="alert alert-success" role="alert" role="alert" style="display:none">Data sudah disimpan..</span>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <span><button class="setujui btn btn-info pull-right" data-dismiss="modal">Beri Persetujuan</button></span>
    </div>
</div>

<style>
.right {text-align: right; padding-right: 5px}
.input-group-addon {width:200px; text-align:right; border:none;}
</style>

<script>
/*function setujui(){

}*/


$(document).ready(function() {  //blm berfungsi
    //$(document).on('click', '.setujui', function(){
   $('.setujui').unbind('click').click(function(){
    var nama_kegiatan = $('#nama_kegiatan').val();
    var id_kegiatan = $('#id_kegiatan').val();
	   var nomor = $('#nomor').val();
    var status = $('#status').val();
    var status_id = 'status_'+nomor;
    //alert(status_id + ' ' + nama_kegiatan +' '+id_kegiatan)

    //rubah status ke hak akses yang lebih tinggi
    if(status == 1){
        status = 2;
    } else if(status == 2){
        status = 3;
    } else {
        status = 1;
    }

    var pesan;
    var r = confirm('Anda yakin akan memberikan persetujuan untuk kegiatan '+ nama_kegiatan +'?');
    if(r == true){
        //alert(status_id + ' ' + nama_kegiatan +' '+id_kegiatan)
        $.ajax({
            type: "POST",
            url: "<?=base_url()?>" + "penggunaan/ruangRapat/statusKonfirmasiPersetujuan",      
            data: {id_kegiatan:id_kegiatan, status:status},
            success: function(res) {            
                if (res){
                    $('#'+status_id).html(res);
                } else {
                    $(".pesan").html('ada error');
                }
            }
        });
    } 

        //$('.pesan').html('testing');
    });
});
</script>