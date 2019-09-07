<pre>
<?php
/*print_r($data_kegiatan);
print_r($organisasi) ;
print_r($data_jadwal);
print_r($organisasi);*/
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
    		echo $v->programstudi;
    	}
    } else {
    	echo '0';
    }
    echo date('Y-m-d h:i:s');
}
?>
</pre>
<!DOCTYPE html>
<html>

<body width="100%">
	<table cellspacing="0" border="1" width="80%">
		<tr>
			<th>LOGO FISIP</th>
			<th colspan="3">FORMULIR PERMOHONAN PENGGUNAAN RUANGAN<br>(KHUSUS MAHASISWA FISIP UI)</th>
		</tr>
		<tr>
			<td class="label">Nomor</td>
			<td>_______/G.05/1/UN2/F9.D4.2/RTK.00/2019</td>
			<td class="label">Tanggal</td>
			<td><?=dbToTanggal($tgl_permohonan)?></td>
		</tr>
		<tr>
			<td colspan="4" class="label">IDENTITAS PEMINJAM</td>
		</tr>
		<tr>
			<td colspan="4"><?=checkbox_entitas($data_kegiatan_entitas)?></td>
		</tr>
		<tr>
			<td colspan="2" class="label">NAMA PENGANGGUNG JAWAB</td>
			<td colspan="2"><?=$nama_peminjam?></td>
		</tr>	
		<tr>
			<td colspan="2" class="label">ORGANISASI</td>
			<td colspan="2"><?=$prodi?></td>
		</tr>
		<tr>
			<td colspan="2" class="label">NPM</td>
			<td colspan="2"><?=$id_peminjam?></td>
		</tr>
		<tr>
			<td colspan="2" class="label">PROGRAM STUDI</td>
			<td colspan="2"><?=$prodi?></td>
		</tr>
		<tr>
			<td colspan="2" class="label">NOMOR TELEPON</td>
			<td colspan="2"><?=$no_telp?></td>
		</tr>
		<tr>
			<td colspan="2" class="label">EMAIL</td>
			<td colspan="2"><?=$email?></td>
		</tr>	
		<tr>
			<td colspan="2" class="label">KATEGORI</td>
			<td colspan="2"><?=checkbox_kategori($data_kegiatan_kategori)?></td>
		</tr>
		<tr>
			<td colspan="2" class="label">JENIS</td>
			<td colspan="2"><?=checkbox_jenis($data_kegiatan_jenis)?></td>
		</tr>
		<tr>
			<td colspan="2" class="label">NAMA ACARA/KEGIATAN</td>
			<td colspan="2"><?=$event_name?></td>
		</tr>
		<tr>
			<td colspan="2" class="label">TEMA ACARA/KEGIATAN</td>
			<td colspan="2"><?=$tema?></td>
		</tr>
		<tr>
			<td colspan="2" class="label">DESKRIPSI ACARA/KEGIATAN</td>
			<td colspan="2"><?=$deskripsi?></td>
		</tr>
		<tr>
			<td colspan="2" class="label">PENGISI ACARA</td>
			<td colspan="2"><?=$pengisi_acara?></td>
		</tr>
		<tr>
			<td colspan="2" class="label">LAMPIRAN</td>
			<td colspan="2">
				<?=checkmark_lampiran($file_tor, $file_rundown, $file_undangan, $file_lampiran)?>
              <table>
	                <tr>
	                    <td class="label">TOR Acara/Kegiatan</td>
                        <?php
                        if ($file_tor!='') {
                            echo '<td id="file_tor" class="nama_file view-dok" data-file="'.$file_tor.'" data-ext="'.ekstensi_file($file_tor).'">'.$file_tor.'</td>';
                        } else {
                            echo '<td></td>';
                        }
                        
                        ?>
	                    <!--<td id="file_tor" class="nama_file view-dok" data-file="<?=$file_tor?>" data-ext="<?=ekstensi_file($file_tor)?>"><?=$file_tor?></td>-->
	                </tr>
	                <tr>
	                    <td class="label">Rundown Acara/Kegiatan</td>
                        <?php
                        if ($file_rundown!='') {
                            echo '<td id="file_rundown" class="nama_file view-dok" data-file="'.$file_rundown.'" data-ext="'.ekstensi_file($file_rundown).'">'.$file_rundown.'</td>';
                        } else {
                            echo '<td></td>';
                        }
                        ?>
	                    <!--<td id="file_rundown" class="nama_file view-dok" data-file="<?=$file_rundown?>" data-ext="<?=ekstensi_file($file_rundown)?>"><?=$file_rundown?></td>-->
	                </tr>
	                <tr>
	                	<td class="label">Undangan Resmi</td>
                        <?php
                        if ($file_undangan!='') {
                            echo '<td id="file_undangan" class="nama_file view-dok" data-file="'.$file_undangan.'" data-ext="'.ekstensi_file($file_undangan).'">'.$file_undangan.'</td>';
                        } else {
                            echo '<td></td>';
                        }
                        ?>
	                    <!--<td id="file_undangan" class="nama_file view-dok" data-file="<?=$file_undangan?>" data-ext="<?=ekstensi_file($file_undangan)?>"><?=$file_undangan?></td>-->
	                </tr>
	                <tr>
	                    <td class="label">Lampiran Penting Lainnya</td>
                        <?php
                        if ($file_lampiran!='') {
                            echo '<td id="file_lampiran" class="nama_file view-dok" data-file="'.$file_lampiran.'" data-ext="'.ekstensi_file($file_lampiran).'">'.$file_lampiran.'</td>';
                        } else {
                            echo '<td></td>';
                        }
                        ?>
	                    <!--<td id="file_lampiran" class="nama_file view-dok" data-file="<?=$file_lampiran?>" data-ext="<?=ekstensi_file($file_lampiran)?>"><?=$file_lampiran?></td>-->
	                </tr>
	              </table>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="label">PESERTA</td>
			<td colspan="2">
				<?=checkbox_peserta($data_kegiatan_peserta)?>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="label">JUMLAH PESERTA</td>
			<td colspan="2">
				<?=$jml_peserta?>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="label">LOKASI DAN JADWAL PENGGUNAAN RUANG</td>
			<td colspan="2">
                <table class="table">
                    <tr>
                        <th width="97px" style="text-align:center">Lokasi/Area/Ruangan</th>
                        <th width="175px" style="text-align:center">Tanggal</th>
                        <th width="25px" style="text-align:center">Waktu</th>
                    </tr>
                    <?php print_r(cetak_jadwal_konfirmasi($ruang, $data_jadwal)); ?>
                </table>
			</td>
		</tr>
		<tr>
			<td colspan="4" class="label" style="text-align:center">PERSETUJUAN</td>
		</tr>
		<tr>
			<td colspan="2" class="label" style="text-align:center">Untuk Kegiatan Himpunan Mahasiswa<br>Ketua Program Sarjana<br><br><br>(________________________________________)<br>Dr......<br>NIP: ......</td>
			<td colspan="2" class="label" style="text-align:center">Untuk Kegiatan Himpunan Mahasiswa<br>Ketua Program Sarjana<br><br><br>(________________________________________)<br>Dr......<br>NIP: ......</td>
		</tr>
		<!--
		<tr>
			<td colspan="2" rowspan="2" class="label" style="text-align:center">Wakil Manajer Bidang Khusus Kemahasiswaan<br>Ketua Program Sarjana<br><br><br>(________________________________________)<br>Bhakti Eko Nugroho, M.A.<br>NUP: ......</td>
			<td colspan="3" class="label" style="text-align:center; border-top:1px solid black; border-bottom:1px solid black">KETERANGAN/PENJELASAN</td>
		</tr>
		<tr>
			<td></td>
		</tr>
		-->
		<tr>
			<td colspan="2" class="label" style=" border-bottom: 1px solid #fff; text-align:center">Wakil Manajer Bidang Khusus Kemahasiswaan</td>
			<td colspan="3" class="label" style="text-align:center; border-top:1px solid black; border-bottom:1px solid black">KETERANGAN/PENJELASAN</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
			<td colspan="2" style="padding:0px;">
				<?=checkmark_status($status)?>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="label" style="border-top: 1px solid #fff; text-align:center"><br><br>(________________________________________)<br>Bhakti Eko Nugroho, M.A.<br>NUP: ......</td>
			<td colspan="3"><?=$alasan?></td>
		</tr>
		<tr>
			
		</tr>
	</table>
</body>
</html>


<style type="text/css">
table {
	margin:auto;
}
table tr td {
	font-family: arial;
	font-size: 12px;
	padding: 3px;
}
.label {
	font-weight: bold;
	width: 30%;
}
</style>