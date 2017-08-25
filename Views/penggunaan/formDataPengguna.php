<?php

if (count($data)==0) {
	$username 		= '';
	$nama_peminjam 	= '';
	$prodi 			= '';
	$id_peminjam 	= '';
	$no_telp 		= '';
	$email 			= '';
} else {
	foreach ($data as $k => $v) {
		$username 		= $v->user_name;
		$nama_peminjam 	= $v->nama_peminjam;
		$prodi 			= $v->prodi;
		$id_peminjam 	= $v->id_peminjam;
		$no_telp 		= $v->no_telp;
		$email 			= $v->user_email;
	}
}

?>
<!-- Horizontal Form -->
<div class="box box-info">
	<div class="box-header with-border">
		<h3 class="box-title">Data Pengguna</h3>
	</div>
	<!-- /.box-header -->
	
	<!-- form start -->
	<form id="formInput" method="post" name="form" class="form-horizontal" >
		<div class="box-body">
	        <!-- Bagian Untuk Diisi Pemohon -->
	        <br>
            <div class="form-group">
                <label for="nama_peminjam" class="col-sm-2 control-label" style="text-align:right">Nama Penanggung Jawab : </label>              
                <div class="col-sm-9">
 					<div class="input-group date">
						<div class="input-group-addon">
							<i class="glyphicon glyphicon-user"></i>
						</div>
						<input type="text" id="nama_peminjam" name="nama_peminjam" value="<?=$nama_peminjam?>" placeholder="nama peminjam" class="form-control input-md" required="">
					</div>                     
                </div>
            </div> 	        
			<div class="form-group">
				<label class="col-sm-2 control-label">Program Studi/Unit :</label>
				<div class="col-sm-9">  
					<div class="input-group date">
						<div class="input-group-addon">
							<i class="glyphicon glyphicon-briefcase"></i>
						</div>
						<input type="text" name="prodi" id="prodi" value="<?=$prodi?>" class="form-control pull-right"/>
					</div>	
				</div>
			</div>

            <div class="form-group">
                <label for="id_peminjam" class="col-sm-2 control-label" style="text-align:right">NPM/NIP/NUP : </label>
                <div class="col-sm-9">
 					<div class="input-group date">
						<div class="input-group-addon">
							<i class="glyphicon glyphicon-tag"></i>
						</div>
                    	<input type="text" id="id_peminjam" name="id_peminjam" value="<?=$id_peminjam?>" placeholder="NPM/NIP/NUP" class="form-control input-md" required="">
					</div>
                </div>
            </div>   
            <div class="form-group">
                <label for="no_telp" class="col-sm-2 control-label" style="text-align:right">No. Telepon : </label>
                 <div class="col-sm-9">
 					<div class="input-group date">
						<div class="input-group-addon">
							<i class="glyphicon glyphicon-phone-alt"></i>
						</div>
                     	<input type="text" id="no_telp" name="no_telp" value="<?=$no_telp?>" placeholder="Nomor Telepon" class="form-control input-md" required="">
					</div>              	
                 </div>                        
            </div>
            <div class="form-group">  
                <label for="email" class="col-sm-2 control-label" style="text-align:right">E-mail :</label>
                <div class="col-sm-9">
					<div class="input-group date">
						<div class="input-group-addon">
							<i class="glyphicon glyphicon-envelope"></i>
						</div>
						<input type="text" id="email" name="email" value="<?=$email?>" placeholder="e-mail" class="form-control input-md" required="">
					</div>
                    
                </div>                        
            </div>  
            <div style="border-top:1px solid #ddd">&nbsp;</div>
		</div>
	</form>	
		<!-- /.box-body -->
		<div class="box-footer">
			<div class="pesan" class="alert alert-success" role="alert" style="display:none"></div>
			<div id="process-info" style="display:none; text-align:center"><img src="<?=base_url();?>assets/images/spinner.gif"/></div>
			<span id="alert-riwayat" class="alert alert-success" role="alert" role="alert" style="display:none">Data sudah disimpan..</span>
			<span><button class="simpan btn btn-info pull-right" class="submit">Simpan</button></span>
		</div>
		<!-- /.box-footer -->
</div>
<?=$script?>
<script type="text/javascript">
$('.simpan').click(function(){
	
	var nama_peminjam 	= $('#nama_peminjam').val();
	var prodi 			= $('#prodi').val();
	var id_peminjam 	= $('#id_peminjam').val();
	var no_telp 		= $('#no_telp').val();
	var email 			= $('#email').val();

	$.ajax({
		type: "POST",
		url: "<?=base_url()?>" + "penggunaan/ruangRapat/updateDataUser",			
		data: {
			nama_peminjam:nama_peminjam, 
			prodi:prodi, 
			id_peminjam:id_peminjam, 
			no_telp:no_telp, 
			email:email
		},
		success: function(data) {
			if (data)
			{
				$("#process-info").hide();
				//$("#alert-riwayat").fadeIn();
				//$("#alert-riwayat").fadeOut(2300);
				$('.pesan').html(data);
				$(".pesan").fadeIn();
				$(".pesan").fadeOut(2300);
			} else {
				alert('ada error');
			}
		}
	});
});
</script>