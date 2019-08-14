<?php
/*print_r($data_kegiatan);exit();
print_r($data_jadwal);
print_r($data_kegiatan_entitas);*/

foreach ($data_kegiatan as $k => $v) {
    $nomor          = $v['nomor'];
    $event_name     = $v['event_name'];
    $nama_peminjam  = $v['nama_peminjam'];
    $id_peminjam    = $v['id_peminjam'];
    $prodi          = $v['prodi'];
    //$tgl_permohonan = (!empty($v['tgl_permohonan'])) ? $v['tgl_permohonan'] : '2019-07-22';
	$tgl_permohonan = $v['tgl_permohonan'];
    $tgl_proses 	= $v['tgl_proses'];
    $catatan        = $v['catatan'];
    $kebutuhan      = $v['details'];
    $jml_peserta    = $v['jml_peserta'];
    $no_telp        = $v['no_telp'];
    $email          = $v['email'];
    $tema           = $v['tema'];
    $deskripsi      = $v['deskripsi'];
    $tujuan         = $v['tujuan'];
    $pengisi_acara  = $v['pengisi_acara'];
    $file_tor       = $v['file_tor'];
    $file_rundown   = $v['file_rundown'];
    $file_undangan  = $v['file_undangan'];
    $file_lampiran  = $v['file_lampiran'];
    $status  = $v['status'];
    $alasan  = $v['alasan'];
    $username  = $v['username'];
}
?>
	
<div class="box box-info">
    <div class="box-header with-border" style="text-align:center">
        <h3 class="box-title">konfirmasi</h3>
    </div>
    <div class="box-body">
    	<table class="table-konfirmasi" cellspacing="0" width="90%">
    	<tr>
			<td colspan="4" class="sub-head">Data Pemohon</td>
		</tr>
		<tr>
			<td colspan="2" class="labelx" width="270px">Nomor:        /G.05/1/UN2/F9.D4.2/RTK.00/2019</td>			
			<td colspan="2" class="" width="404px">Tanggal: <?=dbToTanggal($tgl_permohonan)?></td>			
		</tr>		
		<tr>
			<td colspan="2" class="labelx">Identitas Peminjam</td>
			<td colspan="2">
				<?php
				$string = checkbox_entitas($data_kegiatan_entitas);
				echo rubah_checkbox($string);
				?>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="labelx">Nama Penanggung Jawab</td>
			<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<?=$nama_peminjam?></td>
		</tr>	
		<tr>
			<td colspan="2" class="labelx">Organisasi</td>
			<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<?=$prodi?></td>
		</tr>
		<tr>
			<td colspan="2" class="labelx">NPM</td>
			<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<?=$id_peminjam?></td>
		</tr>
		<tr>
			<td colspan="2" class="labelx">Program Studi</td>
			<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<?=$prodi?></td>
		</tr>
		<tr>
			<td colspan="2" class="labelx">Nomor Telepon</td>
			<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<?=$no_telp?></td>
		</tr>
		<tr>
			<td colspan="2" class="labelx">e-Mail</td>
			<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<?=$email?></td>
		</tr>
		<tr>
			<td colspan="4" style="border-left:1px solid #fff; border-right:1px solid #fff;">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="4" class="sub-head">Data Kegiatan</td>
		</tr>
		<tr>
			<td colspan="2" class="labelx">Kategori</td>
			<td colspan="2"><?=rubah_checkbox(checkbox_kategori($data_kegiatan_kategori))?></td>
		</tr>
		<tr>
			<td colspan="2" class="labelx">Jenis</td>
			<td colspan="2"><?=rubah_checkbox(checkbox_jenis($data_kegiatan_jenis))?></td>
		</tr>
		<tr>
			<td colspan="2" class="labelx">Nama Acara/Kegiatan</td>
			<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<?=$event_name?></td>
		</tr>
		<tr>
			<td colspan="2" class="labelx">Tema Acara/Kegiatan</td>
			<td colspan="2">
				<?php
					$str = str_replace('<p>', '', $tema);
					$str = str_replace('</p>', '<br>', $str);
					echo '&nbsp;&nbsp;&nbsp;&nbsp;'.$str;
				?>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="labelx">Deskripsi Acara/Kegiatan</td>
			<td colspan="2">
				<?php
					$str = str_replace('<p>', '', $deskripsi);
					$str = str_replace('</p>', '<br>', $str);
					echo '&nbsp;&nbsp;&nbsp;&nbsp;'.$str;
				?>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="labelx">Pengisi Acara</td>
			<td colspan="2">
				<?php
					$str = str_replace('<p>', '', $pengisi_acara);
					$str = str_replace('</p>', '<br>', $str);
					echo '&nbsp;&nbsp;&nbsp;&nbsp;'.$str;
				?>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="labelx">Lampiran</td>
			<td colspan="2">
				<?=rubah_checkbox(checkmark_lampiran($file_tor, $file_rundown, $file_undangan, $file_lampiran))?>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="labelx">Peserta</td>
			<td colspan="2">
				<?=rubah_checkbox(checkbox_peserta($data_kegiatan_peserta))?>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="labelx">Jumlah Peserta</td>
			<td colspan="2">
				<?=$jml_peserta?>
			</td>
		</tr>
		<tr>
			<td colspan="4" style="border-left:1px solid #fff; border-right:1px solid #fff;">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="4" class="sub-head">Lokasi dan Jadwal Penggunaan Ruangan</td>
		</tr>
		<tr>
			<td colspan="4" style="padding:3px">
                <table class="table">
                    <tr>
                        <td width="97px" style="text-align:center">Lokasi/Area/Ruangan</td>
                        <td width="175px" style="text-align:center">Tanggal</td>
                        <td width="25px" style="text-align:center">Waktu</td>
                    </tr>
                    <?php print_r(cetak_jadwal_konfirmasi($ruang, $data_jadwal)); ?>
                </table>
			</td>
		</tr>
	</table>
	</div>
    
    <div class="box-footer">
        <div class="pesan" class="alert alert-success" role="alert"></div>
        <div id="process-info" style="display:none; text-align:center"><img src="<?=base_url();?>assets/images/spinner.gif"/></div>
        <span id="alert-riwayat" class="alert alert-success" role="alert" role="alert" style="display:none">Data sudah disimpan..</span>
        <button type="button" class="tutup-konfirm-cetak btn btn-danger" data-dismiss="modal">Tutup</button>
        <span><button id="<?=$nomor.'_'.$username?>" class="cetak btn btn-info pull-right" data-dismiss="modalx">Cetak (pdf)</button></span>
    </div>
</div>

<style>
table.table-konfirmasi {
	margin:auto;
}
table.table-konfirmasi tr td {
	border: 1px solid rgb(210,214,222); 
	font-size: 13px;
}
.labelx {
	text-align:right;
	padding-right: 3px;
}
.right {text-align: right; padding-right: 5px}
.input-group-addon {width:200px; text-align:right; border:none;}
.sub-head {background:rgb(210,214,222); text-align:center; font-weight: bold;}
</style>