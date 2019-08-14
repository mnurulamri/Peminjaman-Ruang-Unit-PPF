<?php
$m = date('m', strtotime($data['tgl_proses_mentah']));
$y = date('Y', strtotime($data['tgl_proses_mentah']));
$no_surat = $data['no_surat'].'/G.05/1/UN2.F9.D4.2/RTK.00/'.$m.'/'.$y;
?>
<div class="box box-info">
    <div class="box-header with-border" style="text-align:center">
        <h3 class="box-title">PERMOHONAN PEMAKAIAN RUANGAN</h3>
    </div>
    <div class="box-body">
    
    <table border="0" cellspacing="0" cellpadding="0" class="table" width="100%">
	    <tr>
		    <td colspan="2" class="right">
			    Nomor : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$no_surat?>
		    </td>
		    <td colspan="2" >
			    Tanggal : <?=$data['tgl_proses']?>
		    </td>
	    </tr>
	    <tr>
		    <td colspan="4" class="sub-head" ><b>Data Kegiatan</b></td>
	    </tr>
	    <tr>
		    <td class="right">Nama Kegiatan :</td>
		    <td colspan="3"> <?=$data['event_name']?> </td>
	    </tr>
	    <tr>
		    <td class="right">
			    Lokasi dan Jadwal Pemakaian :
		    </td>
		    <td colspan="3">
			    <table border="0" cellspacing="0" cellpadding="0" class="jadwal table">
				    <tr>
					    <td>Tanggal</td>
					    <td>Waktu </td>
					    <td>Ruang</td>
				    </tr>
					    <?php
                foreach ($data['jadwal'] as $k => $v) {?>
                    <tr>
                        <td> <?=$v['tgl_kegiatan']?> </td>
                        <td> <?=$v['waktu']?> </td>
                        <td> <?=$v['ruang']?> </td>
                    </tr>
                <?php
                }
                ?>
			    </table>
		    </td>
	    </tr>
	    <tr>
		    <td class="right">Jumlah peserta : </td>
		    <td colspan="3"> <?=$data['jml_peserta']?> </td>
	    </tr>
	    <tr>
		    <td class="right">Kebutuhan :</td>
		    <td colspan="3" > <?=$data['kebutuhan']?> </td>
	    </tr>
	    <tr>
		    <td colspan="4" class="sub-head"><b>Data Pemohon</b></td>
	    </tr>
	    <tr>
		    <td class="right"> Tanggal Permohonan : </td>
		    <td colspan="3"> <?=$data['tgl_permohonan']?> </td>
	    </tr>
	    <tr>
		    <td class="right"> Program Studi/Unit : </td>
		    <td colspan="3"> <?=$data['prodi']?> </td>
	    </tr>
	    <tr>
		    <td class="right"> Penanggung Jawab : </td>
		    <td colspan="3"> <?=$data['nama_peminjam']?> </td>
	    </tr>
	    <tr>
		    <td class="right"> NPM/NIP/NUP : </td>
		    <td colspan="3"> <?=$data['id_peminjam']?> </td>
	    </tr>
	    <tr>
		    <td class="right">No. Telepon</td>
		    <td><?=$data['no_telp']?></td>
		    <td>e-Mail</td>
		    <td><?=$data['email']?></td>
	    </tr>
	    <tr>
		    <td colspan="4" class="sub-head"> Contoh layout publikasi / kopi surat harap dilampirkan </td>
	    </tr>
	    <tr>
		    <td colspan="4" > 
			    Catatan <br>
			    <?=$data['catatan']?>
		    </td>
		  </tr>
	    <tr>  
		    <td colspan="4">  </td>
	    </tr>
	    
    </table> 
    
    </div>
    
    <div class="box-footer">
        <div class="pesan" class="alert alert-success" role="alert"></div>
        <div id="process-info" style="display:none; text-align:center"><img src="<?=base_url();?>assets/images/spinner.gif"/></div>
        <span id="alert-riwayat" class="alert alert-success" role="alert" role="alert" style="display:none">Data sudah disimpan..</span>
        <button type="button" class="tutup-konfirm-cetak btn btn-danger" data-dismiss="modal">Tutup</button>
        <span><button id="<?=$data['nomor'].'_'.$username?>" class="cetak btn btn-info pull-right" data-dismiss="modalx">Cetak (pdf)</button></span>
    </div>
</div>

<style>
.right {text-align: right; padding-right: 5px}
.input-group-addon {width:200px; text-align:right; border:none;}
.sub-head {background:rgb(210,214,222); text-align:center;}
table.jadwal tr td { border:1px solid #eee}
</style>

<script>
/*function setujui(){

}


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
            url: "<?=base_url()?>" + "administrasi/ruang/statusKonfirmasiPersetujuan",      
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
});*/
</script>