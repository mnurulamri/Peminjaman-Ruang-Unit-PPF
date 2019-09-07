
<?php
/*print_r($data_kegiatan);
print_r($data_jadwal);
print_r($data_kegiatan_entitas);}*/
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

	if (count($organisasi)>0) {
    	foreach ($organisasi as $k => $v) {
    		$organisasi = $v->programstudi;
    	}
    } else {
    	$organisasi = $prodi;
    }  
}




//$organisasi = ($organisasi=='') ? '' : $organisasi;

function isian($data){
	$str = str_replace('<p>', '', $data);
	$str = str_replace('</p>', '<br>', $str);
	echo '
				<table>
					<tr>
						<td width="13px"></td>
						<td width="375px">'.$str.'</td>
					</tr>
				</table>';
}
?>

	<table class="form-table" border="0" cellpadding="3px">
		<!--
		<tr>
			<th><img src="https://ppf.fisip.ui.ac.id/backend/assets/images/logo-fisip.png"></th>
			<th colspan="3" style="font-weight:bold; font-style:dejavusans; paddin-top:15px; line-height:10px">
				<div style="font-size:16px">FORMULIR PERMOHONAN PENGGUNAAN RUANGAN</div>
				<div>(KHUSUS MAHASISWA FISIP UI)</div>
			</th>
		</tr>
		-->
		<tr>
			<td colspan="2" class="label" width="270px">Nomor:        /G.05/1/UN2/F9.D4.2/RTK.00/2019</td>			
			<td colspan="2" class="" width="404px">&nbsp;&nbsp;&nbsp;&nbsp;Tanggal: <?=dbToTanggal($tgl_permohonan)?></td>			
		</tr>		
		<tr>
			<td colspan="2" class="label">Identitas Peminjam</td>
			<td colspan="2"><?=checkbox_entitas($data_kegiatan_entitas)?></td>
		</tr>
		<tr>
			<td colspan="2" class="label">Nama Penanggung Jawab</td>
			<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<?=$nama_peminjam?></td>
		</tr>	
		<tr>
			<td colspan="2" class="label">Organisasi</td>
			<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<?=$prodi?></td>
		</tr>
		<tr>
			<td colspan="2" class="label">NPM</td>
			<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<?=$id_peminjam?></td>
		</tr>
		<tr>
			<td colspan="2" class="label">Program Studi</td>
			<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<?=$organisasi?></td>
		</tr>
		<tr>
			<td colspan="2" class="label">Nomor Telepon</td>
			<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<?=$no_telp?></td>
		</tr>
		<tr>
			<td colspan="2" class="label">e-Mail</td>
			<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<?=$email?></td>
		</tr>	
		<tr>
			<td colspan="2" class="label">Kategori</td>
			<td colspan="2"><?=checkbox_kategori($data_kegiatan_kategori)?></td>
		</tr>
		<tr>
			<td colspan="2" class="label">Jenis</td>
			<td colspan="2"><?=checkbox_jenis($data_kegiatan_jenis)?></td>
		</tr>
		<tr>
			<td colspan="2" class="label">Nama Acara/Kegiatan</td>
			<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<?=$event_name?></td>
		</tr>
		<tr>
			<td colspan="2" class="label">Tema Acara/Kegiatan</td>
			<td colspan="2"><?isian($tema)?></td>
		</tr>
		<tr>
			<td colspan="2" class="label">Deskripsi Acara/Kegiatan</td>
			<td colspan="2"><?isian($deskripsi)?></td>
		</tr>
		<tr>
			<td colspan="2" class="label">Pengisi Acara</td>
			<td colspan="2"><?isian($pengisi_acara)?></td>
		</tr>
		<tr>
			<td colspan="2" class="label">Lampiran</td>
			<td colspan="2">
				<?=checkmark_lampiran($file_tor, $file_rundown, $file_undangan, $file_lampiran)?>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="label">Peserta</td>
			<td colspan="2">
				<?=checkbox_peserta($data_kegiatan_peserta)?>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="label">Jumlah Peserta</td>
			<td colspan="2">
				<?=$jml_peserta?>
			</td>
		</tr>
		
		<tr>
			<td colspan="2" class="label">Lokasi dan Jadwal Penggunaan Ruang</td>
			<td colspan="2">
                <table class="table">
                    <tr style="background-color:lightgray">
                        <th width="100px" style="text-align:center;border-bottom:1px solid #fff">Lokasi/Area/Ruang</th>
                        <th width="175px" style="text-align:center;border-bottom:1px solid #fff">Tanggal</th>
                        <th width="115px" style="text-align:center;border-bottom:1px solid #fff">Waktu</th>
                    </tr>
                    <?php print_r(cetak_jadwal_konfirmasi($ruang, $data_jadwal)); ?>
                </table>
			</td>
		</tr>
		
		<tr>
			<td colspan="4" class="labelx" style="border-left:3px solid #fff;border-right:3px solid #fff";>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="4" class="labelx" style="text-align:center;background-color:#d2d6de">PERSETUJUAN</td>
		</tr>
		<tr>
			<td colspan="2" class="label">Status</td>
			<td colspan="2">
				<?=checkmark_status($status)?>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="label">Keterangan/Penjelasan</td>
			<td colspan="2">
				<?=$alasan?>
			</td>
		</tr>
		<tr>
			<td colspan="4" class="labelx" style="border-left:3px solid #fff;border-right:3px solid #fff;border-bottom:3px solid #fff;">&nbsp;</td>
		</tr>
		
		<p style="page-break-after:always"></p>
		<tr>
			<td colspan="4" class="labelx" style="border-left:3px solid #fff;border-right:3px solid #fff;">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="4" class="labelx" style="text-align:center;background-color:#d2d6de">PENGESAHAN</td>
		</tr>
		<tr>
			<td>
				<?php
				$str = '&nbsp;';
				$spasi = '';
				for ($i=0; $i < 60; $i++) { 
					$spasi .= $str;  
				}
				$spasi = '<u>'.$spasi.'</u>';
				?>
				<table border="0" style="margin:auto; width:100%; padding:15px; font-weight: bold">
					<tr>
						<td style="text-align:center;width:334px">
							Untuk Kegiatan Himpunan Mahasiswa<br>Ketua <?=$organisasi?><br><br><br><br><br><br>(<?=$spasi?>)<br><br>NIP/NUP. <?=$spasi?>
						</td>
						<td style="text-align:center;width:334px">
							Ketua BEM/Lembaga/Himpunan<br><br><br><br><br><br><br>(<?=$spasi?>)<br><br>NPM. <?=$spasi?>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="text-align:center;">
							Wakil Manajer Bidang Khusus Kemahasiswaan<br><br><br><br><br>(<u>Bhakti Eko Nugroho, M.A.</u>)<br>NUP. 091603022
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>


<style type="text/css">
table.form-table {
	margin:auto;
	border: 1px solid black;
}
table.form-table tr td, th {
	font-family: arial;
	font-size: 10px;
	padding: 25px;
	border-bottom: 1px solid black;
}
.label {
	padding-top: 25px;
	border-right: 1px solid black;
	text-align:right;
}
.labelx {
	font-weight: bold;
}
.dok {
	border-bottom: 1px solid gray;
}
</style>